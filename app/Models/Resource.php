<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTrait;

class Resource extends Model
{
	use UuidTrait;
	
	protected $table = 'resources';
	
	protected $fillable = [
		'uuid',
    'name',
    'order',
		'situation',
	];
	
	public function permissions()
	{
		return $this->hasMany(Permission::class, 'resource_id', 'id')->orderBy('order', 'asc');
	}
}
