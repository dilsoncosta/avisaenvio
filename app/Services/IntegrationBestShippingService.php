<?php 
namespace App\Services;

use App\Models\{
  IntegrationBestShipping
};

class IntegrationBestShippingService
{
	protected $integrationBestShipping;
	
	public function __construct(IntegrationBestShipping $integrationBestShipping)
	{
		$this->integrationBestShipping = $integrationBestShipping;
	}
	
	public function getIntegrationBestShipping()
	{
		return $this->integrationBestShipping->first();
	}

	public function createIntegrationBestShipping($data)
	{
		return $this->integrationBestShipping->create($data);
	}
	
	public function updateIntegrationBestShipping($uuid, $data)
	{
		return $this->integrationBestShipping->where('uuid', $uuid)->update($data);
	}
}
