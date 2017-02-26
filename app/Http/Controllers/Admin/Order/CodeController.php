<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/2
 * Time: 上午11:51
 */

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\AdminBaseController;
use Icoming\Repositories\CodeRepository;

class CodeController extends AdminBaseController {
    
    public function setRepository(CodeRepository $repository) {
        $this->repository = $repository;
    }
}