<?php
namespace App\Traits;

use App\Observers\UuidObserver;
use Illuminate\Support\Str;

trait UuidTrait
{
	public static function boot()
	{
		parent::boot();
		
		static::observe(new UuidObserver);
	}
}