<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
	protected $except = [
		'/webhook/integration_wp/{token}',
	];
	
	protected function redirectTo($request)
	{
		if (! $request->expectsJson()) {
			return route('login');
		}
	}

	protected function unauthenticated($request, array $guards)
	{
		abort(response()->json(["status" => "0", "message" => 'Sessão Expirada. Recarregue a página e faça o login novamente.'], 401));
	}
}
