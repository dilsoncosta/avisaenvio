<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IntegrationNuvemShopService;
use App\Http\Resources\IntegrationNuvemShopResource;
use App\Http\Requests\IntegrationNuvemShopRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class IntegrationNuvemShopController extends Controller
{
	private $integrationNuvemShopService;
	
	public function __construct(IntegrationNuvemShopService $integrationNuvemShopService)
	{
		$this->integrationNuvemShopService = $integrationNuvemShopService;
	}
	
	public function disabledIntegration(IntegrationNuvemShopRequest $request)
	{
		$this->integrationNuvemShopService->updateIntegrationNuvemShop($request->uuid,[
			'situation' => 0,
			'code'      => "",
			'user_id'   => $request->idApp,
		]);
		
		return response()->json(array("status" => "1", "message" => "Desativado com sucesso!"));
	}

	public function activeIntegration(IntegrationNuvemShopRequest $request)
	{
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
		])->post("https://www.tiendanube.com/apps/authorize/token", [
			"client_id"     => config("app.api_nuvem_shop_client_id"),
			"client_secret" => config("app.api_nuvem_shop_secret"),
			"grant_type"    => "authorization_code",
			"code"          => $request->code
		]);
		
		$tmp = $response->object();
		
		if(isset($tmp->error) && $tmp->error)
		{
			return response()->json(array("status" => "0", "message" => $tmp->error_description), 404);
		}
		
		if($this->integrationNuvemShopService->getIntegrationNuvemShop())
		{
			$this->integrationNuvemShopService->updateIntegrationNuvemShop($request->uuid, [
				'situation'    => $request->situation,
				'code'         => $request->code,
				'idapp'        => $request->idApp,
				'access_token' => $tmp->access_token,
				'scope'        => $tmp->scope,
				'token_type'   => $tmp->token_type,
				'user_id'      => $tmp->user_id,
			]);
		}
		else
		{
			$this->integrationNuvemShopService->createIntegrationNuvemShop([
				'situation'    => $request->situation,
				'code'         => $request->code,
				'idapp'        => $request->idApp,
				'access_token' => $tmp->access_token,
				'scope'        => $tmp->scope,
				'token_type'   => $tmp->token_type,
				'user_id'      => $tmp->user_id,
			]);
		}
		
		return response()->json(array("status" => "1", "message" => "Ativação efetuado com sucesso!"));
	}

	public function getStatusIntegrationNuvemShop(Request $request)
	{
		$integration_nuvem_shop = $this->integrationNuvemShopService->getIntegrationNuvemShop($request);

		if(!$integration_nuvem_shop)
		{
			return response()->json(array("status" => "1", "message" => "Integração inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new IntegrationNuvemShopResource($integration_nuvem_shop)));
	}
}
