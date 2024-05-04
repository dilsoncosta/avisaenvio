<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class IntegrationNuvemShopRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"idApp" => "required",
			"code" => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "idApp.required" => "O campo ID DO APLICATIVO é obrigatório",
			"code.required"  => "O campo CÓDIGO é obrigatório",
		];
		
		return $messages;
	}
}
