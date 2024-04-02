<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderEventResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'id'           => $this->id,
			'uuid'         => $this->uuid,
			'date_event'   => $this->date_event,
			'status_event' => $this->status_event,
			'msg_event'    => $this->msg_event,
			'status_send'  => $this->status_send,
			'msg_send'     => $this->msg_send,
			'template'     => new TemplateResource($this->template),
			'created_at'   => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'   => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}