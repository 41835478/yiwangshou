<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Type;
use Icoming\Repository;

class TypeRepository extends Repository {

    /**
     * TypeRepository constructor.
     *
     * @param Type $type
     */
    public function __construct(Type $type) {
        parent::__construct($type);
    }

    public function getValueById($id) {
        $model = $this->find($id);
        return $model->value;
    }
}
