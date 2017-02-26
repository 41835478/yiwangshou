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
 * Icoming\Models\Message
 *
 * @property integer $id
 * @property string $mobile
 * @property string $ip
 * @property string $sms_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereMobile($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereSmsId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Message whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Message extends Model {
    /**
     * @var array
     */
    protected $fillable = [
        'mobile',
        'ip',
        'sms_id',
    ];
}