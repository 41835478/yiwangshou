<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/29
 * Time: 下午12:44
 */

namespace Icoming\Services\Admin;


use Icoming\Models\Admin;
use Icoming\Repositories\CodeRepository;
use Icoming\Service;

class CodeService extends Service {

    /**
     * @var CodeRepository
     */
    protected $repository;

    /**
     * CodeService constructor.
     *
     * @param CodeRepository $repository
     */
    public function __construct(CodeRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * 生成商品编号
     *
     * @return string
     */
    protected function createNumber() {
        return date('YmdHis') . mt_rand(1000, 9999);
    }

    /**
     *
     * @param Admin $admin
     *
     * @return static
     */
    public function createCode(Admin $admin) {
        return $this->repository->create([
            'code' => $this->createNumber(),
            'admin_id' => $admin->id,
        ]);
    }
}