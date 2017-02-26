<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\OrderImage;
use Icoming\Repository;

class OrderImageRepository extends Repository {
    /**
     * OrderImageRepository constructor.
     *
     * @param OrderImage $orderImage
     */
    public function __construct(OrderImage $orderImage) {
        parent::__construct($orderImage);
    }
}
