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
 * Icoming\Models\AdminLog
 *
 * @property integer $id
 * @property integer $admin_id
 * @property string $ip
 * @property string $type
 * @property string $message
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Admin $admin
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereAdminId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\AdminLog whereDeletedAt($value)
 * @mixin \Eloquent
 */
class AdminLog extends Model {

    /**
     * @const 日志类型INSERT
     */
    const INSERT = 'INSERT';
    /**
     * @const 日志类型DELETE
     */
    const DELETE = 'DELETE';
    /**
     * @const 日志类型UPDATE
     */
    const UPDATE = 'UPDATE';
    /**
     * @const 日志类型SELECT
     */
    const SELECT = 'SELECT';
    /**
     * @const 日志类型OTHER
     */
    const OTHER = 'OTHER';

    /**
     * @var array
     */
    protected $fillable = [
        'admin_id',
        'ip',
        'type',
        'message',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin() {
        return $this->belongsTo(Admin::class);
    }
}