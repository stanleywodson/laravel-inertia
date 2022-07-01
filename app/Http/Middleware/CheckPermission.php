<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        try {
            $user = Auth::user();
            $actionName = Route::currentRouteName();
            if( !$user  || !$user->can($actionName) ){
                return inertia('Err/ErrDuzentosEDois');
            }
            return $next($request);
        } catch (\Throwable $th) {
            return inertia('Err/ErrDuzentosEDois');
        }
        return $next($request);
    }
}