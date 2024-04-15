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
use Illuminate\Support\Facades\Log;

class DownloadEventsOrderCommand extends Command
{
	protected $signature = 'send:download_events_order';
	private $url   = 'https://app.rastreiozap.com/api/external/v1/order/tracking';
	private $sleep = 4000;
	private $shipping = [
		0 => 'Correios',
		1 => 'JadLog',
		2 => 'JeT',
		3 => 'LATAM Cargo',
		4 => 'Loggi',
	];
	protected $description = 'Comando para efetuar o download dos pedidos de cada rastreio e envia para fila para disparo.';
	
	public function handle()
	{
		$orders = Order::select(
							'orders.tenant_id as tenant_id',
							'orders.code as code',
							'orders.cpf_cnpj as cpf_cnpj',
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
				'Authorization' => 'Bearer '.config('app.api_rastreio_zap_token')
			])->post($this->url, [
				'tracking_code' => $order->object,
				'carrier_id'    => $this->getTransporter($order->shipping_company),
				'simplification' => false,
				'cpf_cnpj'      => $order->shipping_company == 2 ? $order->cpf_cnpj : false,
			]);
			
			$events = $response->object();
			
			if($response->status() != 200)
			{
				usleep($this->sleep);
				continue; 
			}
			
			if (!isset($events->data->occurrences) || empty($events->data->occurrences))
			{
				continue;
			}
			
			$occurrences         = $events->data->occurrences;
			$occurrences         = array_reverse($occurrences);
			
			foreach($occurrences as $order_event)
			{
				$dataHourOrderEvent = Carbon::createFromFormat('d/m/Y H:i', $order_event->date.' '.$order_event->hour);
				$dateHourOrderEventFormat = $dataHourOrderEvent->format('Y-m-d H:i:s');
				
				$descriptionOrderEvent = $order_event->action.'. '.$order_event->location;
				
				// Filtrando o array "occurrences" para encontrar a palavra "entregue" na chave "action"
				$result = $this->getStatusEventDeliveredOrder($occurrences);
				
				if ($result == true)
				{
					$descriptionOrderEvent = $occurrences[$events->data->update -1]->action.'. '.$occurrences[$events->data->update -1]->location;
					
					if(OrderEvent::where('date_event', $dateHourOrderEventFormat)->where('status_event', 4)->where('order_id', $order->id)->exists())
					{ usleep($this->sleep); return; }
					
					$template = $this->getTemplateByStatus($order->tenant_id, 4);
					
					if(!$template)
					{
						continue;
					}

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
						"cpf_cnpj"                => $order->cpf_cnpj,
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
				
				switch($order->shipping_company)
				{
					// Correios
					case '0':
						$status_event = $this->getStatusEventCorreios($order_event->action);
						break;
					// JadLog
					case '1':
						$status_event = $this->getStatusEventJadLog($order_event->action);
						break;
					// Jet Express
					case '2':
						$status_event = $this->getStatusEventJetExpress($order_event->action);
						break;
					// Latam Cargo
					case '3':
						$status_event = $this->getStatusEventLatamCargo($order_event->action);
						break;
					// Loggi
					case '4':
						$status_event = $this->getStatusEventLoggi($order_event->action);
						break;
					default:
						break;
				}
				
				if(is_null($status_event))
				{
					continue;
				}
				
				$dateNow = Carbon::now()->startOfDay();
				$dateOrderEvent = Carbon::parse($dateHourOrderEventFormat)->startOfDay();
				
				if ($dateOrderEvent->lessThan($dateNow))
				{
					continue;
				}
				
				if(OrderEvent::where('date_event', $dateHourOrderEventFormat)->where('status_event', $status_event)->where('order_id', $order->id)->exists()){ continue; }
				
				$template = $this->getTemplateByStatus($order->tenant_id, $status_event);
				
				if(!$template)
				{
					continue;
				}
				
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
					"cpf_cnpj"                => $order->cpf_cnpj,
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
			// J&T Express
			case '2':
				return '21';
				break;
			// Latam Cargo
			case '3':
				return '7';
				break;
			// Loggi
			case '4':
				return '20';
				break;
		}
	}
	
	private function getStatusEventCorreios($action)
	{
		$events =  array(
			'Objeto postado'                           => '1',
			'Objeto em trânsito - por favor aguarde'   => '2',
			'Objeto saiu para entrega ao destinatário' => '3',
			'Objeto entregue ao destinatário'          => '4'
		);
		
		if (array_key_exists(trim($action), $events))
		{
			return $events[$action];
		}
		else
		{
			return null;
		}
	}
	
	private function getStatusEventJetExpress($action)
	{
		$events =  array(
			'Objeto coletado'    => '1',
			'Em trânsferencia'   => '2',
			'Chegada em unidade' => '2',
			'Saiu para entrega'  => '3',
		);
		
		if (array_key_exists(trim($action), $events))
		{
			return $events[$action];
		}
		else
		{
			return null;
		}
	}

	private function getStatusEventJadLog($action)
	{
		$events =  array(
			'Emissao'                  => '1',
			'Transferencia'            => '2',
			'Entrada'                  => '2',
			'Transferido para unidade' => '2',
			'Em rota'                  => '3',
		);
		
		if (array_key_exists(trim($action), $events))
		{
			return $events[$action];
		}
		else
		{
			return null;
		}
	}

	private function getStatusEventLoggi($action)
	{
		$events =  array(
			'CT-e emitido'       => '1',
			'Em transferência'   => '2',
			'Objeto coletado'    => '2',
			'Saiu para entrega'  => '3',
		);
		
		if (array_key_exists(trim($action), $events))
		{
			return $events[$action];
		}
		else
		{
			return null;
		}
	}

	private function getStatusEventLatamCargo($action)
	{
		$events =  array(
			'Postado'                                => '1',
			'Seu pacote está aguardando desembarque' => '2',
			'Seu pacote embarcou no veículo'         => '2',
			'Seu pacote está separado para embarque' => '2',
			'CTe do pacote emitido'                  => '2',
			'Seu pacote chegou na transportadora'    => '3',
		);
		
		if (array_key_exists(trim($action), $events))
		{
			return $events[$action];
		}
		else
		{
			return null;
		}
	}
	
	private function getStatusEventDeliveredOrder($occurrences)
	{
		$result = array_filter($occurrences, function($occurrence) {
			$keywords = ['Objeto entregue ao destinatário', 'Pedido entregue', 'Entregue ao destinatário', 'Entregue', 'Seu pacote foi entregue'];
			foreach ($keywords as $keyword) {
				if (strpos($occurrence->action, $keyword) !== false)
				{
					return true;
				}
			}
			return false;
		});
		
		return $result;
	}
}
