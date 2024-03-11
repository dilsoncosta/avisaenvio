<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class Collaborator extends Model
{
	use TenantTrait;
	
	protected $table = 'collaborators';
	
	protected $fillable = [
    'tenant_id',
    'uuid',
    'user_id',
	];
	
	public function user()
	{
		return $this->belongsTo(User::class, 'user_id', 'id');
	}
	
	public function permissions()
	{
		return $this->belongsToMany(Permission::class, 'permission_collaborators', 'collaborator_id', 'permission_id');
	}
}
