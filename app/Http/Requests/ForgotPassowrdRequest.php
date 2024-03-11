<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class ForgotPassowrdRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			'username' => 'required|max:100',
			   'email' => 'required|email',
		];
	}
	
	public function messages()
	{
		$messages = [
			'username.required' => 'O campo UERNAME é obrigatório!',
			'username.max'      => 'O capo USERNAME não deve ter mais de 45 caracteres!',
			'email.required'    => 'O campo E-MAIL é obrigatório!',
			'email.email'       => 'O campo E-MAIL é inválido!'
		];
		
		return $messages;
	}
}