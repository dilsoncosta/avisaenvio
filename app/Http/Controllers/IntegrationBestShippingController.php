<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\IntegrationBestShippingService;
use App\Http\Resources\IntegrationBestShippingResource;
use App\Http\Requests\IntegrationBestShippingRequest;

class IntegrationBestShippingController extends Controller
{
	private $integrationBestShippingService;
	
	public function __construct(IntegrationBestShippingService $integrationBestShippingService)
	{
		$this->integrationBestShippingService = $integrationBestShippingService;
	}
	
	public function disabledIntegration(IntegrationBestShippingRequest $request)
	{
		$this->integrationBestShippingService->updateIntegrationBestShipping($request->uuid,[
			'situation' => 0,
			'token'     => $request->token
		]);
		
		return response()->json(array("status" => "1", "message" => "Desativado com sucesso!"));
	}

	public function activeIntegration(IntegrationBestShippingRequest $request)
	{
		if($this->integrationBestShippingService->getIntegrationBestShipping())
		{
			$this->integrationBestShippingService->updateIntegrationBestShipping($request->uuid, [
				'situation' => $request->situation,
				'token'     => $request->token
			]);
		}
		else
		{
			$this->integrationBestShippingService->createIntegrationBestShipping([
				'situation' => $request->situation,
				'token'     => $request->token
			]);
		}
		
		return response()->json(array("status" => "1", "message" => "Ativação efetuado com sucesso!"));
	}

	public function getStatusIntegrationBestShipping(Request $request)
	{
		$integration_best_shipping = $this->integrationBestShippingService->getIntegrationBestShipping($request);

		if(!$integration_best_shipping)
		{
			return response()->json(array("status" => "1", "message" => "Integração inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new IntegrationBestShippingResource($integration_best_shipping)));
	}
}
