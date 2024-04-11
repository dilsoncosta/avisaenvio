<?php

namespace App\Services;

use App\Models\{
	Hospitality
};

class HospitalityService
{
	private $hotel;
	
	public function __construct(Hospitality $hotel)
	{
		$this->hotel = $hotel;
	}
	
	public function getAllHotel()
	{
		return $this->hotel->first();
	}
	
	public function updateHotel($request)
	{
		$dataHotel = [
			"ind_msg_1"         => $request->ind_msg_1, 
			"msg_1_template_id" => $request->msg_1_template_id, 
			"ind_msg_2"         => $request->ind_msg_2, 
			"msg_2_template_id" => $request->msg_2_template_id,
			"ind_msg_3"         => $request->ind_msg_3, 
			"msg_3_template_id" => $request->msg_3_template_id,
			"ind_msg_4"         => $request->ind_msg_4, 
			"msg_4_template_id" => $request->msg_4_template_id,
			"ind_msg_5"         => $request->ind_msg_5, 
			"msg_5_template_id" => $request->msg_5_template_id,
			"ind_msg_6"         => $request->ind_msg_6, 
			"msg_6_template_id" => $request->msg_6_template_id,
		];
		
		if(!$this->getAllHotel())
		{
			$this->hotel->create($dataHotel);
		}
		else
		{
			$this->hotel->where('tenant_id', auth()->user()->tenant_id)->update($dataHotel);
		}
	}
}
