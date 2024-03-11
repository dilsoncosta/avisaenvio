<?php 
namespace App\Services;

use App\Http\Requests\AdminAccessRequest;
use App\Http\Resources\AdminAccessResource;
use App\Models\Access;

class AdminAccessService
{
	private $access;
	
	public function __construct(Access $access)
	{
		$this->access = $access;
	}
	
	public function getAllTenants($request)
	{
		return $this->access
								->where('tenant_id', $request->tenant_id)
								->first();
	}
	
	public function update($request)
	{
		$this->access->where('tenant_id', $request->tenant_id)
				->update([
						'period' => $request->period,
						'type' => $request->type,
						'date_start' => $request->date_start,
						'date_end' => $request->date_end,
						'situation' => $request->situation,
						'ind_mod_portal' => $request->ind_mod_portal,
						'ind_mod_crm' => $request->ind_mod_crm,
						'ind_mod_store' => $request->ind_mod_store,
						'qtd_contact' => $request->qtd_contact,
						'qtd_franchise' => $request->qtd_franchise,
						'qtd_franchise_collaborator' => $request->qtd_franchise_collaborator,
				]);
	}
}
