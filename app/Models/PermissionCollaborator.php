<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class PermissionCollaborator extends Model
{
	use TenantTrait;
	
	protected $table = 'permission_collaborators';
	
	protected $fillable = [
    'tenant_id',
    'collaborator_id',
    'permission_id',
    'uuid'
	];
}
