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
 * Icoming\Models\Type
 *
 * @property integer $id
 * @property string $name
 * @property integer $classification_id
 * @property float $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Classification $classification
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\TypeCoupon[] $typeCoupons
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Coupon[] $coupons
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereClassificationId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereValue($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Type whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Type extends Model {
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'value',
        'classification_id',
        'sort',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function classification() {
        return $this->belongsTo(Classification::class);
    }

    /**
     * @return mixed
     */
    public function classificationWithTrashed() {
        return $this->classification()->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function typeCoupons() {
        return $this->hasMany(TypeCoupon::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coupons() {
        return $this->belongsToMany(Coupon::class, 'type_values', 'type_id', 'coupon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }
}