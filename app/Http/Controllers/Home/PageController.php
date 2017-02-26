<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/3
 * Time: 下午12:58
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;

class PageController extends Controller {

    public function getOrders() {
        return view('home.user.order');
    }

    public function getOrder($order_id) {
        $user = session('user');
        $order = $user->orders()->find($order_id);
        dd($order);
    }

}