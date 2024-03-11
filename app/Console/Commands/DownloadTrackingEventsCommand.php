<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
	Tracking,
	TrackingEvent,
	Template
};
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use App\Jobs\SendNotificationTrackingWhatsAppJob;

class DownloadTrackingEventsCommand extends Command
{
	protected $signature = 'send:download_tracking_events';
	
	protected $description = 'Comando para efetuar o download dos eventos de cada rastreio e envia para fila para disparo.';
	
	public function handle()
	{
		$trackings = Tracking::select(
								'trackings.tenant_id as tenant_id',
								'trackings.destination as destination',
								'trackings.id as id',
								'trackings.whatsapp as whatsapp',
								'trackings.object as object',
								'trackings.situation as situation',
								'integration_whatsapp.id as integration_whatsapp_id'
						)
						->join('integration_whatsapp', 'integration_whatsapp.tenant_id', '=', 'trackings.tenant_id')
						->where('trackings.situation', '0')
						->orWhere('trackings.situation', '1')
						->get();
		
		if ($trackings->isEmpty())
		{
			return false;
		}
		
		foreach ($trackings as $key => $tracking)
		{
			$response = Http::get('https://api.linketrack.com/track/json?user='.config('app.api_link_track_user').'&token='.config('app.api_link_track_secret_key').'&codigo='.$tracking->object.'');
			
			$tmp = $response->object();
			
			if($response->status() != 200){ continue; }
			
			// Posted and delivered, send template delivreed e concluded tracking
			$posted = 0;
			$delivered = 0;
			foreach ($tmp->eventos as $event)
			{
				if(stripos($event->status, 'postado') !== false)
				{
					$posted = 1;
				}
				if(stripos($event->status, 'entregue') !== false)
				{
					$delivered = 1;
					$msg_event = $event->status.' - '.$event->local;
					$date_hour_event = Carbon::createFromFormat('d/m/Y', $event->data)->format('Y-m-d').' '.$event->hora;
				}
			}
			
			if($posted == 1 && $delivered == 1)
			{
				if(TrackingEvent::where('date_event', $date_hour_event)->where('tracking_id', $tracking->id)->exists()){ continue; }
				
				$template = $this->getTemplateByStatus($tracking->tenant_id, 4);
				
				$tracking_event = TrackingEvent::create([
					'tenant_id'    => $tracking->tenant_id,
					'uuid'         => str::uuid(),
					'tracking_id'  => $tracking->id,
					'template_id'  => $template->id,
					'date_event'   => $date_hour_event,
					'status_event' => 4,
					'msg_event'    => $msg_event,
					'status_send'  => 0,
					'msg_send'     => "",
				]);
				
				Tracking::where('id' , $tracking->id)->update(['situation' => 2]);
				
				$obj_data = (object) array(
					"tracking_event_id"       => $tracking_event->id,
					"integration_whatsapp_id" => $tracking->integration_whatsapp_id,
					"destination"             => $tracking->destination,
					"msg_event"               => $msg_event,
					"whatsapp"                => $tracking->whatsapp,
					"object"                  => $tracking->object,
					"date_event"              => $date_hour_event,
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
				
				SendNotificationTrackingWhatsAppJob::dispatch($obj_data);
				continue;
			}
			
			foreach($tmp->eventos as $item)
			{
				$date_hour = Carbon::createFromFormat('d/m/Y', $item->data)->format('Y-m-d').' '.$item->hora;
				
				if(TrackingEvent::where('date_event', $date_hour)->where('tracking_id', $tracking->id)->exists()){ continue; }
				
				if (stripos($item->status, 'postado') !== false)
				{
					$status_event = '1';
					$msg_event    = $item->status.' - '.$item->local;
				}
				else if(stripos($item->status, 'encaminhado') !== false)
				{
					$status_event = '2';
					$msg_event    = $item->status.' - '.$item->subStatus[1];
				}
				else if(stripos($item->status, 'entrega') !== false)
				{
					$status_event = '3';
					$msg_event    = $item->status.' - '.$item->local;
				}
				else if(stripos($item->status, 'entregue') !== false)
				{
					$status_event = '4';
					$msg_event    = $item->status.' - '.$item->local;
				}
				else 
				{
					continue;
				}
				
				$template = $this->getTemplateByStatus($tracking->tenant_id, $status_event);
				
				$tracking_event = TrackingEvent::create([
					'tenant_id'    => $tracking->tenant_id,
					'uuid'         => str::uuid(),
					'tracking_id'  => $tracking->id,
					'template_id'  => $template->id,
					'date_event'   => $date_hour,
					'status_event' => $status_event,
					'msg_event'    => $msg_event,
					'status_send'  => 0,
					'msg_send'     => "",
				]);
				
				if($status_event == 4)
				{
					Tracking::where('id' , $tracking->id)->update(['situation' => 2]);
				}
				else
				{
					Tracking::where('id' , $tracking->id)->update(['situation' => 1]);
				}
				
				$obj_data = (object) array(
					"tracking_event_id"       => $tracking_event->id,
					"integration_whatsapp_id" => $tracking->integration_whatsapp_id,
					"destination"             => $tracking->destination,
					"whatsapp"                => $tracking->whatsapp,
					"object"                  => $tracking->object,
					"date_event"              => $date_hour,
					"msg_event"               => $msg_event,
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
				
				SendNotificationTrackingWhatsAppJob::dispatch($obj_data);
			}
			
			sleep(1);
		}
	}

	public function getTemplateByStatus($tenant_id, $status_event)
	{
		return Template::where('type', $status_event)
									->where('situation', 1)
									->where('tenant_id', $tenant_id)
									->first();
	}
}
