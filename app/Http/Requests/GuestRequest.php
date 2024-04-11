<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class GuestRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      "name_surname"     => "required",
			"whatsapp"         => "required|regex:/^[1-9]{2}[1-9]{2}[2-9][0-9]{7,8}+$/",
			"date_checkin"     => 'required',
			"date_checkout"    => 'required',
      "situation"        => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "name_surname.required"  => "O campo NOME E SOBRENOME é obrigatório!",
			"whatsapp.required"      => "O campo WHATSAPP é obrigatório!",
      "date_checkin.required"  => "O campo DATA DE CHECK-IN é obrigatório!",
			"date_checkout.required" => "O campo DATA DE CHECK-OUT é obrigatório!",
      "situation.required"     => "O campo SITUAÇÃO é obrigatório!",
		];
		
		return $messages;
	}
}
