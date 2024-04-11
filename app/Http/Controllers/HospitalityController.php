<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\HospitalityRequest;
use App\Http\Resources\HospitalityResource;
use App\Services\HospitalityService;

class HospitalityController extends Controller
{
	private $hospitalityService;
	
	public function __construct(HospitalityService $hospitalityService)
	{
		$this->hospitalityService = $hospitalityService;
	}
	
	public function index(Request $request)
	{
		$hotel = $this->hospitalityService->getAllHotel($request);
		
		if (!$hotel)
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new HospitalityResource($hotel)));
	}
	
	public function update(HospitalityRequest $request)
	{
		$this->hospitalityService->updateHotel($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
}