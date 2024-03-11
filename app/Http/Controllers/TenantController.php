<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
	Access,
	Tenant
};

class TenantController extends Controller
{
	private $model_access;
	private $model_tenant;
	
	public function __construct(Access $access, Tenant $tenant)
	{
		$this->model_access = $access;
		$this->model_tenant = $tenant;
	}
	
	public function getSubdomain(Request $request)
	{
		$checkSubdomain = $this->model_tenant->where('subdomain', $request->subdomain)->count();
		
		if(!$checkSubdomain)
		{
			return response()->json(['status' => 0, 'message' => 'SUBDOMINIO inexistente!'], 404);
		}
		
		return response()->json(['status' => 1, 'message' => 'OK']);
	}
}