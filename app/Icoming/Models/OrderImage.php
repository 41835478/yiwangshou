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
 * Icoming\Models\OrderImage
 *
 * @property integer $id
 * @property string $image
 * @property integer $order_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Order $order
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\OrderImage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\OrderImage whereImage($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\OrderImage whereOrderId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\OrderImage whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\OrderImage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\OrderImage whereDeletedAt($value)
 * @mixin \Eloquent
 */
class OrderImage extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'image',
        'order_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order() {
        return $this->belongsTo(Order::class);
    }
}