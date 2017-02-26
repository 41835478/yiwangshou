<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Admin\WelcomeController;
use Closure;
use Route;

class AdminPermission
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
        list($controlerr, $method) = explode('@', Route::getCurrentRoute()->getActionName());
        $admin = session('admin');
        $perms = $this->getPermissions($admin->role);
        if(in_array($method, $perms[$controlerr])) {
            return $next($request);
        } else {
            if($request->ajax()) {
                return [
                    // 权限不够
                ];
            } else {
                return redirect('admin/index');
            }
        }
    }

    protected function getPermissions($role = null) {
        $perms = [];
        /**
         * 首先加载全局的权限
         */
        foreach(config('admin-perms.global', []) as $key => $value) {
            if(class_exists($key)) {
                if(!array_key_exists($key, $perms)) $perms[$key] = [];
                if(is_array($value)) {
                    $perms[$key] = $perms[$key] + $value;
                } else {
                    $perms[$key] = $perms[$key] + get_class_methods($key);
                }
            } else if (class_exists($value)) {
                if(!array_key_exists($value, $perms)) $perms[$value] = [];
                $perms[$value] = $perms[$value] + get_class_methods($value);
            } else {
                throw new \Exception("解析管理员权限配置的时候发生错误");
            }
        }
        /**
         * 然后合并角色权限
         */
        foreach(config('admin-perms.role.' . $role, []) as $key => $value) {
            if(class_exists($key)) {
                if(!array_key_exists($key, $perms)) $perms[$key] = [];
                $perms[$key] = $perms[$key] + $value;
            } else if (class_exists($value)) {
                if(!array_key_exists($value, $perms)) $perms[$value] = [];
                $perms[$value] = $perms[$value] + get_class_methods($value);
            } else {
                throw new \Exception("解析管理员权限配置的时候发生错误");
            }
        }
        return $perms;
    }
}
