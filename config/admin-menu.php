<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/25
 * Time: 下午9:00
 */

return [
    'global' => [
        [
            'label' => '注销',
            'icon' => 'ion-log-out',
            'action' => '/admin/logout',
        ],
    ],
    'role' => [
        '超级管理员' => [
            [
                'label' => '小区管理',
                'icon' => 'ion-ios-home',
                'action' => [
                    [
                        'label' => '小区列表',
                        'icon' => 'ion-ios-home',
                        'action' => '/admin/plot/index',
                    ],
                    [
                        'label' => '添加小区',
                        'icon' => 'ion-plus-round',
                        'action' => '/admin/plot/add',
                    ],
                    [
                        'label' => '回收站',
                        'icon' => 'ion-trash-a',
                        'action' => '/admin/plot/trash',
                    ],
                ],
            ],
            [
                'label' => '用户管理',
                'icon' => 'ion-person-stalker',
                'action' => [
                    [
                        'label' => '用户列表',
                        'icon' => 'ion-person-stalker',
                        'action' => '/admin/user/index',
                    ],
                    [
                        'label' => '冻结用户',
                        'icon' => 'ion-stop',
                        'action' => '/admin/user/trash',
                    ],
                ],
            ],
            [
                'label' => '分类管理',
                'icon' => 'ion-document-text',
                'action' => [
                    [
                        'label' => '类别管理',
                        'icon' => 'ion-document-text',
                        'action' => '/admin/classification/index',
                    ],
                    [
                        'label' => '图标管理',
                        'icon' => 'ion-images',
                        'action' => '/admin/classification/icon/index',
                    ],
                ],
            ],
            [
                'label' => '优惠券管理',
                'icon' => 'ion-card',
                'action' => [
                    [
                        'label' => '优惠券管理',
                        'icon' => 'ion-card',
                        'action' => '/admin/coupon/cost',
                    ],
                    [
                        'label' => '无成本券管理',
                        'icon' => 'ion-card',
                        'action' => '/admin/coupon/no-cost',
                    ],
                    [
                        'label' => '添加优惠券',
                        'icon' => 'ion-card',
                        'action' => '/admin/coupon/add',
                    ],
                    [
                        'label' => '回收站',
                        'icon' => 'ion-trash-a',
                        'action' => '/admin/coupon/trash',
                    ],
                ],
            ],
            [
                'label' => '订单管理',
                'icon' => 'ion-ios-list',
                'action' => [
                    [
                        'label' => '所有订单',
                        'icon' => 'ion-ios-list',
                        'action' => '/admin/order/index',
                    ],
                    [
                        'label' => '协助下单',
                        'icon' => 'ion-android-list',
                        'action' => '/admin/order/assist/index',
                    ],
                    [
                        'label' => '回收站',
                        'icon' => 'ion-trash-a',
                        'action' => '/admin/order/trash',
                    ],
                ],
            ],
            [
                'label' => '派车管理',
                'icon' => 'ion-android-car',
                'action' => [
                    [
                        'label' => '派车申请单',
                        'icon' => 'ion-android-car',
                        'action' => '/admin/form/index',
                    ],
                    [
                        'label' => '回收站',
                        'icon' => 'ion-trash-a',
                        'action' => '/admin/form/trash',
                    ],
                ],
            ],
            [
                'label' => '系统管理',
                'icon' => 'ion-gear-b',
                'action' => [
                    [
                        'label' => '站点配置',
                        'icon' => 'ion-gear-b',
                        'action' => '/admin/config/global',
                    ],
                    [
                        'label' => '角色分配',
                        'icon' => 'ion-ios-person',
                        'action' => '/admin/admin/role',
                    ],
                    [
                        'label' => '修改密码',
                        'icon' => 'ion-locked',
                        'action' => '/admin/admin/password',
                    ],
                ],
            ],
        ],
        '小区管理员' => [
//            [
//                'label' => '我的小区',
//                'icon' => 'ion-ios-home',
//                'action' => '/admin/plot/my-plot',
//            ],
            [
                'label' => '业务员管理',
                'icon' => 'ion-person-stalker',
                'action' => [
                    [
                        'label' => '我的业务员',
                        'icon' => 'ion-ios-person',
                        'action' => '/admin/user/plot',
                    ],
                    [
                        'label' => '已冻结的业务员',
                        'icon' => 'ion-ios-person-outline',
                        'action' => '/admin/user/plot-freeze',
                    ],
                ],
            ],
            [
                'label' => '订单管理',
                'icon' => 'ion-ios-list',
                'action' => [
                    [
                        'label' => '所有订单',
                        'icon' => 'ion-android-list',
                        'action' => '/admin/order/plot',
                    ],
                    [
                        'label' => '线下订单',
                        'icon' => 'ion-ios-list-outline',
                        'action' => '/admin/order/assist',
                    ],
                    [
                        'label' => '协助下单',
                        'icon' => 'ion-ios-person',
                        'action' => '/admin/order/assist/index',
                    ],
                ],
            ],
            [
                'label' => '派车管理',
                'icon' => 'ion-model-s',
                'action' => [
                    [
                        'label' => '派车记录',
                        'icon' => 'ion-model-s',
                        'action' => '/admin/form/plot',
                    ],
                    [
                        'label' => '申请派车',
                        'icon' => 'ion-edit',
                        'action' => '/admin/form/apply',
                    ],
                ],
            ],
            [
                'label' => '系统管理',
                'icon' => 'ion-gear-b',
                'action' => [
                    [
                        'label' => '商品编号',
                        'icon' => 'ion-qr-scanner',
                        'action' => '/admin/code/index',
                    ],
                    [
                        'label' => '申请编号',
                        'icon' => 'ion-edit',
                        'action' => '/admin/code/apply',
                    ],
                    [
                        'label' => '修改密码',
                        'icon' => 'ion-locked',
                        'action' => '/admin/admin/password',
                    ],
                ],
            ],
        ],
    ],
];