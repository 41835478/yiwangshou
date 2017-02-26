<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午4:12
 */

namespace App\Http\Controllers;

use Icoming\Models\AdminLog;
use Icoming\Services\Admin\AdminLogService;

abstract class AdminController extends Controller {
    /**
     * @var AdminLogService
     */
    protected $adminLogService;

    /**
     * AdminController constructor.
     *
     * @param AdminLogService $adminLogService
     */
    public function __construct(AdminLogService $adminLogService) {
        $this->middleware('admin-perms', [
            'except' => [
                'getLogin',
                'postLogin',
            ],
        ]);
        $this->adminLogService = $adminLogService;
    }

    /**
     * 保存日志
     *
     * @param $type
     * @param $message
     *
     * @return static
     */
    protected function log($type, $message) {
        return $this->adminLogService->log(app('request'), $type, $message);
    }

    /**
     * 保存插入日志
     *
     * @param $message
     *
     * @return static
     */
    protected function logInsert($message) {
        return $this->adminLogService->log(app('request'), AdminLog::INSERT, $message);
    }


    /**
     * 保存更新日志
     *
     * @param $message
     *
     * @return static
     */
    protected function logUpdate($message) {
        return $this->adminLogService->log(app('request'), AdminLog::UPDATE, $message);
    }

    /**
     * 保存查找日志
     *
     * @param $message
     *
     * @return static
     */
    protected function logSelect($message) {
        return $this->adminLogService->log(app('request'), AdminLog::SELECT, $message);
    }

    /**
     * 保存删除日志
     *
     * @param $message
     *
     * @return static
     */
    protected function logDelete($message) {
        return $this->adminLogService->log(app('request'), AdminLog::DELETE, $message);
    }

    /**
     * 保存其他日志
     *
     * @param $message
     *
     * @return static
     */
    protected function logOther($message) {
        return $this->adminLogService->log(app('request'), AdminLog::OTHER, $message);
    }

}
