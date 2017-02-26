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
 * Icoming\Models\Notification
 *
 * @property integer $id
 * @property integer $from_id
 * @property integer $to_id
 * @property string $type
 * @property string $title
 * @property string $view
 * @property string $data
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Icoming\Models\Admin $fromWhichAdmin
 * @property-read \Icoming\Models\Admin $toWhichAdmin
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereFromId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereToId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereView($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Notification whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Notification extends Model {
    /**
     * @var array
     */
    protected $fillable = [
        'from_id',
        'to_id',
        'type',
        'title',
        'view',
        'content',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromWhichAdmin() {
        return $this->belongsTo(Admin::class, 'from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toWhichAdmin() {
        return $this->belongsTo(Admin::class, 'to_id');
    }
}