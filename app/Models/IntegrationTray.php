<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class IntegrationTray extends Model
{
	use TenantTrait;
	
	protected $table = 'integration_trays';
	
	protected $fillable = [
		'uuid',
		'tenant_id',
		'access_token',
		'url_store',
		'code',
		'date_expiration_access_token',
		'date_expiration_refresh_token',
		'date_activated',
		'refresh_token',
		'situation',
	];
}