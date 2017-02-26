<?php

return [
    /**
     * Debug 模式，bool 值：true/false
     *
     * 当值为 false 时，所有的日志都不会记录
     */
    'debug'  => false,

    /**
     * 使用 Laravel 的缓存系统
     */
    'use_laravel_cache' => true,

    /**
     * 账号基本信息，请从微信公众平台/开放平台获取
     */
    'app_id'  => config('site.global.wechat.app_id'),     // AppID
    'secret'  => config('site.global.wechat.secret'),     // AppSecret
    'token'   => config('site.global.wechat.token'),      // Token
    'aes_key' => config('site.global.wechat.aes_key'),    // EncodingAESKey

    /**
     * 日志配置
     *
     * level: 日志级别，可选为：
     *                 debug/info/notice/warning/error/critical/alert/emergency
     * file：日志文件位置(绝对路径!!!)，要求可写权限
     */
    'log' => [
        'level' => env('WECHAT_LOG_LEVEL', 'debug'),
        'file'  => env('WECHAT_LOG_FILE', storage_path('logs/wechat.log')),
    ],

    /**
     * OAuth 配置
     *
     * scopes：公众平台（snsapi_userinfo / snsapi_base），开放平台：snsapi_login
     * callback：OAuth授权完成后的回调页地址(如果使用中间件，则随便填写。。。)
     */
     'oauth' => [
         'scopes'   => ['snsapi_userinfo'],
         'callback' => '',
     ],

    /**
     * 微信支付
     */
     'payment' => [
         'merchant_id'        => config('site.global.wechat_payment.merchant_id'),
         'key'                => config('site.global.wechat_payment.key'),
         'cert_path'          => config('site.global.wechat_payment.cert_path'), // XXX: 绝对路径！！！！
         'key_path'           => config('site.global.wechat_payment.key_path'),      // XXX: 绝对路径！！！！
     ],
];
