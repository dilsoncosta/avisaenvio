<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class Template extends Model
{
	use TenantTrait;
	
	protected $table = 'templates';
	
	protected $fillable = [
		'tenant_id',
		'type',
		'title',
		'message',
		'situation',
		'file_1',
		'filename_storage_1',
		'filename_1',
		'ext_1',
		'size_1',
		'file_2',
		'filename_storage_2',
		'filename_2',
		'ext_2',
		'size_2',
		'file_3',
		'filename_storage_3',
		'filename_3',
		'ext_3',
		'size_3'
	];
}
