<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class TrackingResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'            => $this->uuid,
			'id'              => $this->id,
			'destination'     => $this->destination,
			'whatsapp'        => $this->whatsapp,
			'object'          => $this->object,
			'situation'       => $this->situation,
			'tracking_events' => TrackingEventResource::collection($this->trackingEvents),
			'created_at'      => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'      => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}