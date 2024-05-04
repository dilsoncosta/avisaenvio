<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class IntegrationNuvemShop extends Model
{
	use TenantTrait;
	
	protected $table = 'integration_nuvem_shops';
	
	protected $fillable = [
		'uuid',
		'tenant_id',
		'access_token',
		'scope',
		'token_type',
		'user_id',
		'idapp',
		'code',
		'situation',
	];
}
