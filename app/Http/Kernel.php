<?php

namespace App\Http;

use App\Http\Middleware\AdminPermission;
use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Foundation\Http\Kernel as HttpKernel;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Http\Middleware\NonAdmin;
use App\Http\Middleware\Admin;
use App\Http\Middleware\RegisterOAuthUser;

use Overtrue\LaravelWechat\Middleware\OAuthAuthenticate;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * @var array
     */
    protected $middleware = [
        CheckForMaintenanceMode::class,
        EncryptCookies::class,
        AddQueuedCookiesToResponse::class,
        StartSession::class,
        ShareErrorsFromSession::class,
        VerifyCsrfToken::class,
    ];

    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'non-admin' => NonAdmin::class,
        'admin' => Admin::class,
        'admin-perms' => AdminPermission::class,
        'wechat.oauth' => OAuthAuthenticate::class,
        'register.oauth' => RegisterOAuthUser::class,
    ];
}
