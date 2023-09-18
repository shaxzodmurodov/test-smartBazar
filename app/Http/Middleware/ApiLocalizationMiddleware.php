<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiLocalizationMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->hasHeader('Accept-Language')) {
            app()->setLocale($request->header('Accept-Language'));
        }
        return $next($request);
    }
}
