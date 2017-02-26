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
 * Icoming\Models\Coupon
 *
 * @property integer $id
 * @property string $name
 * @property string $remark
 * @property float $value
 * @property float $ext_value
 * @property string $type
 * @property \Carbon\Carbon $expired_at
 * @property integer $timestamp
 * @property string $business
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\TypeCoupon[] $typeValues
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Type[] $types
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereExtValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereExpiredAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereTimestamp($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereBusiness($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Coupon whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Coupon extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'remark',
        'value',
        'ext_value',
        'type',
        'expired_at',
        'timestamp',
        'business',
    ];

    protected $hidden = [
        'created_at',
//        'deleted_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function typeValues() {
        return $this->hasMany(TypeCoupon::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(User::class, 'user_coupons', 'coupon_id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function types() {
        return $this->belongsToMany(Type::class, 'type_values', 'coupon_id', 'type_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function numbers()
    {
        return $this->hasMany(CouponNumber::class);
    }
}