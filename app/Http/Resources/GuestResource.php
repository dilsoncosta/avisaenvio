<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
	public function toArray($request)
	{
		return [
			'uuid'              => $this->uuid,
			'id'                => $this->id,
			'name_surname'      => $this->name_surname,
			'whatsapp'          => $this->whatsapp,
			'date_checkin'      => $this->date_checkin,
			'date_checkout'     => $this->date_checkout,
			'situation'         => $this->situation,
			'ind_msg_1'         => $this->ind_msg_1,
			'msg_1_template_id' => new TemplateResource($this->msgOneTemplate),
			'msg_1_status_send' => $this->msg_1_status_send,
			'msg_1_msg_send'    => $this->msg_1_msg_send,
			'ind_msg_2'         => $this->ind_msg_2,
			'msg_2_template_id' => new TemplateResource($this->msgTwoTemplate),
			'msg_2_status_send' => $this->msg_2_status_send,
			'msg_2_msg_send'    => $this->msg_2_msg_send,
			'ind_msg_3'         => $this->ind_msg_3,
			'msg_3_template_id' => new TemplateResource($this->msgThreeTemplate),
			'msg_3_status_send' => $this->msg_3_status_send,
			'msg_3_msg_send'    => $this->msg_3_msg_send,
			'ind_msg_4'         => $this->ind_msg_4,
			'msg_4_template_id' => new TemplateResource($this->msgFourTemplate),
			'msg_4_status_send' => $this->msg_4_status_send,
			'msg_4_msg_send'    => $this->msg_4_msg_send,
			'ind_msg_5'         => $this->ind_msg_5,
			'msg_5_template_id' => new TemplateResource($this->msgFiveTemplate),
			'msg_5_status_send' => $this->msg_5_status_send,
			'msg_5_msg_send'    => $this->msg_5_msg_send,
			'ind_msg_6'         => $this->ind_msg_6,
			'msg_6_template_id' => new TemplateResource($this->msgSixTemplate),
			'msg_6_status_send' => $this->msg_6_status_send,
			'msg_6_msg_send'    => $this->msg_6_msg_send,
			'created_at'    => Carbon::parse($this->created_at)->format('Y-m-d H:i:s'),
			'updated_at'    => Carbon::parse($this->updated_at)->format('Y-m-d H:i:s'),
		];
	}
}