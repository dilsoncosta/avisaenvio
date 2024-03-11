<?php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiWhatsApp
{
	private string $url;
	private string $session_name;
	private string $session_key;
	private string $numberIntegration;
	private string $msg;
	private string $numberContact;
	private string $filename;
	private string $mediaFile;
	private int $delay;
	
	/**
	* Get the value of url
	*/
	public function getUrl(): string
	{
		return $this->url;
	}
	
	/**
	* Set the value of url
	*/
	public function setUrl($url): self
	{
		$this->url = $url;
		
		return $this;
	}
	
	/**
	* Get the value of delay
	*/
	public function getDelay(): int
	{
		return $this->delay;
	}
	
	/**
	* Set the value of delay
	*/
	public function setDelay($delay): self
	{
		$this->delay = $delay;
		
		return $this;
	}

	/**
	* Get the value of session_name
	*/
	public function getSessionName(): string
	{
		return $this->session_name;
	}
	
	/**
	* Set the value of session_name
	*/
	public function setSessionName($session_name): self
	{
		$this->session_name = $session_name;
		
		return $this;
	}

	/**
	* Get the value of session_key
	*/
	public function getSessionKey(): string
	{
		return $this->session_key;
	}

	/**
	* Set the value of session_key
	*/
	public function setSessionKey($session_key): self
	{
		$this->session_key = $session_key;
		
		return $this;
	}

	/**
	* Get the value of numberIntegration
	*/
	public function getNumberIntegration(): string
	{
		return $this->numberIntegration;
	}

	/**
	* Set the value of numberIntegration
	*/
	public function setNumberIntegration($numberIntegration): self
	{
		$this->numberIntegration = $numberIntegration;
		
		return $this;
	}

	/**
	* Get the value of msg
	*/
	public function getMsg(): string
	{
		return $this->msg;
	}

	/**
	* Set the value of msg
	*/
	public function setMsg($msg): self
	{
		$this->msg = $msg;
		
		return $this;
	}
	
	/**
	* Get the value of filename
	*/
	public function getFileName(): string
	{
		return $this->filename;
	}
	
	/**
	* Set the value of filename
	*/
	public function setFileName($filename): self
	{
		$this->filename = $filename;
		
		return $this;
	}
	
	/**
	* Get the value of mediaFile
	*/
	public function getMediaFile(): string
	{
		return $this->mediaFile;
	}
	
	/**
	* Set the value of mediaFile
	*/
	public function setMediaFile($mediaFile): self
	{
		$this->mediaFile = $mediaFile;
		
		return $this;
	}
	
	/**
	* Get the value of numberContact
	*/
	public function getNumberContact(): string
	{
		return $this->numberContact;
	}

	/**
	* Set the value of numberContact
	*/
	public function setNumberContact($numberContact): self
	{
		$this->numberContact = $numberContact;
		
		return $this;
	}
	
	/**
	* createTokenWhatsApp
	* @return object
	*/
	public function createTokenWhatsApp() : object
	{
		if(empty($this->getSessionName()) || empty($this->getSessionKey()) 
		|| empty($this->getNumberIntegration()) || empty($this->getUrl()))
		{
			return (object) [
					'status' => '0',
					'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'apikey'       => $this->getSessionKey(),
		])->post($this->getUrl().'/instance/create', [
				"instanceName"      => $this->getSessionName(),
				"token"             => $this->getSessionName(),
				"qrcode"            => true,
				"webhook"           => config('app.api_whatsapp_ambiente') == 'hmg' ? config('app.api_whatsapp_webhook_hmg') : config('app.api_whatsapp_webhook_prd'),
    		"webhook_by_events" => true,
				"number"            => $this->getNumberIntegration(),
				"websocket_enabled" => true,
				"websocket_events"  => [
					// "APPLICATION_STARTUP",
					"QRCODE_UPDATED",
					// "MESSAGES_SET",
					//"MESSAGES_UPSERT",
					//"MESSAGES_UPDATE",
					//"MESSAGES_DELETE",
					//"SEND_MESSAGE",
					// "CONTACTS_SET",
					// "CONTACTS_UPSERT",
					// "CONTACTS_UPDATE",
					// "PRESENCE_UPDATE",
					// "CHATS_SET",
					// "CHATS_UPSERT",
					// "CHATS_UPDATE",
					// "CHATS_DELETE",
					// "GROUPS_UPSERT",
					// "GROUP_UPDATE",
					// "GROUP_PARTICIPANTS_UPDATE",
					"CONNECTION_UPDATE",
					//"CALL"
					// "NEW_JWT_TOKEN",
					// "TYPEBOT_START",
					// "TYPEBOT_CHANGE_STATUS",
				],
				"events"  => [
					// "APPLICATION_STARTUP",
					//"QRCODE_UPDATED",
					// "MESSAGES_SET",
					"MESSAGES_UPSERT",
					"MESSAGES_UPDATE",
					"MESSAGES_DELETE",
					"SEND_MESSAGE",
					// "CONTACTS_SET",
					// "CONTACTS_UPSERT",
					// "CONTACTS_UPDATE",
					// "PRESENCE_UPDATE",
					// "CHATS_SET",
					// "CHATS_UPSERT",
					// "CHATS_UPDATE",
					// "CHATS_DELETE",
					// "GROUPS_UPSERT",
					// "GROUP_UPDATE",
					// "GROUP_PARTICIPANTS_UPDATE",
					//"CONNECTION_UPDATE",
					//"CALL"
					// "NEW_JWT_TOKEN",
					// "TYPEBOT_START",
					// "TYPEBOT_CHANGE_STATUS",
				]
		]);
		
		$tmp = $response->object();
		
		if($response->status() == 201)
		{
			if($tmp->instance)
			{
				return (object) array(
					'status'  => '1',
					'message' => 'Criado com sucesso!',
				);
			}
		}
		
		if($response->status() == 403)
		{
			return (object) array(
				'status' => '1',
				'message' => 'Sessão já cadastrada!'
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status'  => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
		
	/**
	* generateQrCodeWhatsApp
	* @return object
	*/
	public function generateQrCodeWhatsApp() :object
	{
		if(empty($this->getSessionName()) || empty($this->getNumberIntegration()) || empty($this->getUrl()))
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'apikey' => $this->getSessionKey(),
		])->get($this->getUrl().'/instance/connect/'.$this->getSessionName().'?number='.$this->getNumberIntegration());
		
		$tmp = $response->object();
		
		if($response->status() == 200)
		{
			return (object) array(
				'status'  => '1',
				'message' => '',
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
		
	/**
	* setDeleteSessionWhatsApp
	* @return object
	*/
	public function setDeleteSessionWhatsApp() :object
	{
		if (empty($this->getSessionName()) || empty($this->getUrl()))
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'apikey' => $this->getSessionKey(),
		])->delete($this->getUrl().'/instance/logout/'.$this->getSessionName());
		
		$tmp = $response->object();
		
		if($response->status() == 200)
		{
			return (object) array(
				'status'  => '1',
				'message' => 'Sessão excluida com sucesso!',
			);
		}
		
		if($response->status() == 400)
		{
			return (object) array(
				'status'  => '0',
				'message' => 'Instância não está conectada!',
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
		
	/**
	* getStatusWhatsApp
	*
	* @return object
	*/
	public function getStatusWhatsApp() :object
	{
		if(empty($this->getSessionName()) || empty($this->getUrl()) ||
		empty($this->getSessionName()))
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'apikey' => $this->getSessionKey(),
		])->get($this->getUrl().'/instance/connect/'.$this->getSessionName());
		
		$tmp = $response->object();
		
		if($response->status() == 200)
		{
			if(isset($tmp->instance->state) && $tmp->instance->state == 'open')
			{
				return (object) array(
					'status'          => '1',
					'message'         => '',
					'status_whatsapp' => 'connected'
				);
			}
			else
			{
				return (object) array(
					'status'          => '1',
					'message'         => '',
					'status_whatsapp' =>  'disconnected'
				);
			}
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status'          => '1',
				'message'         => 'Instância não criada!',
				'status_whatsapp' =>  'disconnected'
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
	
	/**
	* setSendMessageWhatsApp
	* @return object
	*/
	public function setSendMessageWhatsApp() :object
	{
		if(empty($this->getSessionName()) || empty($this->getUrl()) ||
		  empty($this->getNumberContact()) || empty($this->getMsg())
		)
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'apikey' => $this->getSessionKey(),
		])->post($this->getUrl().'/message/sendText/'.$this->getSessionName(), [
			"number" => $this->getNumberContact(),
			"options" => [
					"delay" => $this->getDelay() ? $this->getDelay() : 1000,
					"presence" => "composing",
					"mentions" => [
						"everyOne" => false,
						"mentioned" => [
							$this->getNumberContact()
						]
					]
				],
			"textMessage" => [
				"text" => $this->getMsg()
			]
		]);
		
		$tmp = $response->object();
		
		if($response->status() == 201)
		{
			return (object) array(
				'status'  => '1',
				'message' => '',
				'msg_id'  => $tmp->key->id
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
		
	/**
	* setSendArchiveWhatsApp
	* @return object
	*/
	public function setSendArchiveWhatsApp() :object
	{
		if(empty($this->getSessionName()) || empty($this->getUrl()) ||
		  empty($this->getNumberContact()) || empty($this->getFileName()) ||
		  empty($this->getMediaFile())
		)
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$path_info = pathinfo($this->getMediaFile());
		$extension = $path_info['extension'];
		
		if(in_array($extension, ['png', 'jpeg', 'jpg', 'gif', 'webp', 'bmp', 'svg', 'raw'])){ $mediaType = 'image'; }
		else if(in_array($extension, ['mp3', 'ogg'])){ $mediaType = 'audio'; }
		else if(in_array($extension, ['mp4', ])){ $mediaType = 'video'; }
		else { $mediaType = 'document'; }
		
		$response = Http::withHeaders([
			'apikey' => $this->getSessionKey(),
		])->post($this->getUrl().'/message/sendMedia/'.$this->getSessionName(), [
			"number" => $this->getNumberContact(),
      "options" => [
         "delay"   => $this->getDelay() ? $this->getDelay() : 1000,
         "presence"=> "composing"
      ],
      "mediaMessage" => [
        "mediatype"  => $mediaType,
         "fileName"  => $this->getFileName(),
          "caption"  => "",
            "media"  => $this->getMediaFile(),
      ]
		]);
		
		$tmp = $response->object();
		
		if($response->status() == 201)
		{
			return (object) array(
				'status'  => '1',
				'message' => '',
				'msg_id'  => $tmp->key->id
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
	
	/**
	* getValidWhatsApp
	* @return object
	*/
	public function getValidWhatsApp() : object
	{
		if(empty($this->getSessionName()) || empty($this->getUrl()) || 
			empty($this->getNumberContact())
		)
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'apikey'       => $this->getSessionKey(),
		])->post($this->getUrl().'/chat/whatsappNumbers/'.$this->getSessionName(), [
				"numbers" => array( $this->getNumberContact() )
		]);
		
		$tmp = $response->object();
		
		if($response->status() == 201)
		{
			return (object) array(
				'status'  => '1',
				'message' => '',
				'exists'  => $tmp[0]->exists
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
	
	/**
	* getAllChatWithMessagesWhatsApp
	* @return object
	*/
	public function getAllChatWithMessagesWhatsApp() : object
	{
		if(empty($this->getSessionName()) || empty($this->getUrl()) || 
			empty($this->getNumberContact())
		)
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'apikey'       => $this->getSessionKey(),
		])->post($this->getUrl().'/chat/findMessages/'.$this->getSessionName(), [
				"where" => [
					"key" => [
						"remoteJid" => "".$this->getNumberContact()."@s.whatsapp.net"
					],
				]
		]);
		
		$tmp = $response->object();
		
		if($response->status() == 200)
		{
			return (object) array(
				'status'  => '1',
				'message' => '',
				'data'    => $tmp
			);
		}
		
		if($response->status() == 400)
		{
			return (object) array(
				'status'  => '0',
				'message' => 'Instância não está conectada!',
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}

	public function downloadMedia($msgId, $convertToMp4 = false) : object
	{
		if(empty($this->getSessionName()) || empty($this->getUrl()) || 
			empty($this->getNumberContact() || empty($msgId))
		)
		{
			return (object) [
				'status' => '0',
				'message' => 'Dados obrigatórios não informados!',
			];
		}
		
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'apikey'       => $this->getSessionKey(),
		])->post($this->getUrl().'/chat/getBase64FromMediaMessage/'.$this->getSessionName(), [
				"message" => [
					"key" => [
						"id" => $msgId
					],
					"convertToMp4" => $convertToMp4
				]
		]);
		
		$tmp = $response->object();
		
		if($response->status() == 201)
		{
			return (object) array(
				'status'  => '1',
				'message' => '',
				'base64'  => $tmp->base64
			);
		}
		
		if($response->status() == 400)
		{
			return (object) array(
				'status'  => '0',
				'message' => 'Instância não está conectada!',
			);
		}
		
		if($response->status() == 401)
		{
			return (object) array(
				'status' => '0',
				'message' => 'Não Autorizado!'
			);
		}
		
		if($response->status() == 404)
		{
			return (object) array(
				'status' => '0',
				'not_found_token' => true,
				'message' => 'Token não encontrado!'
			);
		}
		
		return (object) array(
			'status' => '0',
			'message' => 'Falha de processamento!'
		);
	}
}
?>