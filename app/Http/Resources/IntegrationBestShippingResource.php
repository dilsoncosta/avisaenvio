<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class IntegrationBestShippingResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id'           => $this->id,
			'uuid'         => $this->uuid,
			'token'        => $this->token,
			'situation'    => $this->situation,
			'created_at'   => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'   => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}