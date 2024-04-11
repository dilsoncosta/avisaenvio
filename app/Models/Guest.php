<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class Guest extends Model
{
	use TenantTrait;
	
	protected $table = 'guests';
	
	protected $fillable = [
		'tenant_id',
		'hospitality_id',
		'uuid',
		'name_surname',
		'whatsapp',
		'date_checkin',
		'date_checkout',
		'whatsapp',
		'situation',
		'ind_msg_1'        ,
		'msg_1_template_id',
		'msg_1_status_send',
		'msg_1_msg_send'   ,
		'ind_msg_2'        ,
		'msg_2_template_id',
		'msg_2_status_send',
		'msg_2_msg_send'   ,
		'ind_msg_3'        ,
		'msg_3_template_id',
		'msg_3_status_send',
		'msg_3_msg_send'   ,
		'ind_msg_4'        ,
		'msg_4_template_id',
		'msg_4_status_send',
		'msg_4_msg_send'   ,
		'ind_msg_5'        ,
		'msg_5_template_id',
		'msg_5_status_send',
		'msg_5_msg_send'   ,
		'ind_msg_6'        ,
		'msg_6_template_id',
		'msg_6_status_send',
		'msg_6_msg_send'   ,
	];
	
	public function msgOneTemplate()
	{
		return $this->belongsTo(Template::class, 'msg_1_template_id', 'id');
	}
	
	public function msgTwoTemplate()
	{
		return $this->belongsTo(Template::class, 'msg_2_template_id', 'id');
	}
	
	public function msgThreeTemplate()
	{
		return $this->belongsTo(Template::class, 'msg_3_template_id', 'id');
	}

	public function msgFourTemplate()
	{
		return $this->belongsTo(Template::class, 'msg_4_template_id', 'id');
	}
	
	public function msgFiveTemplate()
	{
		return $this->belongsTo(Template::class, 'msg_5_template_id', 'id');
	}
	
	public function msgSixTemplate()
	{
		return $this->belongsTo(Template::class, 'msg_6_template_id', 'id');
	}
}
