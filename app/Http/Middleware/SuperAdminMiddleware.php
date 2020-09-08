<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminMiddleware
{
 use ApiResponser;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->user_type === 'super-admin'){
            return $next($request);
        }
        return  $this->errorResponse('Unauthenticated', 401);
    }
}
