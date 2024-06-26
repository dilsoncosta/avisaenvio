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
		'api_address',
		'code',
		'adm_user',
		'store_plan',
		'user_id',
		'store',
		'store_host',
		'store_id',
		'date_expiration_access_token',
		'date_expiration_refresh_token',
		'date_activated',
		'refresh_token',
	];
}