<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Admin;
use Icoming\Repository;

class AdminRepository extends Repository {
    /**
     * AdminRepository constructor.
     *
     * @param Admin $admin
     */
    public function __construct(Admin $admin) {
        parent::__construct($admin);
    }

    /**
     * 验证管理员账号密码是否存在
     *
     * @param $username
     * @param $password
     *
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function auth($username, $password) {
        $admin = $this->model->where('username', '=', $username)->first();
        if($admin && password_verify($password, $admin->password)) {
            return $admin;
        }
    }
}