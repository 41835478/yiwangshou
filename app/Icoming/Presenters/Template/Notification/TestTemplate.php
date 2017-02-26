<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/29
 * Time: 下午2:28
 */

namespace Icoming\Presenters\Template\Notification;


use Icoming\Presenters\Template;

class TestTemplate extends Template {
    protected $namespace = 'notification';
    protected $view = 'test';
    protected $name = '测试视图';
    protected $column = [
        'test' => '内容',
    ];
}