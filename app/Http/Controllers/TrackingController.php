<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TrackingResource;
use App\Services\TrackingService;

class TrackingController extends Controller
{
	private $trackingService;

	public function __construct(TrackingService $trackingService)
	{
		$this->trackingService = $trackingService;
	}
	
	public function index(Request $request)
	{
		$business = $this->trackingService->getAllTrackings($request);
		
		if ($business->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => TrackingResource::collection($business)->response()->getData(false)));
	}
	
	public function show(Request $request)
	{
		$business = $this->trackingService->getTrackingById($request->id);
		
		if(!$business)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new TrackingResource($business)));
	}
	
	public function destroy(Request $request)
	{
		$this->trackingService->deleteTrackings($request->ids);
		return response()->json(array("status" => "1", "message" => "Registro deletado com sucesso!"));
	}
}
