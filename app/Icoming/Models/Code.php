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
 * Icoming\Models\Code
 *
 * @property integer $id
 * @property string $code
 * @property integer $admin_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Admin $admin
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Code whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Code whereCode($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Code whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Code whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Code whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Code whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Code extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'code',
        'admin_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin() {
        return $this->belongsTo(Admin::class);
    }

    public function order() {
        return $this->hasOne(Order::class, 'code_id');
    }
}