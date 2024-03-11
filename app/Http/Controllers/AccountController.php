<?php

namespace App\Http\Controllers;

use App\Services\AccountService;
use Illuminate\Http\Request;
use App\Http\Resources\AccountResource;

class AccountController extends Controller
{
	protected $accountService;
	
	public function __construct(AccountService $accountService)
	{
		$this->accountService = $accountService;
	}
	
	public function index(Request $request)
	{
		$account = $this->accountService->getAllAccountByTenantId();
		
		if (!$account)
		{
			return response()->json(["status" => "0", "message" => "Nenhum registro encontrado!"], 404);
		}
		
		$data = new AccountResource($account);
		
		return response()->json(array("status" => "1", "message" => "", "data" => $data));
	}
	
	public function update(Request $request)
	{
		$this->accountService->updateAccount($request);
		
		return response()->json(array("status" => "1", "message" => "Registro atualizado com sucesso!"));
	}
	
	public function destroyCertificate(Request $request)
	{
		$tenant = $this->accountService->getAllAccountByTenantId();
		
		if(!$tenant)
		{
			return response()->json(array("status" => "0", "message" => "Nenhuma conta encontrada!"), 400);
		}
		
		$this->accountService->deleteCertificate($tenant);
		
		return response()->json(array("status" => "1", "message" => "Arquivo deletado com sucesso!"));
	}
	
	public function destroyLogoPortal(Request $request)
	{
		$tenant = $this->accountService->getAllAccountByTenantId();
		
		if(!$tenant)
		{
			return response()->json(array("status" => "0", "message" => "Nenhuma conta encontrada!"), 400);
		}
		
		$this->accountService->deleteLogoPortal($tenant);
		
		return response()->json(array("status" => "1", "message" => "Arquivo deletado com sucesso!"));
	}
}
