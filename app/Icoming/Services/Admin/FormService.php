<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/29
 * Time: 下午12:54
 */

namespace Icoming\Services\Admin;


use Icoming\Models\Admin;
use Icoming\Repositories\FormRepository;
use Icoming\Service;

class FormService extends Service {

    /**
     * @var FormRepository
     */
    protected $repository;

    /**
     * FormService constructor.
     *
     * @param FormRepository $repository
     */
    public function __construct(FormRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * @param Admin $admin
     * @param       $remark
     *
     * @return static
     */
    public function createForm(Admin $admin, $remark) {
        return $this->repository->create([
            'admin_id' => $admin->id,
            'remark' => $remark,
        ]);
    }
}