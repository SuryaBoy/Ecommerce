<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Admin;
use Session;

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

        $admin = Admin::all()->count();
        if (!($admin == 1)) {
            if (!Auth::guard('admin')->user()->hasPermissionTo('Administer roles & permissions')) //If user does //not have this permission
            {
                Session::flash('status',"You Do Not Have Right Permission For Such A Task !!");
                return redirect(route('admin.dashboard'));
                // abort('401');
            }
        }

        return $next($request);

    }
}
