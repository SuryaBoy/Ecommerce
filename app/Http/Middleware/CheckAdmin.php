<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckAdmin
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
        $roleId = Auth::guard('admin')->user()->role_id;
        if($roleId==1){
            
            return $next($request);
        }

        return redirect(route('admin.dashboard'));

    }
}
