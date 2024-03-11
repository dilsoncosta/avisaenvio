<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class ProfileRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"avatar"   => "image|mimes:jpg,jpeg,png",
			"username" => "required|regex:/^[a-z0-9_]+$/",
      "name"     => "required_if:people,F|max:45",
			'people'   => 'required',
      "surname"  => "required_if:people,F|max:45",
			"corporate_name" => 'required_if:people,J|max:120',
			"email"    => "required|email",
			"phone"    => "required|regex:/^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}+$/",
			"whatsapp" => "required|regex:/^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}+$/",
		];
	}
	
	public function messages()
	{
		$messages = [
			'people.required'   => 'O campo PESSOA é obrigatório!',
			"name.required_if"  => "O campo NOME é obrigatório",
			'name.max'          => 'O campo NOME deve ter no máximo 45 caracteres!',
			'username.required' => 'O campo USUÁRIO é obrigatório!',
			'username.regex'    => 'O campo USUÁRIO aceita somente letras minúsculas, números e underlines!',
			"surname.required_if" => "O campo SOBRENOME é obrigatório",
			'surname.max'        => 'O campo SOBRENOME deve ter no máximo 45 caracteres!',
			'corporate_name.required_if' => 'O campo RAZÃO SOCIAL é obrigatório!',
      'corporate_name.max' => 'O campo RAZÃO SOCIAL deve ter no máximo 120 caracteres!',
			"email.required"    => "O campo E-MAIL é obrigatório",
			'email.email'       => 'E-MAIL inválido!',
			'avatar.image'      => "AVATAR Inválido!",
			'avatar.mimes'      => "Ops! Extensão do AVATAR Inválido.",
			"phone.required"    => "O campo TELEFONE é obrigatório",
			'phone.regex'       => 'Entre com um TELEFONE válido! Formato: [Código do País][Código de Área][Número do Celular] Ex.: 5531911112222!',
			"whatsapp.required" => "O campo WHATSAPP é obrigatório",
			'whatsapp.regex'    => 'Entre com um WHATSAPP válido! Formato: [Código do País][Código de Área][Número do Celular] Ex.: 5531911112222!',
		];
		
		return $messages;
	}
}
