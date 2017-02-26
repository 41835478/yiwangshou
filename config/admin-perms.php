<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午10:56
 */

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\Classification\IconController;
use App\Http\Controllers\Admin\ClassificationController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\FormController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Order\AssistController;
use App\Http\Controllers\Admin\CodeController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PlotController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\TypeCouponController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WelcomeController;
use App\Http\Controllers\Admin\CouponController;

return [
    'global' => [
        AuthController::class => [
            'logout' => 'getLogout',
        ],
        WelcomeController::class,
        NotificationController::class,
    ],
    'role' => [
        '超级管理员' => [
            PlotController::class,
            UserController::class,
            CouponController::class,
            FormController::class,
            IconController::class,
            ClassificationController::class,
            TypeController::class,
            AdminController::class,
            ConfigController::class,
            AssistController::class,
            OrderController::class,
            TypeCouponController::class,
        ],
        '小区管理员' => [
            PlotController::class => [
                'my-plot' => 'getMyPlot',
            ],
            UserController::class => [
                'getPlot',
                'plot-list' => 'getPlotList',
                'plot-freeze' => 'getPlotFreeze',
                'plot-freeze-list' => 'getPlotFreezeList',
                'plot-delete' => 'getPlotDelete',
                'plot-restore' => 'getPlotRestore',
            ],
            AssistController::class => [
                'getIndex',
                'postIndex',
                'getClassificationCxselect',
                'getPlotCxselect',
            ],
            AdminController::class => [
                'getPassword',
                'postPassword',
            ],
            OrderController::class => [
                'getUnReadList',
                'getPlot',
                'getPlotList',
                'getPlotInfo',
                'getAssist',
                'getAssistList',
                'getPayAssist',
            ],
            FormController::class => [
                'getApply',
                'postApply',
                'getPlot',
                'getPlotList',
                'getInfo',
                'getDelete',
            ],
            CodeController::class,
        ],
    ],
];