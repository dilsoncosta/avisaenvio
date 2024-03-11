<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IntegrationWhatsAppService;
use App\Http\Resources\IntegrationWhatsAppResource;
use App\Helpers\ApiWhatsApp;

class IntegrationWhatsAppController extends Controller
{
	private $integrationWhatsAppService;
	private $apiWhatsApp;
	
	public function __construct(
		IntegrationWhatsAppService $integrationWhatsAppService,
		ApiWhatsApp $apiWhatsApp
	)
	{
		$this->integrationWhatsAppService = $integrationWhatsAppService;
		$this->apiWhatsApp                = $apiWhatsApp;
	}
	
	public function disabledIntegration(Request $request)
	{
		$integration_whatsapp = $this->integrationWhatsAppService->getIntegrationWhatsApp($request);
		
		if(!$integration_whatsapp)
		{
			return response()->json(array("status" => "0", "message" => "Nenhuma INTEGRAÇÃO WHATSAPP encontrada!"), 404);
		}
		
		$this->apiWhatsApp->setUrl($integration_whatsapp->url);
		$this->apiWhatsApp->setSessionName($integration_whatsapp->session_name);
		$this->apiWhatsApp->setSessionKey($integration_whatsapp->app_key);
		$this->apiWhatsApp->setNumberIntegration($request->whatsapp);
		
		$info_delete_session_whatsapp = $this->apiWhatsApp->setDeleteSessionWhatsApp();
		
		if($info_delete_session_whatsapp->status == '0')
		{
			return response()->json(array("status" => "0", "message" => $info_delete_session_whatsapp->message), 500);
		}
		
		if($info_delete_session_whatsapp->status == "0" && isset($info_delete_session_whatsapp->not_found_token))
		{
			$created_token = $this->apiWhatsApp->createTokenWhatsApp();
			
			if($created_token->status == 0)
			{
				return response()->json(array("status" => "0", "message" => $created_token->message), 500);
			}
		}
		
		return response()->json(array("status" => "1", "message" => $info_delete_session_whatsapp->message));
	}

	public function activeIntegration(Request $request)
	{
		$createdNow = "0";
		$integration_whatsapp = $this->integrationWhatsAppService->getIntegrationWhatsApp($request);
		
		if(!$integration_whatsapp)
		{
			return response()->json(array("status" => "0", "message" => "Nenhuma INTEGRAÇÃO WHATSAPP encontrada!", "createNow" => $createdNow), 404);
		}
		
		$this->apiWhatsApp->setUrl($integration_whatsapp->url);
		$this->apiWhatsApp->setSessionName($integration_whatsapp->uuid.'_'.config('app.api_whatsapp_ambiente'));
		$this->apiWhatsApp->setSessionKey($integration_whatsapp->app_key);
		$this->apiWhatsApp->setNumberIntegration($request->whatsapp);
		
		if(empty($integration_whatsapp->session_name))
		{
			$created_token = $this->apiWhatsApp->createTokenWhatsApp();
			
			if($created_token->status == 0)
			{
				return response()->json(array("status" => "0", "message" => $created_token->message, "createNow" => $createdNow), 500);
			}
			$createdNow = "1";
		}
		
		$this->integrationWhatsAppService->updateIntegrationWhatsApp($integration_whatsapp->id, [
			'url'             => config('app.api_whatsapp_path_main'),
			'port'            => '8080',
			'app_key'         => config('app.api_whatsapp_secret_key'),
			'session_name'    => $integration_whatsapp->uuid.'_'.config('app.api_whatsapp_ambiente'),
			'whatsapp'        => $request->whatsapp,
			'situation'       => '1'
		]);
		
		$info_delete_session_whatsapp = $this->apiWhatsApp->setDeleteSessionWhatsApp();
		
		if(isset($info_delete_session_whatsapp->not_found_token))
		{
			$created_token = $this->apiWhatsApp->createTokenWhatsApp();
			
			if($created_token->status == 0)
			{
				return response()->json(array("status" => "0", "message" => $created_token->message, "createNow" => $createdNow), 500);
			}
			$createdNow = "1";
		}
		
		$this->apiWhatsApp->generateQrCodeWhatsApp();
		
		return response()->json(array("status" => "1", "message" => "Ativação efetuado com sucesso!", "createNow" => $createdNow));
	}

	public function getStatusIntegrationWhatsApp(Request $request)
	{
		$integration_whatsapp = $this->integrationWhatsAppService->getIntegrationWhatsApp($request);
		
		if(!$integration_whatsapp->session_name)
		{
			return response()->json(array("status" => "1", "message" => "", "status_integration" => "disconnected", "data" => new IntegrationWhatsAppResource($integration_whatsapp)));
		}
		
		$this->apiWhatsApp->setUrl($integration_whatsapp->url);
		$this->apiWhatsApp->setSessionName($integration_whatsapp->session_name);
		$this->apiWhatsApp->setSessionKey($integration_whatsapp->app_key);
		$status_integration = $this->apiWhatsApp->getStatusWhatsApp();
		
		if($status_integration->status == "0")
		{
			return response()->json(array("status" => "0", "message" => $status_integration->message), 500);
		}
		
		return response()->json(array("status" => "1", "message" => "", "status_integration" => $status_integration->status_whatsapp, "data" => new IntegrationWhatsAppResource($integration_whatsapp)));
	}
}
