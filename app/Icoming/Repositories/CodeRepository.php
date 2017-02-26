<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Code;
use Icoming\Repository;

class CodeRepository extends Repository {
    /**
     * CodeRepository constructor.
     *
     * @param Code $code
     */
    public function __construct(Code $code) {
        parent::__construct($code);
    }
}