<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use App\Http\Resources\{
  TenantResource,
};
use App\Models\{
	Tenant,
};
use DB;
use Illuminate\Support\Facades\Http;

class GenerateOptionsTenants
{
  private $model_tenant;
	
	public function __construct(
		Tenant $tenant
	)
	{
		$this->model_tenant = $tenant;
	}
	
	public function index(Request $request)
	{
		$tenants = $this->model_tenant
									->with('access')
									->with('user')
									->whereHas('user', function ($query) {
										return $query->where('category', '=', 'CL');
									})
									->get();
		
		if(!$tenants)
		{
			return response()->json(array("status" => "0", "message" => "Nenhum registro encontrado!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => TenantResource::collection($tenants)));
	}
}