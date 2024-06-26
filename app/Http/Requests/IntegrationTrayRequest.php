<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class IntegrationTrayRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"url" => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "url.required" => "O campo URL DA LOJA é obrigatório",
		];
		
		return $messages;
	}
}
