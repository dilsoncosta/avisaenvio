<?php
namespace App\Observers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class UuidObserver
{
	public function creating(Model $model)
	{
		$model->setAttribute('uuid', str::uuid());
	}
}