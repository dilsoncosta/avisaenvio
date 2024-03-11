<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class AdminResourceRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
     "name"            => "required",
     "order"           => "required",
     "situation"       => "required"
		];
	}
	
	public function messages()
	{
		$messages = [
      "name_surname.required" => "O campo NOME é obrigatório!",
      "order.required"        => "O campo ORDEM é obrigatório!",
			"situation.required"    => "O campo SITUAÇAO é obrigatório!",
		];
		
		return $messages;
	}
}
