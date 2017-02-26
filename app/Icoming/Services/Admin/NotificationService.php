<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/6
 * Time: 上午10:56
 */

namespace Icoming\Services\Admin;


use Icoming\Repositories\NotificationRepository;

class NotificationService {

    protected $repository;

    public function __construct(NotificationRepository $repository) {
        $this->repository = $repository;
    }

    public function send($data) {
        return $this->repository->create($data);
    }
}