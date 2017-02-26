<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\User;
use Icoming\Repository;

class UserRepository extends Repository {
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        parent::__construct($user);
    }
}