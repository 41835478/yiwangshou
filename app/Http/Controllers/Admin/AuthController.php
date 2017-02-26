<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午10:59
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use Icoming\Services\Admin\AdminLoginService;
use Illuminate\Http\Request;
use Validator;

class AuthController extends AdminController {

    public function getLogout() {
        $this->logOther("注销");
        \Session::forget('admin');
        return redirect('/admin/login');
    }

    public function getLogin() {
        if(\Session::get('admin')) {
            return redirect('/admin');
        }
        return view('admin.login');
    }

    public function postLogin(Request $request, AdminLoginService $adminLoginService) {
        $this->validate(
            $request,
            [
                'username' => 'required',
                'password' => 'required',
                'captcha' => 'required|captcha', ],
            [
                'captcha.captcha' => '验证码错了',
            ],
            [
                'username' => '账号',
                'password' => '密码',
                'captcha' => '验证码',
            ]);
        return $adminLoginService->login($request);
    }
}
