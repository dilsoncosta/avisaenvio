<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\CepResource;

class GenerateOptionsCep
{
	public function index(Request $request)
	{
		if(!isset($request->cep) || empty($request->cep))
		{
			return response()->json(array("status" => "0", "message" => "O CEP é obrigatório!"), 400);
		}
		
		$response = Http::get('https://viacep.com.br/ws/'.$request->cep.'/json/');
		
		if($response->successful())
		{
			$tmp = $response->json();
			
			if((empty($tmp['uf']) && empty($tmp['localidade'])) ||
		    (strlen($tmp['uf']) < 2 && strlen($tmp['localidade']) < 2)
			)
			{
				return response()->json(array("status" => "0", "message" => "O CEP ".$request->cep." não existe!"), 400);
			}
			
			return response()->json(array("status" => "1", "message" => "", "data" => new CepResource((object) $tmp)));
		}
		else
		{
			return response()->json(array("status" => "0", "text" => "Incapaz de comunicar com o computador dos correios. Serviço temporariamente indisponível!"), 503);
		}
	}
}