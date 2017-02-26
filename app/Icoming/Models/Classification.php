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
 * Icoming\Models\Classification
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $icon
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\Icoming\Models\Type[] $types
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\Icoming\Models\Classification whereDeletedAt($value)
 * @mixin \Eloquent
 */
class Classification extends Model {

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'type',
        'icon',
        'sort',
    ];

    protected $hidden = [
        'created_at',
        'deleted_at',
        'updated_at',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function types() {
        return $this->hasMany(Type::class);
    }
}