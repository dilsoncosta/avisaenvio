<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use DB;

class GenerateOptionsCities
{
	public function index(Request $request)
	{
		if(!isset($request->state) || empty($request->state))
		{
			return response()->json(array("status" => "0", "message" => "O ESTADO é obrigatório!"));
		}
		
		$states = DB::table('states')->where('letter', '=', $request->state)->first();
		
		if(empty($states))
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem das cidades. Estado Inexistente!"), 400);
		}
		
		$cities = DB::table('cities')->select('iso', 'title')
																->where('state_id', '=', $states->id)->get();
		
		return response()->json(array("status" => "1", "message" => "", "data" => $cities));
	}
}