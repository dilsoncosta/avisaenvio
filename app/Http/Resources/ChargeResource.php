<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ChargeResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'                         => $this->uuid,
			'id'                           => $this->id,
			'type'                         => $this->type,
			'venc'                         => $this->venc,
			'situation'                    => $this->situation,
			'total'                        => $this->total,
			'asaas_invoice_number'         => $this->asaas_invoice_number,
			'asaas_transition_receipt_url' => $this->asaas_transition_receipt_url,
			'created_at'                   => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'                   => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}