<?php
/**
 * Created by PhpStorm.
 * User: zhuangjianjia
 * Date: 16/11/18
 * Time: 下午4:41
 */

namespace Icoming\Models;


use Illuminate\Database\Eloquent\Model;

class PlotProperty extends Model {

    public $timestamps = false;

    protected $fillable = [
        'plot_id',
        'property_id',
    ];
}