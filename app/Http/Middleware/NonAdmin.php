<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class NonAdmin
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
        if($admin === null) {
            return $next($request);
        } else if ($request->ajax()) {
            return [];
        } else {
            return redirect('/admin/index');
        }
    }
}
