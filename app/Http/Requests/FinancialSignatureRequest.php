<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class FinancialSignatureRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      "ind_mod"        => "required",
			"type"           => 'required',
			"cnpj"           => 'required_if:type,0',
      "razap_social"   => "required_if:type,0",
			"name"           => 'required_if:type,1',
			"surname"        => 'required_if:type,1',
      "cpf"            => "required_if:type,1",
			"email"          => 'required_if:type,1',
			"phone"          => 'required',
      "whatsapp"       => "required",
			"cep"            => "required",
			"city"           => 'required',
			"number"         => 'required',
      "neighborhood"   => "required",
			"address"        => "required",
			"card_name"      => 'required',
      "card_number"    => "required",
			"card_month_exp" => 'required',
      "card_year_exp"  => "required",
      "card_cvv"       => "required",
			"total"          => "required",
		];
	}
	
	public function messages()
	{
		$messages = [
      "ind_mod.required"         => "O campo MÓDULO é obrigatório!",
			"type.required"            => "O campo TIPO é obrigatório!",
      "cnpj.required_if"         => "O campo CNPJ é obrigatório!",
			"razap_social.required_if" => "O campo RAZÃO SOCIAL é obrigatório!",
      "name.required_if"         => "O campo NOME é obrigatório!",
			"surname.required_if"      => "O campo SOBRENOME é obrigatório!",
			"cpf.required_if"          => "O campo CPF é obrigatório!",
			"email.required_if"        => "O campo E-MAIL é obrigatório!",
			"phone.required"          => "O campo TELEFONE é obrigatório!",
			"whatsapp.required"       => "O campo WHATSAPP é obrigatório!",
			"cep.required"            => "O campo CEP é obrigatório!",
			"city.required"           => "O campo CITY é obrigatório!",
			"number.required"         => "O campo NÚMERO é obrigatório!",
			"neighborhood.required"   => "O campo BAIRRO é obrigatório!",
			"address.required"        => "O campo ENDEREÇO é obrigatório!",
			"card_name.required"      => "O campo NOME IMPRESSO NO CARTÃO é obrigatório!",
			"card_number.required"    => "O campo NÚMERO DO CARTÃO é obrigatório!",
			"card_month_exp.required" => "O campo MÊS DE EXPIRAÇÃO é obrigatório!",
			"card_year_exp.required"  => "O campo ANO DE EXPIRAÇÃO COM 4 DIGITOS é obrigatório!",
			"card_cvv.required"       => "O campo CÓDIGO DE SEGURANÇA é obrigatório!",
			"total.required"          => "Valor total da assinatura não encontrado!",
		];
		
		return $messages;
	}
}
