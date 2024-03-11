<?php 
namespace App\Services;

use App\Models\{
	IntegrationWhatsApp
};

class IntegrationWhatsAppService
{
	protected $integrationWhatsApp;
	
	public function __construct(IntegrationWhatsApp $integrationWhatsApp)
	{
		$this->integrationWhatsApp = $integrationWhatsApp;
	}
	
	public function getIntegrationWhatsApp($request)
	{
		return $this->integrationWhatsApp->where('id', $request->integration_whatsapp_id)->first();
	}
	
	public function updateIntegrationWhatsApp($id, $data)
	{
		return $this->integrationWhatsApp->where('id', $id)->update($data);
	}
	
	public function updateSituationIntegrationWhatsApp($id, $situation)
	{
		return $this->integrationWhatsApp->where('id', $id)
							->update([
								'situation'          => $situation,
							]);
	}
}
