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
 * Icoming\Models\Admin
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $role
 * @property integer $plot_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\AdminLog[] $logs
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Code[] $codes
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Form[] $forms
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Notification[] $toMeNotifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Notification[] $fromMeNotifications
 * @property-read \Icoming\Models\Plot $plot
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin whereUsername($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin whereRole($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin wherePlotId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Admin whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Admin extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'role',
        'plot_id',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'password',
        'deleted_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs() {
        return $this->hasMany(AdminLog::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function codes() {
        return $this->hasMany(Code::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forms() {
        return $this->hasMany(Form::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function toMeNotifications() {
        return $this->hasMany(Notification::class, 'to_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fromMeNotifications() {
        return $this->hasMany(Notification::class, 'from_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plot() {
        return $this->belongsTo(Plot::class);
    }
}