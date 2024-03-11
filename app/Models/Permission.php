<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Permission extends Model
{
	use UuidTrait;
	
	protected $table = 'permissions';
	
	protected $fillable = [
    'name',
    'uuid',
		'resource_id',
		'order'
	];
	
	public function permission_resource()
	{
		return $this->belongsTo(Resource::class, 'resource_id', 'id');
	}
	
	public function collaborator()
	{
		return $this->belongsToMany(Collaborator::class, 'permission_collaborators', 'permission_id', 'collaborator_id');
	}
}
