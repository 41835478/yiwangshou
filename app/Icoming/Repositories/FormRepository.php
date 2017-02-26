<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Form;
use Icoming\Repository;

class FormRepository extends Repository {
    /**
     * FormRepository constructor.
     *
     * @param Form $form
     */
    public function __construct(Form $form) {
        parent::__construct($form);
    }
}