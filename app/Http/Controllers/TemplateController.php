<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\TemplateRequest;
use App\Http\Resources\TemplateResource;
use App\Services\TemplateService;

class TemplateController extends Controller
{
	private $templateService;
	
	public function __construct(TemplateService $templateService)
	{
		$this->templateService = $templateService;
	}
	
	public function index(Request $request)
	{
		$templates = $this->templateService->getAllTemplates($request);
		
		if ($templates->isEmpty())
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => TemplateResource::collection($templates)->response()->getData(false)));
	}
	
	public function store(TemplateRequest $request)
	{
		if($this->templateService->getExistedTemplate("", 0, $request->type) && $request->ind_mod_order_tracking == 1)
		{
			return response()->json(array( "status" => "0", "message" => "Tipo de Template já cadastrado!" ), 400);
		}
		
		if(empty($request->message) && empty($request->file_1) && empty($request->file_2) && empty($request->file_3))
		{
			return response()->json(array( "status" => "0", "message" => "O Campo MENSAGEM ou ARQUIVO #1 OU ARQUIVO #2 OU ARQUVO #3 um deles deve ser preenchido!" ), 400);
		}
		
		$this->templateService->storeTemplate($request);
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"));
	}
	
	public function update(TemplateRequest $request)
	{
		$template = $this->templateService->getTemplateById($request->id);
		
		if(!$template)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		if($this->templateService->getExistedTemplate($request->id, 1, $request->type) && $request->ind_mod_order_tracking == 1)
		{
			return response()->json(array( "status" => "0", "message" => "Tipo de Template já cadastrado!" ), 400);
		}
		
		$this->templateService->updateTemplate($request);
		
		return response()->json(array("status" => "1", "message" => "Registro Atualizado com Sucesso!"));
	}
	
	public function show(Request $request)
	{
		$template = $this->templateService->getTemplateById($request->id);
		
		if(!$template)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new TemplateResource($template)));
	}
	
	public function destroy(Request $request)
	{
		if($this->checkTemplateDefined($request->ids))
		{
			return response()->json(["status" => "0", "message" => "O Template não pode ser deletado, pois está sendo utilizado na configuração do módulo."], 400);
		}
		
		$this->templateService->deleteTemplates($request->ids);
		return response()->json(["status" => "1", "message" => "Registro deletado com sucesso!"], 200);
	}
	
	public function destroyFile(Request $request)
	{
		$template = $this->templateService->getTemplateById($request->id);
		
		if(!$template)
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem. Registro inexistente!"), 404);
		}
		
		$this->templateService->deleteFileTemplates($template, $request);
		
		return response()->json(array("status" => "1", "message" => "Arquivo deletado com sucesso!"));
	}
}