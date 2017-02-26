<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午2:23
 */

namespace Icoming\Models;


use Icoming\Model;

/**
 * Icoming\Models\TypeCoupon
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $coupon_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Type $type
 * @property-read \Icoming\Models\Coupon $coupon
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\TypeCoupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\TypeCoupon whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\TypeCoupon whereCouponId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\TypeCoupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\TypeCoupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\TypeCoupon whereDeletedAt($value)
 * @mixin \Eloquent
 */
class TypeCoupon extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'type_id',
        'coupon_id',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type() {
        return $this->belongsTo(Type::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    public function couponWithTrashed() {
        return $this->coupon()->withTrashed();
    }
}