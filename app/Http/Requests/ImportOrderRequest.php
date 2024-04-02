<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class ImportOrderRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
			"file"        => "required|file|mimes:xlsx|max:262144000",
		];
	}
	
	public function messages()
	{
		$messages = [
      "file.required"        => "O campo ARQUIVO é obrigatório",
      "file.mimes"           => "Ops! Extensão de ARQUIVO Inválido.",
      "file.file"            => "Arquivo Inválido.",
      "file.max"             => "O tamanho do ARQUIVO permitido é até 250MB.",
		];
		
		return $messages;
	}
}
