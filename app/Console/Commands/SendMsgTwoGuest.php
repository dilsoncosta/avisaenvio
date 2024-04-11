<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\{
	Guest,
	Template
};
use App\Jobs\SendNotificationGuestWhatsAppJob;

class SendMsgTwoGuest extends Command
{
	protected $signature = 'send:send_msg_two_guest';
	protected $description = 'Comando para efetuar o registro e disparo do segundo envio de notificacao do hospede.';
	
	public function handle()
	{
		$guests = Guest::select(
							'guests.id as id',
							'guests.tenant_id as tenant_id',
							'guests.name_surname as name_surname',
							'guests.whatsapp as whatsapp',
							'guests.date_checkin as date_checkin',
							'guests.date_checkout as date_checkout',
							'hospitalities.ind_msg_2 as ind_msg_2',
							'hospitalities.msg_2_template_id as msg_2_template_id',
							'integration_whatsapp.id as integration_whatsapp_id'
						)
						->join('hospitalities', 'hospitalities.id', '=', 'guests.hospitality_id')
						->join('integration_whatsapp', 'integration_whatsapp.tenant_id', '=', 'guests.tenant_id')
						->where('guests.msg_2_status_send', '!=' ,'1')
						->where('hospitalities.ind_msg_2', '!=' ,'0')
						->whereRaw('
								CASE
									WHEN hospitalities.ind_msg_2 = 1 THEN DATE_SUB(guests.date_checkin, INTERVAL 1 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 2 THEN DATE_SUB(guests.date_checkin, INTERVAL 2 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 3 THEN DATE_SUB(guests.date_checkin, INTERVAL 3 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 4 THEN DATE_SUB(guests.date_checkin, INTERVAL 4 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 5 THEN DATE_SUB(guests.date_checkin, INTERVAL 5 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 6 THEN DATE_SUB(guests.date_checkin, INTERVAL 6 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 7 THEN DATE_SUB(guests.date_checkin, INTERVAL 7 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 8 THEN DATE_SUB(guests.date_checkin, INTERVAL 15 DAY) = DATE(NOW())
									WHEN hospitalities.ind_msg_2 = 9 THEN DATE_SUB(guests.date_checkin, INTERVAL 1 MONTH) = DATE(NOW())
									ELSE FALSE
								END
						')
						->get();
		
		if ($guests->isEmpty())
		{
			return false;
		}
		
		foreach ($guests as $key => $item)
		{
			$template = $this->getTemplateById($item->msg_2_template_id);

			$obj_data = (object) array(
				"type_send"               => 2,
				"ind_msg"                 => $item->ind_msg_2,
				"template_id"             => $item->msg_2_template_id,
				"guest_id"                => $item->id,
				"integration_whatsapp_id" => $item->integration_whatsapp_id,
				"name_surname"            => $item->name_surname,
				"whatsapp"                => $item->whatsapp,
				"object"                  => $item->object,
				"date_checkin"            => $item->date_checkin,
				"date_checkout"           => $item->date_checkout,
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
			
			SendNotificationGuestWhatsAppJob::dispatch($obj_data);
		}
	}
	
	public function getTemplateById($id)
	{
		return Template::where('situation', 1)
									->where('id', $id)
									->first();
	}
}
