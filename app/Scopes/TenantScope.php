<?php
namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Auth;

class TenantScope implements Scope
{
	public function apply(Builder $builder, Model $model)
	{
		if (auth()->check())
		{ 
			if(auth()->user()->category != 'MT')
			{
				$builder->where($model->getTable().'.tenant_id', auth()->user()->tenant->id); 
			}
		} 
	}
}