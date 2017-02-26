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
 * Icoming\Models\Form
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $remark
 * @property string $status
 * @property string $refused_reason
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Admin $admin
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereRemark($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereRefusedReason($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Form whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Form extends Model {
    /**
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'remark',
        'status',
        'refused_reason',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}