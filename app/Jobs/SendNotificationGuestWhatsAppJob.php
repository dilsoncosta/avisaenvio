<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\ApiWhatsApp;
use App\Helpers\Helpers;
use App\Models\{
	Guest,
	IntegrationWhatsApp
};
use Carbon\Carbon;

class SendNotificationGuestWhatsAppJob implements ShouldQueue
{
	use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
	
	public $tries = 3;
	
	public $data;
	
	public function __construct($data)
	{
		$this->data = $data;
	} 
	
	public function handle()
	{
		$msg_txt = $cap = $msg_id = '';
		
		$model_integration_whatsappp = new IntegrationWhatsApp();
		$integration_whatsapp = $model_integration_whatsappp->where('id', $this->data->integration_whatsapp_id)->first();
		
		if(!$integration_whatsapp)
		{
			$this->setMessageSend(array(
				'status_send' => 2,
				'msg_send'    => 'Integração WhatsApp Inexistente.',
			), $this->data->guest_id);
			return false;
		}
		
		$api_whatsapp = new ApiWhatsApp();
		
		$api_whatsapp->setUrl($integration_whatsapp->url);
		$api_whatsapp->setSessionName($integration_whatsapp->session_name);
		$api_whatsapp->setSessionKey($integration_whatsapp->app_key);
		$api_whatsapp->setNumberIntegration($integration_whatsapp->whatsapp);
		$api_whatsapp->setDelay(1000);
		
		if(empty($this->data->whatsapp))
		{
			$this->setMessageSend(array(
				'status_send' => 2,
				'msg_send'    => 'Número do whatsapp não encontrado!',
			), $this->data->guest_id);
			return false;
		}
		
		$api_whatsapp->setNumberContact($this->data->whatsapp);
		$status_whatsapp = $api_whatsapp->getStatusWhatsApp();
		
		if($status_whatsapp->status == '0')
		{
			$this->setMessageSend(array(
				'status_send' => 2,
				'msg_send'    => 'Incapaz de consultar o status da conexão whatsapp.',
			), $this->data->guest_id);
			return false;
		}
		else
		{
			if($status_whatsapp->status_whatsapp != 'connected')
			{
				$this->setMessageSend(array(
					'status_send' => 2,
					'msg_send'    => 'Integração WhatsApp Off-line.',
				), $this->data->guest_id);
				return false;
			}
		}
		
		$validated_whatsapp = $api_whatsapp->getValidWhatsApp();
		
		if($validated_whatsapp->status == '0')
		{
			$this->setMessageSend(array(
				'status_send' => 2,
				'msg_send'    => 'Incapaz de validar o número de whatsapp.',
			), $this->data->guest_id);
			return false;
		}
		else
		{
			if($validated_whatsapp->exists == false)
			{
				$this->setMessageSend(array(
					'status_send' => 2,
					'msg_send'    => 'Número não registrado no WhatsApp.',
				), $this->data->guest_id);
				return false;
			}
		}
		
		if(!empty($this->data->message))
		{
			$template = str_replace('[NOME_SOBRENOME]',  ucwords(strtolower($this->data->name_surname)), $this->data->message);
			$template = str_replace('[DATA CHECK_IN]', Carbon::createFromFormat('Y-m-d', $this->data->date_checkin)->format('d/m/Y'), $template);
			$template = str_replace('[DATA CHECK_OUT]', Carbon::createFromFormat('Y-m-d', $this->data->date_checkout)->format('d/m/Y'), $template);
			$template = str_replace('[WHATSAPP]', Helpers::formata_telefone($this->data->whatsapp), $template);
			$api_whatsapp->setMsg($template);
			$send_text = $api_whatsapp->setSendMessageWhatsApp();
			
			if($send_text->status == '0')
			{
				$msg_txt .= 'Mensagem:'.$send_text->message.'; ';
			}
			else
			{
				$msg_id .= $send_text->msg_id;
			}
		}
		
		if(!empty($this->data->file_1))
		{
			if(config('app.api_whatsapp_ambiente') == 'hmg')
			{
				$api_whatsapp->setFileName(config('app.api_whatsapp_filename1'));
				$api_whatsapp->setMediaFile(config('app.api_whatsapp_file1'));
				$send_file_1 = $api_whatsapp->setSendArchiveWhatsApp();
			}
			else
			{
				$api_whatsapp->setFileName($this->data->filename_1);
				$api_whatsapp->setMediaFile(config('app.url').'/storage/'.$this->data->file_1);
				$send_file_1 = $api_whatsapp->setSendArchiveWhatsApp();
			}
			
			if($send_file_1->status == '0')
			{
				$msg_txt .= 'Arquivo #1:'.$send_file_1->message.'; ';
			}
			else
			{
				if(!empty($msg_id)){ $cap=','; } else { $cap=''; }
				$msg_id .= $cap.$send_file_1->msg_id;
			}
		}
		
		if(!empty($this->data->file_2))
		{
			if(config('app.api_whatsapp_ambiente') == 'hmg')
			{
				$api_whatsapp->setFileName(config('app.api_whatsapp_filename2'));
				$api_whatsapp->setMediaFile(config('app.api_whatsapp_file2'));
				$send_file_2 = $api_whatsapp->setSendArchiveWhatsApp();
			}
			else
			{
				$api_whatsapp->setFileName($this->data->filename_2);
				$api_whatsapp->setMediaFile(config('app.url').'/storage/'.$this->data->file_2);
				$send_file_2 = $api_whatsapp->setSendArchiveWhatsApp();
			}
			
			if($send_file_2->status == '0')
			{
				$msg_txt .= 'Arquivo #2:'.$send_file_2->message.'; ';
			}
			else
			{
				if(!empty($msg_id)){ $cap=','; } else { $cap=''; }
				$msg_id .= $cap.$send_file_2->msg_id;
			}
		}
		
		if(!empty($this->data->file_3))
		{
			if(config('app.api_whatsapp_ambiente') == 'hmg')
			{
				$api_whatsapp->setFileName(config('app.api_whatsapp_filename3'));
				$api_whatsapp->setMediaFile(config('app.api_whatsapp_file3'));
				$send_file_3 = $api_whatsapp->setSendArchiveWhatsApp();
			}
			else
			{
				$api_whatsapp->setFileName($this->data->filename_3);
				$api_whatsapp->setMediaFile(config('app.url').'/storage/'.$this->data->file_3);
				$send_file_3 = $api_whatsapp->setSendArchiveWhatsApp();
			}
			
			if($send_file_3->status == '0')
			{
				$msg_txt .= 'Arquivo #3:'.$send_file_3->message.'; ';
			}
			else
			{
				if(!empty($msg_id)){ $cap=','; } else { $cap=''; }
				$msg_id .= $cap.$send_file_3->msg_id;
			}
		}
		
		if(empty($msg_txt))
		{
			$this->setMessageSend(array(
				'status_send' => 1,
				'msg_send'    => '',
			), $this->data->guest_id);
			return true;
		}
		else
		{
			$this->setMessageSend(array(
				'status_send' => 2,
				'msg_send'    => $msg_txt,
			), $this->data->guest_id);
			return false;
		}
	}
	
