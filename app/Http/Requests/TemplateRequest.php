<?php

namespace App\Http\Requests;

use App\Http\Requests\FormRequest as FormRequest;

class TemplateRequest extends FormRequest
{
	public function authorize()
	{
		return true;
	}
	
	public function rules()
	{
		return [
      "type"      => "required",
      "title"     => "required",
      "situation" => "required",
      "file_1"    => "mimes:jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4|max:262144000",
      "file_2"    => "mimes:jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4|max:262144000",
      "file_3"    => "mimes:jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4|max:262144000"
		];
	}
	
	public function messages()
	{
		$messages = [
      "type.required"      => "O campo TIPO é obrigatório!",
      "title.required"     => "O campo TITULO é obrigatório!",
      "situation.required" => "O campo SITUAÇÃO é obrigatório!",
      "file_1.mimes"       => "Ops! ARQUIVO #1 inválido(s). Extensões permitidas: jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4.",
      "file_1.max"         => "O tamanho do ARQUIVO #1 permitido é até 250MB.",
      "file_2.mimes"       => "Ops! ARQUIVO #2 inválido(s). Extensões permitidas: jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4.",
      "file_2.max"         => "O tamanho do ARQUIVO #2 permitido é até 250MB.",
      "file_3.mimes"       => "Ops! ARQUIVO #3 inválido(s). Extensões permitidas: jpg,jpeg,png,mp3,ogg,pdf,doc,docx,rar,zip,xlsx,mp4.",
      "file_3.max"         => "O tamanho do ARQUIVO #3 permitido é até 250MB.",
		];
		
		return $messages;
	}
}
