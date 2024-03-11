<?php
namespace App\Observers;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class TenantObserver
{
	public function creating(Model $model)
	{
		if (auth()->check())
		{
			if(auth()->user()->category != 'MT')
			{
				$model->setAttribute('tenant_id', auth()->user()->tenant->id); 
			}
		}
		$model->setAttribute('uuid', str::uuid());
	}
}