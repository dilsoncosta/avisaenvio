<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\{
	User
};

class AuthServiceProvider extends ServiceProvider
{
	protected $policies = [
		// 'App\Models\Model' => 'App\Policies\ModelPolicy',
	];
	
	public function boot()
	{
		$this->registerPolicies();
	}
}
