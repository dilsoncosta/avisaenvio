<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminAccessRequest;
use App\Http\Resources\AdminAccessResource;
use Illuminate\Http\Request;
use App\Services\AdminAccessService;

class AdminAccessController extends Controller
{
	private $adminAccessService;
	
	public function __construct(AdminAccessService $adminAccessService)
	{
		$this->adminAccessService = $adminAccessService;
	}
	
	public function index(Request $request)
	{
		$access = $this->adminAccessService->getAllTenants($request);
		
		if(!$access)
		{
			return response()->json(array("status" => "0", "message" => "Registro inexistente!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => new AdminAccessResource($access)));
	}
	
	public function update(AdminAccessRequest $request)
	{
		$this->adminAccessService->update($request);
		
		return response()->json(['status' => 1, 'message' => 'Registro atualizado com sucesso!']);
	}
}