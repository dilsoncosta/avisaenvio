<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\IntegrationEmailRequest;
use App\Http\Resources\IntegrationEmailResource;
use App\Services\IntegrationEmailService;

class IntegrationEmailController extends Controller
{
	private $integrationEmailService;
	
	public function __construct(IntegrationEmailService $integrationEmailService)
	{
			$this->integrationEmailService = $integrationEmailService;
	}
	
	public function index(Request $request)
	{
		$integrationEmails = $this->integrationEmailService->getAllIntegrationEmails($request);
		
		if ($integrationEmails->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => IntegrationEmailResource::collection($integrationEmails)->response()->getData(false)));
	}
	
	public function store(IntegrationEmailRequest $request)
	{
		if($this->integrationEmailService->checkName($request->title, '', 0) > 0)
		{
			return response()->json(array("status" => "0", "message" => "Ops, TÍTULO já está cadastrado!"), 400);
		}
		
		$this->integrationEmailService->storeIntegrationEmail($request);
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"));
	}
	
	public function update(IntegrationEmailRequest $request)
	{
		if(!$this->integrationEmailService->getIntegrationEmailById($request->id))
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		if($this->integrationEmailService->checkName($request->title, $request->id, 1) > 0)
		{
			return response()->json(array("status" => "0", "message" => "Ops, TÍTULO já está cadastrado!"), 400);
		}
		
		$this->integrationEmailService->updateIntegrationEmail($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
	
	public function show(Request $request)
	{
		$integrationEmail = $this->integrationEmailService->getIntegrationEmailById($request->id);
		
		if(!$integrationEmail)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new IntegrationEmailResource($integrationEmail)));
	}
	
	public function destroy(Request $request)
	{
		$this->integrationEmailService->deleteIntegrationEmails($request->ids);
		return response()->json(array("status" => "1", "message" => "Registro deletado com sucesso!"));
	}
}
