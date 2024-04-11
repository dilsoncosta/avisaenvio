<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class HospitalityResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'              => $this->uuid,
			'id'                => $this->id,
			'ind_msg_1'         => $this->ind_msg_1,
			'ind_msg_2'         => $this->ind_msg_2,
			'ind_msg_3'         => $this->ind_msg_3,
			'ind_msg_4'         => $this->ind_msg_4,
			'ind_msg_5'         => $this->ind_msg_5,
			'ind_msg_6'         => $this->ind_msg_6,
			'msg_1_template_id' => $this->msg_1_template_id,
			'msg_2_template_id' => $this->msg_2_template_id,
			'msg_3_template_id' => $this->msg_3_template_id,
			'msg_4_template_id' => $this->msg_4_template_id,
			'msg_5_template_id' => $this->msg_5_template_id,
			'msg_6_template_id' => $this->msg_6_template_id,
			'created_at'        => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'        => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s')
		];
	}
}