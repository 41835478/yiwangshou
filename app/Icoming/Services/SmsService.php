<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/27
 * Time: 下午1:45
 */

namespace Icoming\Services;


use GuzzleHttp\Client;
use Icoming\Repositories\MessageRepository;
use Icoming\Service;
use Illuminate\Cache\RateLimiter;
use Illuminate\Http\Request;

class SmsService extends Service {

    protected $repository;

    protected $config;

    protected $client;

    public function __construct(MessageRepository $repository, Client $client) {
        $this->repository = $repository;
        $this->client = $client;
    }

    public function config($config) {
        $this->config = config($config);
        return $this;
    }

    // app()->make(Icoming\Services\SmsService::class)->config('site.global.sms')->send('18649757679', '您的[XX]物品已回收成功,请出示订单号至小区物业处领取回收金额！【俺来收】')
    public function send(Request $request, $mobile, $content) {
        if($this->hasTooManySendAttempts($request)) {
            return [
                'code' => 1,
                'message' => $this->getLockoutTime($request),
            ];
        }
        $this->incrementSendAttempts($request);

        $res = $this->client->request('GET', 'http://www.stongnet.com/sdkhttp/sendsms.aspx',  [
            'query' => [
                'reg' => $this->config['username'],
                'pwd' => $this->config['password'],
                'sourceadd' => '',
                'phone' => $mobile,
                'content' => $content,
            ],
        ]);
        $content = $res->getBody()->getContents();
//        $params = http_parse_params($content);
        parse_str($content, $params);
        // result=0&message=短信发送成功&smsid=20160704173753504
        if($params['result'] == 0) {
            $this->repository->create([
                'mobile' => $mobile,
                'ip' => $request->ip(),
                'sms_id' => $params['smsid'],
            ]);
        }

        return [
            'code' => 0,
            'message' => $res->getBody()->getContents(),
        ];
    }


    // 节流函数
    protected function hasTooManySendAttempts(Request $request)
    {
        return app(RateLimiter::class)->tooManyAttempts(
            $this->getThrottleKey($request),
            $this->maxSendAttempts(),
            $this->lockoutTime() / 60
        );
    }
    // 增加一个尝试次数
    protected function incrementSendAttempts(Request $request)
    {
        app(RateLimiter::class)->hit(
            $this->getThrottleKey($request)
        );
    }
    // 取得剩余秒数
    protected function getLockoutTime(Request $request)
    {
        $seconds = app(RateLimiter::class)->availableIn(
            $this->getThrottleKey($request)
        );
        return $seconds;
    }
    // 清楚尝试次数
    protected function clearSendAttempts(Request $request)
    {
        app(RateLimiter::class)->clear(
            $this->getThrottleKey($request)
        );
    }
    protected function getThrottleKey(Request $request)
    {
        return $request->ip();
    }
    protected function maxSendAttempts()
    {
        return 1;
    }
    protected function lockoutTime()
    {
        return 120;
    }
}
