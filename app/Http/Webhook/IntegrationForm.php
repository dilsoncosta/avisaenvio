<?php

namespace App\Http\Webhook;

use App\Http\Requests\{
	WebhookIntegrationWPRequest
};
use App\Helpers\Helpers;
use App\Services\Webhook\IntegrationFormService;

class IntegrationForm
{
	private $integrationFormService;
	private $access;
	private $tenant_id;
	
	public function __construct(IntegrationFormService $integrationFormService)
	{
		$this->integrationFormService = $integrationFormService;
	}
	
	public function index(WebhookIntegrationWPRequest $request, $f_token = null, $e_token = null, $origin = 0, $conversation = null)
	{
		if(isset($request->f_token))
		{
			if(empty($request->f_token))
			{
				return response()->json(array("status" => "0", "message" => "Token Inexistente!"), 400);
			}
			
			$f_token = $request->f_token;
		}
		else
		{
			if(!isset($f_token))
			{
				return response()->json(array("status" => "0", "message" => "Token Inexistente!"), 400);
			}
			
			if(empty($f_token))
			{
				return response()->json(array("status" => "0", "message" => "Token Inexistente!"), 400);
			}
		}
		
		$funnel = $this->integrationFormService->getFunnelByToken($request->f_token);
		
		if(!$funnel)
		{
			return response()->json(array("status" => "0", "message" => "Funil não encontrado!"), 404);
		}
		
		$this->tenant_id = $funnel->tenant_id;
		$this->access    = Helpers::getInfoAccess($this->tenant_id);
		
		if ($this->access->situation != 'A')
		{
			return response()->json(array("status" => "0", "message" => "Acesso Inativo!"), 400);
		}
		
		if ($this->access->ind_mod_crm == '0')
		{
			return response()->json(array("status" => "0", "message" => "Módulo CRM Inativo!"), 400);
		}
		
		if(!isset($e_token) || empty($e_token))
		{
			$last_step = $this->integrationFormService->getLastStep($funnel);
		}
		else
		{
			$last_step = $this->integrationFormService->getStepByToken($e_token);
		}

		if(!$last_step)
		{
			return response()->json(array("status" => "0", "message" => "Nenhuma etapa encontrada para funil indicado"), 404);
		}
		
		if($this->integrationFormService->getExistedContact($funnel->crm_business_id, $funnel->id, $request->email) > 0)
		{
			return response()->json(array("status" => "0", "message" => "Contato já cadastrado para o NEGÓCIO e FUNIL indicado. Digite um e-mail diferente!"), 400);
		}
		
		if(isset($origin) && !in_array($origin,['0','1','2','3','4']))
		{
			return response()->json(array("status" => "0", "message" => "Origem incorreta!"), 404);
		}
		
		$dataContact = $this->integrationFormService->prepareDataContact($request, $funnel, $last_step, $origin, $conversation);
		
		if(!$dataContact)
		{
			return response()->json(array("status" => "0", "message" => "Nenhum VENDEDOR configurado para o NEGÓCIO do FUNIL indicado!"), 400);
		}
		
		$insert = $this->integrationFormService->createContact($dataContact);
		
		if($insert)
		{
			$this->integrationFormService->sendMessageContact($insert->id);
		}
		
		return response()->json(array("status" => "1", "message" => "Cadastro Efetuado com Sucesso!"));
	}
}