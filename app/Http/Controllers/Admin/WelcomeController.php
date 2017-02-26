<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午11:12
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController;

class WelcomeController extends AdminController {

    public function getIndex() {
        return view('admin.welcome');
    }
}