<?php

namespace App\Http\GenerateOptions;

use Illuminate\Http\Request;
use DB;

class GenerateOptionsStates
{
	public function index(Request $request)
	{
		$states = DB::table('states')->get();
		
		if(empty($states))
		{
			return response()->json(array("status" => "0", "message" => "Incapaz de realizar a listagem dos estados!"), 400);
		}
		
		return response()->json(array("status" => "1", "message" => "", "data" => $states));
	}
}