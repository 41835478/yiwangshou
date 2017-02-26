<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Coupon;
use Icoming\Repository;

class CouponRepository extends Repository {
    /**
     * CouponRepository constructor.
     *
     * @param Coupon $coupon
     */
    public function __construct(Coupon $coupon) {
        parent::__construct($coupon);
    }

    /**
     * @param $id
     *
     * @return mixed
     */
    public function getValueById($id) {
        $model = $this->find($id);
        return $model->value;
    }
}