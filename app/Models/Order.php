<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class Order extends Model
{
	use TenantTrait;
	
	protected $table = 'orders';
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'code',
		'destination',
		'whatsapp',
		'object',
		'integration',
		'shipping_company',
		'last_situation',
	];
	
	public function orderEvents()
	{
		return $this->hasMany(OrderEvent::class, 'order_id', 'id');
	}
}
