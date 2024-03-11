<?php
namespace App\Traits;

use App\Scopes\TenantScope;
use App\Observers\TenantObserver;
use Illuminate\Support\Str;

trait TenantTrait
{
	public static function boot()
	{
		parent::boot();
		
		static::addGlobalScope(new TenantScope);
		static::observe(new TenantObserver);
	}
}