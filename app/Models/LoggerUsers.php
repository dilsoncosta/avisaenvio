<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\TenantTrait;

class LoggerUsers extends Model
{
	//use TenantTrait;
	
	protected $table = 'logger_users';
	
	protected $fillable = [
		'uuid',
		'username',
		'date',
		'description',
		'ip',
		'type'
	];
}
