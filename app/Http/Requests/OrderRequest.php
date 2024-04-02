<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class OrderRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      "code"             => "required",
      "destination"      => "required",
			"whatsapp"         => "required|regex:/^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}+$/",
      "object"           => "required",
      "shipping_company" => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "code.required"             => "O campo CÓDIGO é obrigatório!",
      "destination.required"      => "O campo DESATINATÁRIO é obrigatório!",
      "whatsapp.required"         => "O campo WHATSAPP é obrigatório!",
			'whatsapp.regex'            => 'Entre com um WHATSAPP válido! Formato: [Código do País][Código de Área][Número do Celular] Ex.: 5531911112222!',
      "object.required"           => "O campo OBJETO é obrigatório!",
      "shipping_company.required" => "O campo TRANSPORTADORA é obrigatório!",
		];
		
		return $messages;
	}
}
