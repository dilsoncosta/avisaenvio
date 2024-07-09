<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IntegrationTrayService;
use App\Http\Resources\IntegrationTrayResource;
use App\Http\Requests\IntegrationTrayRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IntegrationTrayController extends Controller
{
	private $integrationTrayService;
	
	public function __construct(IntegrationTrayService $integrationTrayService)
	{
		$this->integrationTrayService = $integrationTrayService;
	}
	
	public function disabledIntegration(IntegrationTrayRequest $request)
	{
		$this->integrationTrayService->updateIntegrationTray($request->uuid,[
			'situation' => 0
		]);
		
		return response()->json(array("status" => "1", "message" => "Desativado com sucesso!"));
	}

	public function activeIntegration(IntegrationTrayRequest $request)
	{
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
		])->post($request->url.'/auth', [
			"consumer_secret" => config("app.api_consumer_secret"),
			"consumer_key"    => config("app.api_consumer_key"),
			"code"            => $request->code,
		]);
			
		$tmp = $response->object();
  
		if($this->integrationTrayService->getIntegrationTray())
		{
			$this->integrationTrayService->updateIntegrationTray($request->uuid, [
				'situation'    => 1,
				'url_store'    => $request->url,
				'code'         => $request->code,
				'access_token' => $tmp->access_token,
				'date_expiration_access_token'  => $tmp->date_expiration_access_token,
				'date_expiration_refresh_token' => $tmp->date_expiration_refresh_token,
				'date_activated'                => $tmp->date_activated,
				'refresh_token'                 => $tmp->refresh_token,
			]);
		}
		else
		{
			$this->integrationTrayService->createIntegrationTray([
				'situation'    => 1,
				'url_store'    => $request->url,
				'code'         => $request->code,
				'access_token' => $tmp->access_token,
				'date_expiration_access_token'  => $tmp->date_expiration_access_token,
				'date_expiration_refresh_token' => $tmp->date_expiration_refresh_token,
				'date_activated'                => $tmp->date_activated,
				'refresh_token'                 => $tmp->refresh_token,
			]);
		}

		return response()->json(array("status" => "1", "message" => "Ativação efetuado com sucesso!"));
	}

	public function getStatusIntegrationTray(Request $request)
	{
		$integration_nuvem_shop = $this->integrationTrayService->getIntegrationTray($request);

		if(!$integration_nuvem_shop)
		{
			return response()->json(array("status" => "1", "message" => "Integração inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new IntegrationTrayResource($integration_nuvem_shop)));
	}
}
