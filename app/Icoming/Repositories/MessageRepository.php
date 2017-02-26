<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/24
 * Time: 上午3:15
 */

namespace Icoming\Repositories;


use Icoming\Models\Message;
use Icoming\Repository;

class MessageRepository extends Repository {
    /**
     * MessageRepository constructor.
     *
     * @param Message $message
     */
    public function __construct(Message $message) {
        parent::__construct($message);
    }
}