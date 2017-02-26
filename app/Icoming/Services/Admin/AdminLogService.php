<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:54
 */

namespace Icoming\Services\Admin;


use Icoming\Models\Admin;
use Icoming\Repositories\AdminLogRepository;
use Icoming\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminLogService extends Service {

    /**
     * @var AdminLogRepository
     */
    protected $repository;

    /**
     * @var Admin
     */
    protected $admin;

    /**
     * AdminLogService constructor.
     *
     * @param AdminLogRepository $adminLogRepository
     */
    public function __construct(AdminLogRepository $adminLogRepository) {
        $this->repository = $adminLogRepository;
        $this->admin = session('admin');
    }

    /**
     * @param       $type
     * @param       $message
     *
     * @return static
     * @throws \Exception $exception
     */
    public function log(Request $request, $type, $message) {
        if(!$this->admin && !($this->admin = session('admin'))) {
            throw new \Exception("请登录!");
        }
        return $this->repository->create([
            'admin_id' => $this->admin->id,
            'ip' => $request->ip(),
            'type' => $type,
            'message' => $message,
        ]);
    }

    /**
     * @return AdminLogRepository
     */
    public function getRepository() {
        return $this->repository;
    }

    /**
     * @param AdminLogRepository $repository
     */
    public function setRepository($repository) {
        $this->repository = $repository;
    }

    /**
     * @return Request
     */
    public function getRequest() {
        return $this->request;
    }

    /**
     * @param Request $request
     */
    public function setRequest($request) {
        $this->request = $request;
    }

    /**
     * @return Admin
     */
    public function getAdmin() {
        return $this->admin;
    }

    /**
     * @param Admin $admin
     */
    public function setAdmin($admin) {
        $this->admin = $admin;
    }


}