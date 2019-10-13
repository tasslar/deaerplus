<?php
namespace App\Http\Middleware;

use Closure;

class Cors
{
	public function handle($request, Closure $next)
	{		
	    return $next($request)
	        ->header('Access-Control-Allow-Credentials', 'true')
            ->header('Access-Control-Allow-Methods', 'POST, GET, OPTIONS, PUT, DELETE')
            ->header('Access-Control-Allow-Headers', 'Content-Type, Accept, Authorization, X-Requested-With')
            ->header('Access-Control-Allow-Origin', '*');
	}
}
?>