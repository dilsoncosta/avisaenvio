<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helpers;
use Illuminate\Support\Facades\Auth;

class CheckAccess
{
	public function handle(Request $request, Closure $next)
	{
		$access = Helpers::getInfoAccess(auth()->user()->tenant_id)->situation;
		
		if($access != 'A')
		{
			switch ($access)
			{
				case 'S':
					$access_txt = 'Acesso Suspenso!';
					break;
				case 'I':
					$access_txt = 'Acesso Inativo!';
					break;
				case 'E':
					$access_txt = 'Acesso Expirado!';
					break;
				case 'C':
					$access_txt = 'Acesso Cancelado!';
					break;
				default:
					$access_txt = 'Acesso Ativo!';
					break;
			}
			return response()->json(array("status" => "0", "message" => $access_txt), 400);
		}
		
		return $next($request);
	}
}
