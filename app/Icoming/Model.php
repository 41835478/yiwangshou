<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午2:22
 */

namespace Icoming;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Icoming\Model
 *
 * @mixin \Eloquent
 */
abstract class Model extends \Illuminate\Database\Eloquent\Model {
    use SoftDeletes;
}