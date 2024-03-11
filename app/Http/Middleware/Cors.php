<?php
namespace App\Http\Middleware;

use Closure;

class Cors {
    protected $routes = [
        'api/*', // Isso já está incluído por padrão
        'integration_whatsapp/active',
    ];
    public function handle($request, Closure $next) {
        
        $response = $next($request);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'POST, GET');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With, Application', 'ip');
        return $response; 
    }
}