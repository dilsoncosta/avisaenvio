<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use App\Http\Resources\{
	IntegrationWhatsAppResource
};
use App\Models\{
	IntegrationWhatsApp,
};

class GenerateOptionsIntegrationWhatsApp
{
  private $model_conf_integration_whatsapp;
	
	public function __construct(
		IntegrationWhatsApp $conf_integration_whatsapp
	)
	{
		$this->model_conf_integration_whatsapp = $conf_integration_whatsapp;
	}
	
	public function index(Request $request)
	{
		$conf_integration_whatsapps = $this->model_conf_integration_whatsapp
																			->where('situation', 1)
																			->orderBy('id', 'DESC')
																			->get();
		
		if (!count((is_countable($conf_integration_whatsapps) ? $conf_integration_whatsapps : [])))
		{
			return response()->json(array("status" => "0", "message" => "Nenhum registro encontrado!"), 404);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => IntegrationWhatsAppResource::collection($conf_integration_whatsapps)));
	}
}