<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class HospitalityRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      "ind_msg_1"         => "required",
      "msg_1_template_id" => "required_if:ind_msg_1,1,2,3,4,5,6",
      "ind_msg_2"         => "required",
      "msg_2_template_id" => "required_if:ind_msg_2,1,2,3,4,5,6",
      "ind_msg_3"         => "required",
      "msg_3_template_id" => "required_if:ind_msg_3,1,2,3,4,5,6",
      "ind_msg_4"         => "required",
      "msg_4_template_id" => "required_if:ind_msg_4,1,2,3,4,5,6",
      "ind_msg_5"         => "required",
      "msg_5_template_id" => "required_if:ind_msg_5,1,2,3,4,5,6",
      "ind_msg_6"         => "required",
      "msg_6_template_id" => "required_if:ind_msg_6,1,2,3,4,5,6",
		];
	}
	
	public function messages()
	{
		$messages = [
      "ind_msg_1.required"            => "O Campo ENVIO da Mensagem de Boas-Vindas!",
      "msg_1_template_id.required_if" => "O Campo Escolha o Template da Mensagem de Boas-Vindas é obrigatório!",
			"ind_msg_2.required"            => "O Campo ENVIO da Mensagem de Informações do Check-in!",
      "msg_2_template_id.required_if" => "O Campo Escolha o Template Informações do Check-in é obrigatório!",
			"ind_msg_3.required"            => "O Campo ENVIO da Mensagem dia do Check-in!",
      "msg_3_template_id.required_if" => "O Campo Escolha o Template Mensagem dia do Check-in é obrigatório!",
			"ind_msg_4.required"            => "O Campo ENVIO da Mensagem de Agradecimento do Checkout!",
      "msg_4_template_id.required_if" => "O Campo Escolha o Template Mensagem de Agradecimento do Checkout!",
			"ind_msg_5.required"            => "O Campo ENVIO da Mensagem Pesquisa de Sastifação!",
      "msg_5_template_id.required_if" => "O Campo Escolha o Template Mensagem Pesquisa de Sastifação!",
			"ind_msg_6.required"            => "O Campo ENVIO da Mensagem de Oferta!",
      "msg_6_template_id.required_if" => "O Campo Escolha o Template Mensagem Mensagem de Oferta!",
		];
		
		return $messages;
	}
}
