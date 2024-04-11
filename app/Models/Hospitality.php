<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class Hospitality extends Model
{
	use TenantTrait;
	
	protected $table = 'hospitalities';
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'ind_msg_1',
		'ind_msg_2',
		'ind_msg_3',
		'ind_msg_4',
		'ind_msg_5',
		'ind_msg_6',
		'msg_1_template_id',
		'msg_2_template_id',
		'msg_3_template_id',
		'msg_4_template_id',
		'msg_5_template_id',
		'msg_6_template_id',
	];
}
