<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class IntegrationBestShippingRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"token" => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "token.required" => "O campo TOKEN é obrigatório",
		];
		
		return $messages;
	}
}
