<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 下午12:53
 */

namespace Icoming\Services\Admin;


use Icoming\Models\AdminLog;
use Icoming\Repositories\AdminRepository;
use Icoming\Service;
use Illuminate\Http\Exception\HttpResponseException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdminLoginService extends Service {

    /**
     * @var AdminRepository
     */
    protected $repository;

    /**
     * @var AdminLogService
     */
    protected $adminLogService;

    public function __construct(AdminRepository $adminRepository, AdminLogService $adminLogService) {
        $this->repository = $adminRepository;
        $this->adminLogService = $adminLogService;
    }

    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');
        if($admin = $this->repository->auth($username, $password)) {
            session()->set('admin', $admin);
            $this->adminLogService->log($request, AdminLog::OTHER, '登录');
            return [
                'code' => 0,
                'message' => '登录成功',
                'data' => null,
                'url' => '/admin/index',
            ];
        }
        throw new HttpResponseException(new JsonResponse([
            'username' => [
                '账号或者密码错误',
            ],
            'password' => [ ],
        ], 422));
    }
}
