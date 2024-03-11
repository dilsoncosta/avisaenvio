<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AdminPermissionRequest;
use App\Http\Resources\AdminPermissionResource;
use App\Services\AdminPermissionService;

class AdminPermissionController extends Controller
{
	private $adminPermissionService;

	public function __construct(AdminPermissionService $adminPermissionService)
	{
		$this->adminPermissionService = $adminPermissionService;
	}
	
	public function index(Request $request)
	{
		$permissions = $this->adminPermissionService->getAllPermissions($request);
		
		if ($permissions->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(["status" => "1", "message" => "", "data" => AdminPermissionResource::collection($permissions)->response()->getData(false)]);
	}
	
	public function store(AdminPermissionRequest $request)
	{
		if($this->adminPermissionService->checkExistedResource($request->resource_id) == 0)
		{
			return response()->json(["status" => "0", "message" => "Módulo inexistente!"], 400);
		}
		if($this->adminPermissionService->checkName($request->name, 0, '') > 0)
		{
			return response()->json(["status" => "0", "message" => "NOME já existe!"], 40);
		}
		
		$this->adminPermissionService->storePermission($request);
		
		return response()->json(["status" => "1", "message" => "Cadastro Efetuado com Sucesso!"]);
	}
	
	public function update(AdminPermissionRequest $request)
	{
		if($this->adminPermissionService->checkExistedResource($request->resource_id) == 0)
		{
			return response()->json(["status" => "0", "message" => "Módulo inexistente!"], 40);
		}
		if($this->adminPermissionService->checkName($request->name, 1, $request->id) > 0)
		{
			return response()->json(["status" => "0", "message" => "NOME já existe!"], 40);
		}
		
		$this->adminPermissionService->updatePermission($request);
		
		return response()->json(["status" => "1", "message" => "Registro Atualizado com Sucesso!"]);
	}
	
	public function show(Request $request)
	{
		$permission =  $this->adminPermissionService->getPermissionById($request->id);
		
		if(!$permission)
		{
			return response()->json(["status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"], 404);
		}

		return response()->json(["status" => "1", "message" => "", "data" => new AdminPermissionResource($permission)]);
	}
	
	public function destroy(Request $request)
	{
		$this->adminPermissionService->deletePermissions($request->ids);
		return response()->json(["status" => "1", "message" => "Registro deletado com sucesso!"], 200);
	}
}
