<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class IntegrationBestShipping extends Model
{
	use TenantTrait;
	
	protected $table = 'integration_best_shippings';
	
	protected $fillable = [
		'uuid',
		'tenant_id',
		'token',
		'situation',
	];
}
