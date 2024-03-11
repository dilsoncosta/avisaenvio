<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class AuthRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"username"    => "required|min:3|max:45",
			"password"    => "required",
			"device_name" => "required",
		];
	}

	public function messages()
	{
		$messages = [
			"username.required"    => "O campo USUÁRIO é obrigatório",
			"password.required"    => "O campo SENHA é obrigatório",
			"device_name.required" => "O campo NOME DO DISPOSITIVO é obrigatório",
		];
		
		return $messages;
	}
}
