<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class RegisterRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      'subdomain'             => 'required',
      'username'              => 'required|unique:users|min:2|max:45|regex:/^[a-z0-9_]+$/',
      'password'              => 'required|min:6|max:30|confirmed',
      'password_confirmation' => 'required',
      'people'                => 'required',
      'name'                  => 'required_if:people,F|max:45',
      'surname'               => 'required_if:people,F|max:45',
      'corporate_name'        => 'required_if:people,J|max:120',
      'email'                 => 'required|email',
      'phone'                 => 'required|regex:/^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}+$/',
      'whatsapp'              => 'required|regex:/^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}+$/',
		];
	}
	
	public function messages()
	{
		$messages = [
			'subdomain.required' => 'O campo SUBDOMINIO é obrigatório!',
      'username.required'  => 'O campo USUÁRIO é obrigatório!',
      'username.unique'    => 'Usuário já escolhido!',
      'username.max'       => 'O campo USUÁRIO deve ter no máximo 45 caracteres!',
      'username.min'       => 'O campo USUÁRIO deve ter no minimo de 2 caracteres!',
      'username.regex'     => 'O campo USUÁRIO aceita somente letras minúsculas, números e underlines!',
      'password.required'  => 'O campo SENHA é obrigatório!',
      'password.min'       => 'O campo SENHA deve ter no minimo de 6 caracteres!',
      'password.max'       => 'O campo SENHA deve ter no máximo 30 caracteres!',
      'password.confirmed' => 'A confirmação da senha não corresponde!',
      'password_confirmation.required' => 'O campo CONFIRMAÇÃO DE SENHA é obrigatório!',
      'people.required'    => 'O campo PESSOA é obrigatório!',
      'name.required_if'      => 'O campo NOME é obrigatório!',
      'name.min'           => 'O campo NOME deve ter no minimo de 2 caracteres!',
      'name.max'           => 'O campo NOME deve ter no máximo 45 caracteres!',
      'surname.required_if'   => 'O campo SOBRENOME é obrigatório!',
      'surname.min'        => 'O campo SOBRENOME deve ter no minimo de 2 caracteres!',
      'surname.max'        => 'O campo SOBRENOME deve ter no máximo 45 caracteres!',
      'corporate_name.required_if' => 'O campo RAZÃO SOCIAL é obrigatório!',
      'corporate_name.min'      => 'O campo RAZÃO SOCIAL deve ter no minimo de 2 caracteres!',
      'corporate_name.max'      => 'O campo RAZÃO SOCIAL deve ter no máximo 120 caracteres!',
      'email.required'     => 'O campo E-MAIL é obrigatório!',
      'email.email'        => 'E-mail inválido!',
      'phone.required'     => 'O campo TELFONE é obrigatório!',
			'phone.regex'        => 'Entre com um TELEFONE válido! Formato: [Código do País][Código de Área][Número do Celular] Ex.: 5531911112222!',
			'whatsapp.required'  => 'O campo WHATSAPP é obrigatório!',
			'whatsapp.regex'     => 'Entre com um WHATSAPP válido! Formato: [Código do País][Código de Área][Número do WhatsApp] Ex.: 5531911112222!',
		];
		
		return $messages;
	}
}