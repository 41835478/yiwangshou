<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Admin;
use Icoming\Models\AdminLog;
use Icoming\Repository;

class AdminLogRepository extends Repository {
    /**
     * AdminLogRepository constructor.
     *
     * @param AdminLog $adminLog
     */
    public function __construct(AdminLog $adminLog) {
        parent::__construct($adminLog);
    }
}