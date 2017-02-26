<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\TypeCoupon;
use Icoming\Repository;

class TypeCouponRepository extends Repository {
    /**
     * TypeValueRepository constructor.
     *
     * @param TypeCoupon $typeCoupon
     */
    public function __construct(TypeCoupon $typeCoupon) {
        parent::__construct($typeCoupon);
    }
}