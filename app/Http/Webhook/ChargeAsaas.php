<?php

namespace App\Http\Webhook;

use App\Jobs\ChargeAsaasJob;
use Illuminate\Http\Request;

class ChargeAsaas
{
	public function index(Request $request)
	{
		$requestData = (object) $request->all();
		
		ChargeAsaasJob::dispatch($requestData);
		
		return response()->json(['message' => 'Request processed successfully'], 200);
	}
}