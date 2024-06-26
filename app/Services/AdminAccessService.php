<?php 
namespace App\Services;

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
						'period'                 => $request->period,
						'type'                   => $request->type,
						'ind_mod_order_tracking' => $request->ind_mod_order_tracking,
						'ind_mod_hotel'          => $request->ind_mod_hotel,
						'date_start'             => $request->date_start,
						'date_end'               => $request->date_end,
						'situation'              => $request->situation,
				]);
	}
}
