<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/9/22
 * Time: 下午12:04
 */

namespace Icoming\Services;


use EasyWeChat\Foundation\Application;
use Icoming\Service;

class WechatNoticeService extends Service {

    protected $application;

    public function __construct(Application $application) {
        $this->application = $application;
    }

    public function notice(array $opts) {
        try {
            return $this->application->notice->send($opts);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }
}
