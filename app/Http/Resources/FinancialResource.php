<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class FinancialResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'                          => $this->uuid,
			'id'                            => $this->id,
			'frequency'                     => $this->frequency,
			'next_due_date'                 => $this->next_due_date,
			'situation'                     => $this->situation,
			'payment'                       => $this->payment,
			'total'                         => $this->total,
			'ind_mod_order_tracking'        => $this->ind_mod_order_tracking,
			'ind_mod_hotel'                 => $this->ind_mod_hotel,
			'access_date_end'               => $this->access->date_end,
			'access_ind_mod_order_tracking' => $this->access->ind_mod_order_tracking,
			'access_ind_mod_hotel'          => $this->access->ind_mod_hotel,
			'access_situation'              => $this->access->situation,
			'created_at'                    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'                    => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}