<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class ResetPassworddRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			'password'              => 'required|min:6|confirmed',
      'password_confirmation' => 'required',
      'token'                 => 'required',
		];
	}
	
	public function messages()
	{
		$messages = [
      'token.required' => 'O campo TOKEN é obrigatório!',
      'password.required' => 'O campo SENHA é obrigatório!',
      'password.min' => 'O campo SENHA deve ter no minimo de 6 caracteres!',
      'password.confirmed' => 'A confirmação da senha não corresponde!',
      'password_confirmation.required' => 'O campo CONFIRMAÇÃO DE SENHA é obrigatório!',
		];
		
		return $messages;
	}
}