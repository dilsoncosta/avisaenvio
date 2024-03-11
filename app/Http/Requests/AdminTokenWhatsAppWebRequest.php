<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class AdminTokenWhatsAppWebRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
     "client_id" => "required",
		 "title"     => "required",
     "url"       => "required",
     "port"      => "required",
     "situation" => "required"
		];
	}
	
	public function messages()
	{
		$messages = [
      "client_id.required" => "O campo CLIENTE é obrigatório!",
			"title.required"     => "O campo TÍTULO é obrigatório!",
      "url.required"       => "O campo URL é obrigatório!",
      "port.required"      => "O campo PORTA é obrigatório!",
			"whatsapp.required"  => "O campo WHATSAPP é obrigatório!",
      "situation.required" => "O campo SITUAÇÃO é obrigatório!",
		];
		
		return $messages;
	}
}
