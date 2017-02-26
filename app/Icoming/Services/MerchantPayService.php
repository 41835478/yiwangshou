<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/9/22
 * Time: 上午11:46
 */

namespace Icoming\Services;


use EasyWeChat\Foundation\Application;
use Icoming\Service;

class MerchantPayService extends Service {
    protected $application;

    public function __construct(Application $application) {
        $this->application = $application;
    }

    /**
     * 企业支付
     * @param $rec_open_id
     * @param $money 单位分
     * @param $order_number
     * @param $user_name
     * @return null|string
     */
    public function pay($rec_open_id, $money, $order_number, $user_name = '') {
        $merchantPay = $this->application->merchant_pay;
        if($money < 100) {
            return '发放奖励不得少于1元';
        }
        try {
            $result = $merchantPay->send([
                'partner_trade_no' => $order_number,
                'openid' => $rec_open_id,
                'check_name' => 'NO_CHECK',
                're_user_name' => $user_name,
                'amount' => $money,
                'desc' => '企业付款',
                'spbill_create_ip' => '192.168.0.1',
            ]);

            if($result['result_code'] !== 'SUCCESS') {
                return $result['return_msg'];
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}