<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminResourceRequest;
use App\Http\Resources\AdminResourceResource;
use App\Services\AdminResourceService;

class AdminResourceController extends Controller
{
	private $adminResourceService;

	public function __construct(AdminResourceService $adminResourceService)
	{
		$this->adminResourceService = $adminResourceService;
	}
	
	public function index(Request $request)
	{
		$resources = $this->adminResourceService->getAllResources($request);
  
		if ($resources->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(["status" => "1", "message" => "", "data" => AdminResourceResource::collection($resources)->response()->getData(false)]);
	}
	
	public function store(AdminResourceRequest $request)
	{
		if($this->adminResourceService->checkName($request->name, 0, '') > 0)
		{
			return response()->json(["status" => "0", "message" => "NOME já existe!"]);
		}
		
		$this->adminResourceService->storeResource($request);
		
		return response()->json(["status" => "1", "message" => "Cadastro Efetuado com Sucesso!"]);
	}
	
	public function update(AdminResourceRequest $request)
	{
		if($this->adminResourceService->checkName($request->name, 1, $request->id) > 0)
		{
			return response()->json(["status" => "0", "message" => "NOME já existe!"]);
		}
		
		$this->adminResourceService->updateResource($request);
		
		return response()->json(["status" => "1", "message" => "Registro Atualizado com Sucesso!"]);
	}
	
	public function show(Request $request)
	{
		$resource =  $this->adminResourceService->getResourceById($request->id);
		
		if(!$resource)
		{
			return response()->json(["status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"], 404);
		}
		
		return response()->json(["status" => "1", "message" => "", "data" => new AdminResourceResource($resource)]);
	}
	
	public function destroy(Request $request)
	{
		$this->adminResourceService->deleteResources($request->ids);
		return response()->json(["status" => "1", "message" => "Registro deletado com sucesso!"], 200);
	}
}
