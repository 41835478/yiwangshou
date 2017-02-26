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
 * Icoming\Models\Order
 *
 * @property integer $id
 * @property string $number
 * @property boolean $is_unload
 * @property integer $user_id
 * @property integer $type_id
 * @property string $type
 * @property integer $user_coupon_id
 * @property integer $coupon_id
 * @property float $money
 * @property string $wechat_number
 * @property \Carbon\Carbon $paid_at
 * @property integer $plot_id
 * @property string $address
 * @property string $name
 * @property string $mobile
 * @property string $status
 * @property string $refused_reason
 * @property boolean $is_paid
 * @property integer $code_id
 * @property boolean $cfm_is_unload
 * @property float $cfm_money
 * @property integer $property_id
 * @property integer $driver_id
 * @property integer $out_id
 * @property integer $in_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\OrderImage[] $orderImages
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereIsUnload($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereTypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereCouponId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereWechatNumber($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order wherePaidAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order wherePlotId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereRefusedReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereIsPaid($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereCodeId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereCfmIsUnload($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereCfmMoney($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order wherePropertyId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereDriverId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereOutId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereInId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Order whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Order extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'number',
        'is_unload',
        'user_id',
        'type_id',
        'type',
        'type_coupon_id',
        'coupon_id',
        'money',
        'wechat_number',
        'paid_at',
        'plot_id',
        'address',
        'name',
        'mobile',
        'status',
        'refused_reason',
        'cancel_reason',
        'is_paid',
        'code_id',
        'cfm_is_unload',
        'cfm_money',
        'cfm_type_id',
        'property_id',
        'driver_id',
        'out_id',
        'in_id',
        'property_at',
        'driver_at',
        'in_at',
        'out_at',
        'remarks',
        'is_read',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderImages() {
        return $this->hasMany(OrderImage::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plot() {
        return $this->belongsTo(Plot::class);
    }

    /**
     * @return mixed
     */
    public function plotWithTrashed() {
        return $this->plot()->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class);
    }

    /**
     * @return mixed
     */
    public function userWithTrashed() {
        return $this->user()->withTrashed();
    }

    /**
     * 业务员
     */
    public function property() {
        return $this->belongsTo(User::class, 'property_id')->withTrashed();
    }

    public function driver() {
        return $this->belongsTo(User::class, 'driver_id')->withTrashed();
    }

    public function in() {
        return $this->belongsTo(User::class, 'in_id')->withTrashed();
    }

    public function out() {
        return $this->belongsTo(User::class, 'out_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function model() {
        return $this->belongsTo(Type::class, 'type_id');
    }

    /**
     * 确认回收的商品
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cfmModel() {
        return $this->belongsTo(Type::class, 'cfm_type_id')->withTrashed();
    }

    /**
     * @return mixed
     */
    public function modelWithTrashed() {
        return $this->model()->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function typeCoupon() {
        return $this->belongsTo(TypeCoupon::class);
    }

    public function typeCouponWithTrashed() {
        return $this->typeCoupon()->withTrashed();
    }

    public function coupon() {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * @return mixed
     */
    public function couponWithTrashed() {
        return $this->coupon()->withTrashed();
    }

    public function code() {
        return $this->belongsTo(Code::class);
    }

    /**
     * 是否可回收状态
     *
     * @return bool
     */
    public function isRecyclable() {
        return $this->status == '已支付';
    }

    /**
     * 是否已派单
     *
     * @return bool
     */
    public function isDispatched() {
        return $this->status == '暂存' || $this->status == '入库途中' || $this->status == '已入库' || $this->status == '已出库';
    }

    /**
     * 是否已取消
     *
     * @return bool
     */
    public function isCanceled() {
        return $this->status == '已取消' || $this->status == '退款';
    }

    /**
     * 是否已完成
     *
     * @return bool
     */
    public function isFinished() {
        return $this->status == '已入库' || $this->status == '已出库';
    }

    /**
     * 是否阶段完结
     *
     * @return bool
     */
    public function isStepFinished() {
        return $this->status == '暂存' || $this->status == '入库途中';
    }

    /**
     * 是否已拒绝回收
     *
     * @return bool
     */
    public function isRefused() {
        return $this->status == '无法回收';
    }

    /**
     * 是否以优惠券返利
     *
     * @return bool
     */
    public function couponReward() {
        return $this->type == '有成本券' || $this->type == '以旧换新券';
    }

    /**
     * 是否是微信转账
     *
     * @return bool
     */
    public function cashReward() {
        return $this->type == '现金转账';
    }

    /**
     * 是否是协助下单
     *
     * @return bool
     */
    public function assistOrder() {
        return $this->type == '协助下单';
    }

}