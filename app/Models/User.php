<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Traits\TenantTrait;

class User extends Authenticatable
{
	use HasApiTokens, HasFactory, Notifiable, TenantTrait;
	
	protected $table = 'users';
	
	protected $with = ['tenant', 'collaborator'];
	
	protected $fillable = [
		'tenant_id',
		'uuid',
		'username',
		'password',
		'subdomain',
		'people',
		'name',
		'surname',
		'corporate_name',
		'subdomain',
		'link_confirm',
		'email',
		'phone',
		'whatsapp',
		'avatar',
		'category',
		'situation'
	];
	
	public function tenant()
	{
		return $this->belongsTo(Tenant::class, 'tenant_id', 'id');
	}
	
	public function collaborator()
	{
		return $this->belongsTo(Collaborator::class, 'id', 'user_id');
	}
}
