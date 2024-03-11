<?php

namespace App\Http\Webhook;

use Illuminate\Http\Request;
use App\Jobs\{
	CrmWhatsAppBotJob
};

class ApiWhatsApp
{
	public function messages_upsert(Request $request)
	{
		$requestData = $request->all();
		
		CrmWhatsAppBotJob::dispatch($requestData);
	}
}