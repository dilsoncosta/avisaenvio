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
		if($this->integrationTrayService->getIntegrationTray())
		{
			$this->integrationTrayService->updateIntegrationTray($request->uuid, [
				'situation'    => 1,
				'url_store'    => $request->url,
				'adm_user'     => $request->adm_user,
				'access_token' => $request->access_token,
				'user_id'      => $request->user_id,
				'code'         => $request->code,
				'store_plan'   => $request->store_plan,
				'store'        => $request->store,
				'store_host'   => $request->store_host,
			]);
		}
		else
		{
			$this->integrationTrayService->createIntegrationTray([
				'situation'    => 1,
				'url_store'    => $request->url,
				'adm_user'     => $request->adm_user,
				'access_token' => $request->access_token,
				'user_id'      => $request->user_id,
				'code'         => $request->code,
				'store_plan'   => $request->store_plan,
				'store'        => $request->store,
				'store_host'   => $request->store_host,
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
	
	public function activeAutentication(Request $request)
	{
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
		])->post($request->api_address.'/auth', [
			"consumer_secret" => config("app.api_consumer_secret"),
			"consumer_key"    => config("app.api_consumer_key"),
			"code"            => $request->code,
		]);
		
		$tmp = $response->object();
		
		$this->integrationTrayService->updateActiveIntegrationTray($request->store_host, [
			'situation'    => 1,
			'api_address'  => $request->api_address,
			'adm_user'     => $request->adm_user,
			'access_token' => $tmp->access_token,
			'user_id'      => $request->user_id,
			'code'         => $request->code,
			'store_plan'   => $request->store_plan,
			'store'        => $request->store,
			'store_host'   => $request->store_host,
			'store_id'     => $tmp->store_id,
			'date_expiration_access_token'  => $tmp->date_expiration_access_token,
			'date_expiration_refresh_token' => $tmp->date_expiration_refresh_token,
			'date_activated'                => $tmp->date_activated,
			'refresh_token'                 => $tmp->refresh_token,
		]);
	}
}
