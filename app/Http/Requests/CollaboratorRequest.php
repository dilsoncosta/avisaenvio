<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class CollaboratorRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      "username"          => "required|unique:users,username,".$this->user_id."|regex:/^[a-z0-9_]+$/",
      "people"            => 'required',
      "name"              => "required",
      "surname"           => "required",
      "email"             => "required|email",
      "phone"             => "required",
      "situation"         => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
			'people.required'    => 'O campo PESSOA é obrigatório!',
      "username.required"  => "O campo USUÁRIO é obrigatório",
      "name.required"      => "O campo NOME é obrigatório",
      "surname.required"   => "O campo SOBRENOME é obrigatório",
      "email.required"     => "O campo E-MAIL é obrigatório",
      "phone.required"     => "O campo CELULAR é obrigatório",
      "situation.required" => "O campo SITUAÇÃO é obrigatório",
      'username.unique'    => 'USUÁRIO já escolhido!',
      'username.regex'     => 'O campo USUÁRIO aceita somente letras minúsculas, números e underlines!',
		];
		
		return $messages;
	}
}
