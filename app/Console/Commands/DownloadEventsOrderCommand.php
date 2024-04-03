<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
	Order,
	OrderEvent,
	Template
};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendNotificationOrderWhatsAppJob;
use Carbon\Carbon;

class DownloadEventsOrderCommand extends Command
{
	protected $signature = 'send:download_events_order';
	private $url   = 'https://app.rastreiozap.com/api/external/v1/order/tracking';
	private $token = config('app.api_rastreio_zap_token');
	private $sleep = 4000;
	private $shipping = [
		0 => 'Correio',
		1 => 'JadLog'
	];
	protected $description = 'Comando para efetuar o download dos pedidos de cada rastreio e envia para fila para disparo.';
	
	public function handle()
	{
		$orders = Order::select(
							'orders.tenant_id as tenant_id',
							'orders.code as code',
							'orders.destination as destination',
							'orders.id as id',
							'orders.whatsapp as whatsapp',
							'orders.object as object',
							'orders.integration as integration',
							'orders.shipping_company as shipping_company',
							'orders.last_situation as last_situation',
							'integration_whatsapp.id as integration_whatsapp_id'
						)
						->join('integration_whatsapp', 'integration_whatsapp.tenant_id', '=', 'orders.tenant_id')
						->where('orders.last_situation', '<','4')
						->get();
		
		if ($orders->isEmpty())
		{
			return false;
		}
		
		foreach ($orders as $key => $order)
		{
			$response = Http::withHeaders([
				'Content-Type'  => 'application/json',
				'Accept'        => 'application/json',
				'Authorization' => 'Bearer '.$this->token
			])->post($this->url, [
				'tracking_code' => $order->object,
				'carrier_id'    => $this->getTransporter($order->shipping_company),
				'simplification' => false
			]);
			
			$events = $response->object();
			
			if($response->status() != 200)
			{ 
				usleep($this->sleep);
				continue; 
			}

			if (!isset($events->data->occurrences) || empty($events->data->occurrences)) {
				continue;
			}
			
			$occurrences = $events->data->occurrences;
			$occurrences = array_reverse($occurrences);
			
			foreach($occurrences as $order_event)
			{
				$dataHourOrderEvent = Carbon::createFromFormat('d/m/Y H:i', $order_event->date.' '.$order_event->hour);
				$dateHourOrderEventFormat = $dataHourOrderEvent->format('Y-m-d H:i:s');
				
				$descriptionOrderEvent = $order_event->action.'. '.$order_event->location;
				
				// Filtrando o array "occurrences" para encontrar a palavra "entregue" na chave "action"
				$result = array_filter($events->data->occurrences, function($occurrence) {
					return strpos($occurrence->action, 'entregue') !== false;
				});
				
				if ($result == true)
				{
					if(OrderEvent::where('date_event', $dateHourOrderEventFormat)->where('order_id', $order->id)->exists())
					{ usleep($this->sleep); return; }
					
					$template = $this->getTemplateByStatus($order->tenant_id, 4);
					
					$order_event = OrderEvent::create([
						'tenant_id'    => $order->tenant_id,
						'uuid'         => str::uuid(),
						'order_id'     => $order->id,
						'template_id'  => $template->id,
						'date_event'   => $dateHourOrderEventFormat,
						'status_event' => 4,
						'msg_event'    => $descriptionOrderEvent,
						'status_send'  => 0,
						'msg_send'     => "",
					]);
				
					$obj_data = (object) array(
						"order_event_id"          => $order_event->id,
						"integration_whatsapp_id" => $order->integration_whatsapp_id,
						"destination"             => $order->destination,
						"code"                    => $order->code,
						"shipping"                => $this->shipping[$order->shipping_company],
						"msg_event"               => $descriptionOrderEvent,
						"whatsapp"                => $order->whatsapp,
						"object"                  => $order->object,
						"date_event"              => $dateHourOrderEventFormat,
						"message"                 => $template->message,
						"filename_1"              => $template->filename_1,
						"filename_storage_1"      => $template->filename_storage_1,
						"file_1"                  => $template->file_1,
						"ext_1"                   => $template->ext_1,
						"size_1"                  => $template->size_1,
						"filename_2"              => $template->filename_2,
						"filename_storage_2"      => $template->filename_storage_2,
						"file_2"                  => $template->file_2,
						"ext_2"                   => $template->ext_2,
						"size_2"                  => $template->size_2,
						"filename_3"              => $template->filename_3,
						"filename_storage_3"      => $template->filename_storage_3,
						"file_3"                  => $template->file_3,
						"ext_3"                   => $template->ext_3,
						"size_3"                  => $template->size_3,
					);
					
					SendNotificationOrderWhatsAppJob::dispatch($obj_data);
					
					$last_situation_event_order = OrderEvent::where('order_id', $order->id)->orderByDesc('id')->first();
					
					if($last_situation_event_order)
					{
						Order::where('id' , $order->id)->update(['last_situation' => $last_situation_event_order->status_event]);
					}
					
					usleep($this->sleep);
					
					return;
				}
				
				if (stripos($descriptionOrderEvent, 'postado') !== false || stripos($descriptionOrderEvent, 'Emissao') !== false)
				{
					$status_event = '1';
				}
				else if(stripos($descriptionOrderEvent, 'encaminhado') !== false || stripos($descriptionOrderEvent, 'transferência') !== false ||
				stripos($descriptionOrderEvent, 'Transferido') !== false || stripos($descriptionOrderEvent, 'Transferencia') !== false || stripos($descriptionOrderEvent, 'Entrada') !== false
				)
				{
					$status_event = '2';
				}
				else if(stripos($descriptionOrderEvent, 'entrega') !== false || stripos($descriptionOrderEvent, 'Em rota') !== false)
				{
					$status_event = '3';
				}
				else if(stripos($descriptionOrderEvent, 'entregue') !== false || stripos($descriptionOrderEvent, 'Entregue') !== false) 
				{
					$status_event = '4';
				}
				else 
				{
					continue;
				}
				
				$dateNow = Carbon::now()->startOfDay();
				$dateOrderEvent = Carbon::parse($dateHourOrderEventFormat)->startOfDay();
				
				if ($dateOrderEvent->lessThan($dateNow))
				{
					continue;
				}
				
				if(OrderEvent::where('date_event', $dateHourOrderEventFormat)->where('order_id', $order->id)->exists()){ continue; }
				
				$template = $this->getTemplateByStatus($order->tenant_id, $status_event);
				
				$order_event = OrderEvent::create([
					'tenant_id'    => $order->tenant_id,
					'uuid'         => str::uuid(),
					'order_id'     => $order->id,
					'template_id'  => $template->id,
					'date_event'   => $dateHourOrderEventFormat,
					'status_event' => $status_event,
					'msg_event'    => $descriptionOrderEvent,
					'status_send'  => 0,
					'msg_send'     => "",
				]);
				
				$obj_data = (object) array(
					"order_event_id"          => $order_event->id,
					"integration_whatsapp_id" => $order->integration_whatsapp_id,
					"destination"             => $order->destination,
					"code"                    => $order->code,
					"shipping"                => $this->shipping[$order->shipping_company],
					"msg_event"               => $descriptionOrderEvent,
					"whatsapp"                => $order->whatsapp,
					"object"                  => $order->object,
					"date_event"              => $dateHourOrderEventFormat,
					"message"                 => $template->message,
					"filename_1"              => $template->filename_1,
					"filename_storage_1"      => $template->filename_storage_1,
					"file_1"                  => $template->file_1,
					"ext_1"                   => $template->ext_1,
					"size_1"                  => $template->size_1,
					"filename_2"              => $template->filename_2,
					"filename_storage_2"      => $template->filename_storage_2,
					"file_2"                  => $template->file_2,
					"ext_2"                   => $template->ext_2,
					"size_2"                  => $template->size_2,
					"filename_3"              => $template->filename_3,
					"filename_storage_3"      => $template->filename_storage_3,
					"file_3"                  => $template->file_3,
					"ext_3"                   => $template->ext_3,
					"size_3"                  => $template->size_3,
				);
				
				SendNotificationOrderWhatsAppJob::dispatch($obj_data);
			}
			
			$last_situation_event_order = OrderEvent::where('order_id', $order->id)->orderBy('id', 'DESC')->first();
				
			if($last_situation_event_order)
			{
				Order::where('id' , $order->id)->update(['last_situation' => $last_situation_event_order->status_event]);
			}
			
			usleep($this->sleep);
		}
	}
	
	public function getTemplateByStatus($tenant_id, $status_event)
	{
		return Template::where('type', $status_event)
									->where('situation', 1)
									->where('tenant_id', $tenant_id)
									->first();
	}
 
	private function getTransporter($transport)
	{
		switch($transport)
		{
			// Correios (código de rastreio nacional)
			case '0':
				return '1';
				break;
			// JadLog
			case '1':
				return '2';
				break;
			// Azul Cargo
			case '2':
				return '4';
				break;
			// Kangu
			case '3':
				return '5';
				break;
			// Latam Cargo	
			case '4':
				return '7';
				break;
			// ViaBrasil
			case '5':
				return '8';
				break;
			// Braspress
			case '6':
				return '10';
				break;
			// Mandaê
			case '7':
				return '12';
				break;
			// SmartEnvios
			case '8':
				return '16';
				break;
			default:
				return '';
				break;
		}
	}
}
