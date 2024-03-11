<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminTokenWhatsAppWebRequest;
use App\Http\Resources\AdminTokenWhatsAppWebResource;
use App\Services\AdminTokenWhatsAppWebService;

class AdminTokenWhatsAppWebController extends Controller
{
	protected $adminTokenWhatsAppWebService;

	public function __construct(AdminTokenWhatsAppWebService $adminTokenWhatsAppWebService)
	{
		$this->adminTokenWhatsAppWebService = $adminTokenWhatsAppWebService;
	}
	
	public function index(Request $request)
	{
		$token_whatsappwebs = $this->adminTokenWhatsAppWebService->getAllAdminTokenWhatsAppWebs($request);
		
		if ($token_whatsappwebs->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(["status" => "1", "message" => "", "data" => AdminTokenWhatsAppWebResource::collection($token_whatsappwebs)->response()->getData(false)]);
	}
	
	public function store(AdminTokenWhatsAppWebRequest $request)
	{
		$this->adminTokenWhatsAppWebService->createTokenWhatsappWeb($request);
		
		return response()->json(["status" => "1", "message" => "Cadastro Efetuado com Sucesso!"]);
	}

	public function update(AdminTokenWhatsAppWebRequest $request)
	{
		if(!$this->adminTokenWhatsAppWebService->getTokenWhatsAppWebById($request->id))
		{
			return response()->json(["status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"], 404);
		}
		
		$this->adminTokenWhatsAppWebService->updateTokenWhatsappWeb($request);
		
		return response()->json(["status" => "1", "message" => "Registro Atualizado com Sucesso!"]);
	}

	public function show(Request $request)
	{
		$token_whatsappweb =  $this->adminTokenWhatsAppWebService->getTokenWhatsAppWebById($request->id);
		
		if(!$token_whatsappweb)
		{
			return response()->json(["status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"], 404);
		}
		
		return response()->json(["status" => "1", "message" => "", "data" => new AdminTokenWhatsAppWebResource($token_whatsappweb)]);
	}
	
	public function destroy(Request $request)
	{
		$this->adminTokenWhatsAppWebService->deleteTokenWhatsAppWebs($request->ids);
		return response()->json(["status" => "1", "message" => "Registro deletado com sucesso!"], 200);
	}
}
