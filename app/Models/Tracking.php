<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class Tracking extends Model
{
	use TenantTrait;
	
	protected $table = 'trackings';
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'destination',
		'whatsapp',
		'object',
		'situation',
	];
	
	public function trackingEvents()
	{
		return $this->hasMany(TrackingEvent::class, 'tracking_id', 'id');
	}
}
