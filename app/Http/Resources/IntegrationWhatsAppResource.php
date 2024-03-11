<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationWhatsAppResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id'           => $this->id,
			'title'        => $this->title,
			'uuid'         => $this->uuid,
			'url'          => $this->url,
			'port'         => $this->port,
			'whatsapp'     => $this->whatsapp,
			'session_name' => $this->session_name,
			'created_at'   => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'   => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}