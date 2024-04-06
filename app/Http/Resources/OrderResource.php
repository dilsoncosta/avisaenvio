<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'             => $this->uuid,
			'id'               => $this->id,
			'code'             => $this->code,
			'destination'      => $this->destination,
			'whatsapp'         => $this->whatsapp,
			'cpf_cnpj'         => $this->cpf_cnpj,
			'object'           => $this->object,
			'situation'        => $this->situation,
			'integration'      => $this->integration,
			'shipping_company' => $this->shipping_company,
			'last_situation'   => $this->last_situation,
			'order_events'     => OrderEventResource::collection($this->orderEvents),
			'created_at'       => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'       => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}