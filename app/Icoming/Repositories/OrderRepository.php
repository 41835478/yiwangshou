<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Order;
use Icoming\Models\User;
use Icoming\Repository;
use Illuminate\Http\Request;

class OrderRepository extends Repository {

    /**
     * OrderRepository constructor.
     *
     * @param Order $order
     */
    public function __construct(Order $order) {
        parent::__construct($order);
    }

    public function getLastOrder(User $user) {
        return $user->orders()->get()->last();
    }

    public function getOrderWithModel($order_id) {
        return $this->model->with('model.classification')->find($order_id);
    }

    public function getOrderStatus() {
        switch($this->model->status) {
            case '已支付':
                return '新订单待处理';
            case '待支付':
                return '新订单待支付';
            case '暂存':
                return '暂存成功';
            case '入库途中':
                return '运输中';
        }
        return $this->model->status;
    }

}
