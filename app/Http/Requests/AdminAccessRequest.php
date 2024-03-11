<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class AdminAccessRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"tenant_id"                  => "required|exists:tenants,id",
			"period"                     => "required",
			"type"                       => "required",
			"date_start"                 => "required",
			"date_end"                   => "required",
			"situation"                  => "required",
			"ind_mod_portal"             => "required",
			"ind_mod_crm"                => "required",
			"ind_mod_store"              => "required",
			"qtd_contact"                => "required",
			"qtd_franchise"              => "required",
			"qtd_franchise_collaborator" => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
			"tenant_id.required"                  => "O campo CLIENTE é obrigatório",
			'period.required'                     => 'O campo PERIODO é obrigatório!',
			'type.required'                       => 'O campo TIPO é obrigatório!',
			"tenant_id.exists"                    => "Cliente Inexistente!",
			'date_start.required'                 => 'O campo DATA INICIO é obrigatório!',
			'date_end.required'                   => 'O campo DATA FIM é obrigatório!',
			'situation.required'                  => 'O campo SITUAÇÃO é obrigatório!',
			'qtd_contact.required'                => 'O campo CONTATOS é obrigatório!',
			'qtd_franchise.required'              => 'O campo FRANQUEADOS é obrigatório!',
			'qtd_franchise_collaborator.required' => 'O campo COLABORADORES DO FRANQUEADO é obrigatório!',
			'ind_mod_portal.required'             => 'O campo MÓDULO PORTAL é obrigatório!',
			'ind_mod_crm.required'                => 'O campo MÓDULO CRM é obrigatório!',
			'ind_mod_store.required'              => 'O campo MÓDULO LOJA VIRTUAL é obrigatório!',
		];
		
		return $messages;
	}
}
