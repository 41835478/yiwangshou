<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/9/22
 * Time: 上午11:14
 */

namespace Icoming\Models;

use Icoming\Model;

class CouponNumber extends \Illuminate\Database\Eloquent\Model {
    /**
     * @var bool
     */
    public $timestamps = false;


    protected $fillable = [
        'value',
        'coupon_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}