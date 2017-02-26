<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/8
 * Time: 下午12:38
 */

namespace Icoming\Presenters\Home;


use Icoming\Models\Order;

class OrderInfoPresenter {

    public function getRecycleStatus(Order $order) {
        switch($order->status) {
            case '已支付':
                return '待回收';
            case '待支付':
            case '已取消':
            case '退款':
                return '无法操作('.$order->status.')';
            case '已入库':
            case '已出库':
                return '已回收';
            default:
                return $order->status;
        }
    }

    /**
     * 取返利
     *
     * @param Order $order
     *
     * @return string
     */
    public function getReward(Order $order) {
        switch($order->type) {
            case '有成本券':
            case '以旧换新券':
                return "优惠券 " . $order->typeCouponWithTrashed->couponWithTrashed->name;
            case '现金转账':
                return '现金红包￥' . $order->money;
            default:
                return $order->type;
        }
    }
}