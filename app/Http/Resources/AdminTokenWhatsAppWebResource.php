<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminTokenWhatsAppWebResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id'         => $this->id,
			'uuid'       => $this->uuid,
			'client'     => new UserResource($this->client->user),
			'url'        => $this->url,
			'title'      => $this->title,
			'whatsapp'   => $this->whatsapp,
			'port'       => $this->port,
			'situation'  => $this->situation,
			'created_at' => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at' => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}