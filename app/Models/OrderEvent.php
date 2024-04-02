<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class OrderEvent extends Model
{
	use TenantTrait;
	
	protected $table = 'order_events';
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'order_id',
		'template_id',
		'date_event',
		'status_event',
		'msg_event',
		'status_send',
		'msg_send',
	];
	
	public function template()
	{
		return $this->belongsTo(Template::class, 'template_id', 'id');
	}
}