	private function setMessageSend($data, $id)
	{
		$model_tracking_event = new Guest();
		$query = $model_tracking_event->where('id', $id);
		if($this->data->type_send == 1)
		{
			$query->update([
				'ind_msg_1'         => $this->data->ind_msg,
				'msg_1_template_id' => $this->data->template_id,
				'msg_1_status_send' => $data['status_send'],
				'msg_1_msg_send'    => $data['msg_send'],
			]);
		}
		if($this->data->type_send == 2)
		{
			$query->update([
				'ind_msg_2'         => $this->data->ind_msg,
				'msg_2_template_id' => $this->data->template_id,
				'msg_2_status_send' => $data['status_send'],
				'msg_2_msg_send'    => $data['msg_send'],
			]);
		}
		if($this->data->type_send == 3)
		{
			$query->update([
				'ind_msg_3'         => $this->data->ind_msg,
				'msg_3_template_id' => $this->data->template_id,
				'msg_3_status_send' => $data['status_send'],
				'msg_3_msg_send'    => $data['msg_send'],
			]);
		}
		if($this->data->type_send == 4)
		{
			$query->update([
				'ind_msg_4'         => $this->data->ind_msg,
				'msg_4_template_id' => $this->data->template_id,
				'msg_4_status_send' => $data['status_send'],
				'msg_4_msg_send'    => $data['msg_send'],
			]);
		}
		if($this->data->type_send == 5)
		{
			$query->update([
				'ind_msg_5'         => $this->data->ind_msg,
				'msg_5_template_id' => $this->data->template_id,
				'msg_5_status_send' => $data['status_send'],
				'msg_5_msg_send'    => $data['msg_send'],
			]);
		}
		if($this->data->type_send == 6)
		{
			$query->update([
				'ind_msg_6'         => $this->data->ind_msg,
				'msg_6_template_id' => $this->data->template_id,
				'msg_6_status_send' => $data['status_send'],
				'msg_6_msg_send'    => $data['msg_send'],
			]);
		}
	}
}
