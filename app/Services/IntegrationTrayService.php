<?php 
namespace App\Services;

use App\Models\{
  IntegrationTray
};

class IntegrationTrayService
{
	protected $integrationTray;
	
	public function __construct(IntegrationTray $integrationTray)
	{
		$this->integrationTray = $integrationTray;
	}
	
	public function getIntegrationTray()
	{
		return $this->integrationTray->first();
	}
	
	public function createIntegrationTray($data)
	{
		return $this->integrationTray->create($data);
	}
	
	public function updateIntegrationTray($uuid, $data)
	{
		return $this->integrationTray->where('uuid', $uuid)->update($data);
	}
	
	public function updateActiveIntegrationTray($url, $data)
	{
		return $this->integrationTray->where('url_store', $url)->update($data);
	}
}
