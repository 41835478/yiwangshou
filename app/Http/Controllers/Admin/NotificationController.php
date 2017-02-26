<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/6
 * Time: 上午11:22
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

class NotificationController extends Controller {

    protected $admin;

    public function __construct() {
        $this->admin = session('admin');
    }

    public function getInfo($id) {
        $notificaiton = $this->admin->toMeNotifications()->whereId($id)->first();
        if($notificaiton) {
            $notificaiton->type = '已读';
            $notificaiton->save();
        } else {
            $notificaiton = ['title' => '', 'content' => ''];
        }
        return $notificaiton;
    }

}