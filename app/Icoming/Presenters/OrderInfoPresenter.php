<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/6
 * Time: 上午10:19
 */

namespace Icoming\Presenters;


use Icoming\Models\Order;

class OrderInfoPresenter {

    public function getStatus(Order $order) {
        if($order->status == '已支付' && $order->type !== '以旧换新券') {
            return '待回收';
        }
        return $order->status;
    }
}
