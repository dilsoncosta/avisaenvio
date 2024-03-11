<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class AdminPermissionRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
"resource_id" => "required",
       "name" => "required",
      "order" => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "resource_id.required" => "O campo NOME DO MÓDULO é obrigatório!",
      "name.required"        => "O campo NOME DA PERMISSÃO é obrigatório!",
			"order.required"       => "O campo ORDEM é obrigatório!",
		];
		
		return $messages;
	}
}
