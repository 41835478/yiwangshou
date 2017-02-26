<?php

namespace App\Http\Middleware;

use Closure;
use View;
use Icoming\Models\User;

class RegisterOAuthUser
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
        // 当没有登录的时候做检测
        $user_id = session('user_id');
        if(!$user_id) {
            $oauth_user =  session('wechat.oauth_user');
            $user = User::withTrashed()->whereOpenId($oauth_user->id)->first();
            if(!$user) {
                $original = $oauth_user->getOriginal();
                $user = User::create([
                    'open_id' => $original['openid'],
                    'nickname' => $original['nickname'],
                    'sex' => $original['sex'] == 1 ? '男' : ($original['sex'] == 2 ? '女' : '未知'),
                    'portrait' => $original['headimgurl'],
                    'role' => '默认',
                ]);
            }
        } else {
            $user = User::withTrashed()->find($user_id);
        }
        session()->set('user_id', $user->id);
        session()->set('user', $user);
        View::share('user', $user);
        return $next($request);
    }
}
