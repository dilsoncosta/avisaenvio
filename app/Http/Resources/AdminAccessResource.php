<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminAccessResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'                        => $this->uuid,
			'period'                      => $this->period,
			'type'                        => $this->type,
			'date_start'                  => $this->date_start,
			'date_end'                    => $this->date_end,
			'situation'                   => $this->situation,
			'created_at'                  => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'                  => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}