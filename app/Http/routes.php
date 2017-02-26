<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
// 后台路由
Route::group([
    'prefix' => 'admin',
    'namespace' => 'Admin',
], function() {
    Route::group([
        'middleware' => [
            'non-admin',
        ],
    ], function() {
        Route::get('login', 'AuthController@getLogin');
        Route::post('login', 'AuthController@postLogin');
    });
    Route::group([
        'middleware' => [
            'admin',
        ],
    ], function() {
        // 解析权限路由开始
        $routeParser = app()->make(Icoming\RouteParser::class);
        // 加载通用权限
        $routeParser->load($routeParser->parse(config('admin-perms.global')));
        // 加载各个角色权限
        foreach(config('admin-perms.role') as $perm) {
            $routeParser->load($routeParser->parse($perm));
        }
        // 解析权限路由结束
        Route::get('logout', 'AuthController@getLogout');
        Route::controller('/', 'WelcomeController');
    });

});

// 微信支付回调
Route::post('user/order-pay', 'Home\UserController@postOrderPay');

// 七牛图片上传回调
Route::any('qiniu/order-images', 'Home\Work\PropertyController@anyOrderImages');

// 微信端路由
Route::group([
    'namespace' => 'Home',
    'middleware' => ['wechat.oauth', 'register.oauth'],
], function() {
    Route::controller('user', 'UserController');
    Route::controller('order', 'OrderController');
    Route::controller('coupon', 'CouponController');
    Route::controller('work/property', 'Work\PropertyController');
    Route::controller('work/driver', 'Work\DriverController');
    Route::controller('work/in', 'Work\InController');
    Route::controller('work/out', 'Work\OutController');
    Route::get('/', 'UserController@getCenter');
});
