<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WeWantJsonMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('Accept') != 'application/json') {
            $request->headers->set('Accept', 'application/json');
        }

        return $next($request);
    }
}
