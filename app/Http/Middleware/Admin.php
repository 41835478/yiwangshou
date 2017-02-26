<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use View;

class Admin
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
        $admin = Session::get('admin');
        if(!$admin) {
            if($request->ajax()) {
                return [];
            } else {
                return redirect('/admin/login');
            }
        } else {
            View::share('admin', $admin);
            return $next($request);
        }
    }
}
