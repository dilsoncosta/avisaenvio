<?php

namespace App\Models;

use App\Traits\TenantTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Access extends Model
{
	use TenantTrait, HasFactory;

	protected $table = 'access';
	
	protected $fillable = [
    'tenant_id',
    'uuid',
    'period',
    'type',
    'date_start',
    'date_end',
    'situation',
	];
	
	public function tenant()
	{
		return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
	}
}
