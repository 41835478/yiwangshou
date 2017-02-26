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
 * Icoming\Models\Plot
 *
 * @property integer $id
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $name
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Admin[] $admins
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\User[] $users
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereProvince($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereArea($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Plot whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Plot extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'province',
        'city',
        'area',
        'name',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function admins() {
        return $this->hasMany(Admin::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->hasMany(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }

    /**
     * 小区下的所有业务员
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function properties() {
        return $this->belongsToMany(User::class, 'plot_properties', 'plot_id', 'property_id');
    }
}