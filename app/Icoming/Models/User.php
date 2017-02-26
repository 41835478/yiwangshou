<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午2:23
 */

namespace Icoming\Models;


use Icoming\Model;
use Illuminate\Database\Query\Builder;

/**
 * Icoming\Models\User
 *
 * @property integer $id
 * @property string $open_id
 * @property string $nickname
 * @property string $sex
 * @property string $portrait
 * @property string $mobile
 * @property string $role
 * @property integer $plot_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Plot $plot
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Coupon[] $coupons
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereOpenId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereNickname($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereSex($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User wherePortrait($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User wherePlotId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\User whereDeletedAt($value)
 * @mixin \Eloquent
 */
class User extends Model {
    /**
     * @var array
     */
    protected $fillable = [
        'open_id',
        'nickname',
        'sex',
        'portrait',
        'mobile',
        'role',
        'plot_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plot() {
        return $this->belongsTo(Plot::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function coupons() {
        return $this->belongsToMany(TypeCoupon::class, 'user_coupons', 'user_id', 'type_coupon_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }

    /**
     * 服务的小区
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function plots() {
        return $this->belongsToMany(Plot::class, 'plot_properties', 'property_id', 'plot_id');
    }

}