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
use Symfony\Component\DomCrawler\Crawler;

class DownloadEventsOrderCommand extends Command
{
	protected $signature = 'send:download_events_order';
	private $url   = 'https://www.rastreadordepacotes.com.br/rastreio';
	private $sleep = 1500000;
	private $month = [
		'Janeiro'   => '01',
		'Fevereiro' => '02',
		'Março'     => '03',
		'Abril'     => '04',
		'Maio'      => '05',
		'Junho'     => '06',
		'Julho'     => '07',
		'Agosto'    => '08',
		'Setembro'  => '09',
		'Outubro'   => '10',
		'Novembro'  => '11',
		'Dezembro'  => '12',
	];
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
							'orders.type_integration as type_integration',
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
			$response = Http::get($this->getTransporter($order->type_integration, $order->object));
			
			$tmp = $response->object();
			
			if($response->status() != 200)
			{ 
				usleep($this->sleep);
				continue; 
			}
			
			// Getting the response content
			$html = (string)$response->getBody();
			
			// Creating the Crawler object using the obtained HTML
			$crawler = new Crawler($html);
		
			// Finding list with class 'is-hidden-tablet'
			$lista_de_events = $crawler->filter('ul.is-hidden-tablet')->first();
			
			// Iterating over each list item
			// Posted, send template delivered e concluded order
			$order_eventos = $lista_de_events->filter('li.columns')->each(function (Crawler $event) {
				$descriptionHtml = $event->filter('div.column')->html();
				$positionFirstBr = strpos($descriptionHtml, '<br>');
				$decription = $this->formatedDescription($descriptionHtml, $positionFirstBr);
				
				if(stripos($decription, 'ENTREGUE') !== false)
				{
					$date_order_event = $event->filter('span')->first()->text();
					$date_order_event = $this->formatedDateTime($date_order_event);
					
					$hour = $event->filter('span.has-text-grey-light')->first()->text();
					
					return [
						'decription'      => $decription,
						'date_order_event'=> $date_order_event,
						'hour'            => $hour,
						'status_event'    => 4,
					];
				}
			});
			
