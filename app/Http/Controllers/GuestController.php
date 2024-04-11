<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\GuestResource;
use App\Http\Requests\GuestRequest;
use App\Services\GuestService;

class GuestController extends Controller
{
	private $guestService;

	public function __construct(GuestService $guestService)
	{
		$this->guestService = $guestService;
	}
	
	public function index(Request $request)
	{
		$guests = $this->guestService->getAllGuests($request);
		
		if ($guests->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => GuestResource::collection($guests)->response()->getData(false)));
	}

	public function store(GuestRequest $request)
	{
		if($this->guestService->getExistedGuest($request, 0, ''))
		{
			return response()->json(array("status" => "0", "message" => "HOSPEDE já cadastrado para DATA DE CHECK-IN e DATA DE CHECK-OUT!"), 400);
		}
		
		if(!$this->guestService->getHospitality())
		{
			return response()->json(array("status" => "0", "message" => "Configuração da Hotelaria inexistente. Acesse Configuração/Hotelaria e faça a configuração para proseeguir!"), 400);
		}
		
		$this->guestService->storeGuest($request);
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"));
	}
	
	public function update(GuestRequest $request)
	{
		$guest = $this->guestService->getGuestById($request->id);
		
		if(!$guest)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		if($this->guestService->getExistedGuest($request, 1, $request->id))
		{
			return response()->json(array("status" => "1", "message" => "HOSPEDE já cadastrado para DATA DE CHECK-IN e DATA DE CHECK-OUT!"), 400);
		}
		
		$this->guestService->updateGuest($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
	
	public function show(Request $request)
	{
		$guest = $this->guestService->getGuestById($request->id);
		
		if(!$guest)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new GuestResource($guest)));
	}
	
	public function destroy(Request $request)
	{
		$this->guestService->deleteGuests($request->ids);
		return response()->json(array("status" => "1", "message" => "Registro deletado com sucesso!"));
	}
}
