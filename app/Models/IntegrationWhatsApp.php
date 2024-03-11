<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class IntegrationWhatsApp extends Model
{
	use TenantTrait;
	
	protected $table = 'integration_whatsapp';
	
	protected $fillable = [
		'uuid',
		'tenant_id',
		'title',
		'app_key',
		'session_name',
		'port',
		'url',
		'whatsapp',
		'situation',
	];

	public function client()
	{
		return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
	}

	public function busienss()
	{
		return $this->belongsTo(CrmBusiness::class, 'crm_business_id', 'id');
	}
}