			if($order_eventos[0] && $order_eventos[0]['status_event'] == 4)
			{
				if(OrderEvent::where('date_event', $order_eventos[0]['date_order_event'].' '.$order_eventos[0]['hour'])->where('order_id', $order->id)->exists())
				{ usleep($this->sleep);return; }
				
				$template = $this->getTemplateByStatus($order->tenant_id, 4);
				
				$order_event = OrderEvent::create([
					'tenant_id'    => $order->tenant_id,
					'uuid'         => str::uuid(),
					'order_id'     => $order->id,
					'template_id'  => $template->id,
					'date_event'   => $order_eventos[0]['date_order_event'].' '.$order_eventos[0]['hour'],
					'status_event' => $order_eventos[0]['status_event'],
					'msg_event'    => $order_eventos[0]['decription'],
					'status_send'  => 0,
					'msg_send'     => "",
				]);
			
				$obj_data = (object) array(
					"order_event_id"          => $order_event->id,
					"integration_whatsapp_id" => $order->integration_whatsapp_id,
					"destination"             => $order->destination,
					"code"                    => $order->code,
					"shipping"                => $this->shipping[$order->type_integration],
					"msg_event"               => $order_eventos[0]['decription'],
					"whatsapp"                => $order->whatsapp,
					"object"                  => $order->object,
					"date_event"              => $order_eventos[0]['date_order_event'].' '.$order_eventos[0]['hour'],
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
				
				Order::where('id' , $order->id)->update(['last_situation' => $last_situation_event_order->status_event]);
				
				usleep($this->sleep);
				
				continue;
			}
			
			// Iterating over each list item
			$order_eventos = $lista_de_events->filter('li.columns')->each(function (Crawler $event) {
				// Getting the date, time and description information
				$date_order_event = $event->filter('span')->first()->text();
				$date_order_event = $this->formatedDateTime($date_order_event);
				
				$hour = $event->filter('span.has-text-grey-light')->first()->text();
				
				$descriptionHtml = $event->filter('div.column')->html();
				$positionFirstBr = strpos($descriptionHtml, '<br>');
				$decription = $this->formatedDescription($descriptionHtml, $positionFirstBr);
				
				if (stripos($decription, 'postado') !== false || stripos($decription, 'EMISSAO') !== false)
				{
					$status_event = '1';
				}
				else if(stripos($decription, 'encaminhado') !== false || stripos($decription, 'transferência') !== false ||
				stripos($decription, 'TRANSFERENCIA') !== false || stripos($decription, 'ENTRADA') !== false || stripos($decription, 'TRANSFERIDO') !== false
				)
				{
					$status_event = '2';
				}
				else if(stripos($decription, 'entrega') !== false || stripos($decription, 'EM ROTA') !== false)
				{
					$status_event = '3';
				}
				else if(stripos($decription, 'entregue') !== false || stripos($decription, 'ENTREGUE') !== false) 
				{
					$status_event = '4';
				}
				else 
				{
					return;
				}
				
				return [
					'decription'      => $decription,
					'date_order_event'=> $date_order_event,
					'hour'            => $hour,
					'status_event'    => $status_event,
				];
			});
			
			$order_eventos = array_reverse($order_eventos);
			
			foreach($order_eventos as $item)
			{
				if(OrderEvent::where('date_event', $item['date_order_event'].' '.$item['hour'])->where('order_id', $order->id)->exists())
				{ usleep($this->sleep);return; }
				
				$template = $this->getTemplateByStatus($order->tenant_id, $item['status_event']);
				
				$order_event = OrderEvent::create([
					'tenant_id'    => $order->tenant_id,
					'uuid'         => str::uuid(),
					'order_id'     => $order->id,
					'template_id'  => $template->id,
					'date_event'   => $item['date_order_event'].' '.$item['hour'],
					'status_event' => $item['status_event'],
					'msg_event'    => $item['decription'],
					'status_send'  => 0,
					'msg_send'     => "",
				]);
				
				$obj_data = (object) array(
					"order_event_id"          => $order_event->id,
					"integration_whatsapp_id" => $order->integration_whatsapp_id,
					"destination"             => $order->destination,
					"code"                    => $order->code,
					"shipping"                => $this->shipping[$order->type_integration],
					"msg_event"               => $item['decription'],
					"whatsapp"                => $order->whatsapp,
					"object"                  => $order->object,
					"date_event"              => $item['date_order_event'].' '.$item['hour'],
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
			
			$last_situation_event_order = OrderEvent::where('order_id', $order->id)->orderByDesc('id')->first();
			Order::where('id' , $order->id)->update(['last_situation' => $last_situation_event_order->status_event]);
			
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

	private function getTransporter($transport, $object)
	{
		switch($transport)
		{
			case '0':
				return $this->url.'/'.$object;
				break;
			case '1':
				return $this->url.'/jadlog/'.$object;
				break;
			default:
				return '';
				break;
		}
	}
	
	private function formatedDateTime($date_order_event)
	{
		$parts = explode(' ', $date_order_event);
		$month_order_event = $this->month[$parts[1]];
		$date_order_event = $parts[2].'-'.$month_order_event.'-'.Str::padLeft($parts[0], 2, '0');
		return $date_order_event;
	}

	private function formatedDescription($descriptionHtml, $positionFirstBr)
	{
		if ($positionFirstBr !== false)
		{
			$decription = trim(substr($descriptionHtml, $positionFirstBr + 4));
			$decription = str_ireplace(["\n", '"'], "", $decription);
			$decription = str_ireplace(["\n", '"'], "", $decription);
			$decription = str_ireplace("Ainda não recebeu o seu pacote? Clique", "", $decription);
			$decription = str_ireplace("<a href=https://www.rastreadordepacotes.com.br/blog/o-que-fazer/meu-pacote-esta-entregue-mas-nao-recebi.html>AQUI</a>.", "", $decription);
			$decription = str_ireplace(".", "", $decription);
			$decription = str_ireplace("AQUI", "", $decription);
			$decription =  rtrim($decription, "<br>");
			$decription = preg_replace('/<br\s*\/?>/', "\n", $decription);
			return $decription;
		}
		else
		{
			usleep($this->sleep);
			return false; 
		}
	}
}
