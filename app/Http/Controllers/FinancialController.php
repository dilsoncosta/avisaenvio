<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FinancialSignatureRequest;
use App\Http\Resources\{
	ChargeResource,
	FinancialResource
};
use App\Services\FinancialService;

class FinancialController extends Controller
{
	private $financialService;
	
	public function __construct(FinancialService $financialService)
	{
		$this->financialService = $financialService;
	}
	
	public function index(Request $request)
	{
		$signature = $this->financialService->getSignature($request);
		
		if(!$signature)
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new FinancialResource($signature)));
	}

	public function getCharge(Request $request)
	{
		$charges = $this->financialService->getCharge($request);
		
		if($charges->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => ChargeResource::collection($charges)->response()->getData(false)));
	}
	
	public function storeSignature(FinancialSignatureRequest $request)
	{
		$signature = $this->financialService->storeSignature($request);
		
		if($signature->status == 0)
		{
			return response()->json(array("status" => "1", "message" => $signature->message), 400);
		}

		return response()->json(array("status" => "1", "message" => "Assinatura efetuado com sucesso! Faça o login novamente para atualizar seu acesso."));
	}

	public function canceledSignature()
	{
		$canceledSignature = $this->financialService->canceledSignature();
		
		if($canceledSignature->status == 0)
		{
			return response()->json(array("status" => "0", "message" => $canceledSignature->message), 400);
		}
		
		return response()->json(array("status" => "1", "message" => "Assinatura cancelada com sucesso!"));
	}
}