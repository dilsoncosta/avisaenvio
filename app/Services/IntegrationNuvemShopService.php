<?php 
namespace App\Services;

use App\Models\{
  IntegrationNuvemShop
};

class IntegrationNuvemShopService
{
	protected $integrationNuvemShop;
	
	public function __construct(IntegrationNuvemShop $integrationNuvemShop)
	{
		$this->integrationNuvemShop = $integrationNuvemShop;
	}
	
	public function getIntegrationNuvemShop()
	{
		return $this->integrationNuvemShop->first();
	}

	public function createIntegrationNuvemShop($data)
	{
		return $this->integrationNuvemShop->create($data);
	}
	
	public function updateIntegrationNuvemShop($uuid, $data)
	{
		return $this->integrationNuvemShop->where('uuid', $uuid)->update($data);
	}
}
