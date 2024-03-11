<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CollaboratorRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\{
	AdminResourceResource,
	CollaboratorResource
};
use App\Services\CollaboratorService;

class CollaboratorController extends Controller
{
	private $collaboratorService;

	public function __construct(CollaboratorService $collaboratorService)
	{
			$this->collaboratorService = $collaboratorService;
	}
	
	public function index(Request $request)
	{
		$collaborators = $this->collaboratorService->getAllCollaborator($request);
		
		if ($collaborators->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => CollaboratorResource::collection($collaborators)->response()->getData(false)));
	}
	
	public function getAllResources()
	{
		$resources = $this->collaboratorService->getAllResources();
		return response()->json(["status" => "1", "message" => "", "data" => AdminResourceResource::collection($resources)->response()->getData(false)]);
	}
	
	public function store(CollaboratorRequest $request)
	{	
		$this->collaboratorService->createCollaborator($request);
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"), 201);
	}
	
	public function update(CollaboratorRequest $request)
	{
		$collaborator = $this->collaboratorService->getCollaboratorById($request->user_id);

		if(!$collaborator)
		{
			return response()->json(array("status" => "0", "message" => "Registro inexistente!"), 404);
		}
		
		if($request->collaborator_type == '1')
		{
			if($this->collaboratorService->getExistedSeller($collaborator->id))
			{
				return response()->json(array("status" => "0", "message" => "Ops! Não é possível promover este colaborador a administrador, pois já está cadastrado como vendedor."), 400);
			}
		}
		
		$this->collaboratorService->updateCollaborator($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
	
	public function show(Request $request)
	{
		$collaborator = $this->collaboratorService->getCollaboratorById($request->user_id);
		
		if(!$collaborator)
		{
			return response()->json(array("status" => "0", "message" => "Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new CollaboratorResource($collaborator)));
	}
	
	public function destroy(Request $request)
	{
		if(!$request->ids)
		{
			return response()->json(array("status" => "0", "message" => "Nenhum registro selecionado!"), 400);
		}
		
		$this->collaboratorService->deleteCollaborator($request);
		
		return response()->json(array("status" => "1", "message" => "Registro deletado com sucesso!"));
	}
}
