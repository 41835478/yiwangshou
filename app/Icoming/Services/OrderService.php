<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/9/22
 * Time: 上午11:17
 */

namespace Icoming\Services;

use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use Icoming\Models\CouponNumber;
use Icoming\Models\Order;
use Icoming\Service;
use Illuminate\Support\Facades\DB;

class OrderService extends Service {
    /**
     * @var array
     */
    protected $allow_dispatch_status = ['暂存', '入库途中', '已入库', '已出库'];
    /**
     * @var Application
     */
    protected $merchantPayService;
    /**
     * @var SmsService
     */
    protected $smsService;

    /**
     * @var WechatNoticeService
     */
    protected $wechatNoticeService;

    /**
     * OrderService constructor.
     * @param MerchantPayService $merchantPayService
     * @param SmsService $smsService
     * @param WechatNoticeService $wechatNoticeService
     */
    public function __construct(MerchantPayService $merchantPayService, SmsService $smsService, WechatNoticeService $wechatNoticeService) {
        $this->merchantPayService = $merchantPayService;
        $this->smsService = $smsService;
        $this->wechatNoticeService = $wechatNoticeService;
    }

    protected function checkType(Order $order, $type) {
        return $order->type === $type;
    }

    protected function checkStatus(Order $order) {
        return in_array($order->status, $this->allow_dispatch_status);
    }

    /**
     * 派发以旧换新券优惠
     * @param Order $order
     * @param bool $force 是否强制发放(不考虑已发放情况)
     * @return null|string
     */
    public function dispatchOld2NewCoupon4Order(Order $order, $force = false) {
        // 不是以旧换新券则不发放优惠
        if(!$this->checkType($order, '以旧换新券')) {
            return '订单类型不是以旧换新';
        }
        // 如果已经发放过并且不强制发放则不发放
        if($order->is_paid && $force === false) {
            return '订单优惠已经发放';
        }
        // 检测状态
        if(!$this->checkStatus($order)) {
            return '订单状态不允许发放优惠';
        }
        return null;
    }

    /**
     * 发放现金优惠
     * @param Order $order
     * @param bool $force 是否强制发放(不考虑已发放情况)
     * @return null|string
     */
    public function dispatchCash4Order(Order $order, $force = false) {
        // 不是现金转账则不发放优惠
        if(!$this->checkType($order, '现金转账')) {
            return '订单类型不是现金转账';
        }
        // 如果已经发放过并且不强制发放则不发放
        if($order->is_paid && $force === false) {
            return '订单优惠已经发放';
        }
        // 检测状态
        if(!$this->checkStatus($order)) {
            return '订单状态不允许发放优惠';
        }
        try {
            // 企业支付
            if($errorMsg = $this->merchantPayService->pay($order->userWithTrashed->open_id, $order->cfm_money * 100, $order->number, $order->name)) {
                return $errorMsg;
            }
            $order->is_paid = true;
            $order->paid_at = Carbon::now();
            $order->save();
            // 发放通知
            $this->wechatNoticeService->notice([
                'touser' => $order->userWithTrashed->open_id,
                'template_id' => 'or7OmOIzB5ucsUPVCDyHjGv2DCk0ok_zMbqSrfcei7k',
                'topcolor' => '#f7f7f7',
                'data' => [
                    'first' => '您的物品回收成功',
                    'keyword1' => $order->number,
                    'keyword2' => $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name,
                    'keyword3' => '开始时间',
                    'keyword4' => '结束时间',
                    'remark' => '实际发放金额:' . $order->cfm_money,
                ],
            ]);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * 发放协助下单优惠
     * @param Order $order
     * @param bool $force 是否强制发放(不考虑已发放情况)
     * @return null|string
     */
    public function dispatchAssist4Order(Order $order, $force = false) {
        // 不是协助下单则不发放优惠
        if(!$this->checkType($order, '协助下单')) {
            return '订单类型不是协助下单';
        }
        // 如果已经发放过并且不强制发放则不发放
        if($order->is_paid && $force === false) {
            return '订单优惠已经发放';
        }
        // 检测状态
        if(!$this->checkStatus($order)) {
            return '订单状态不允许发放优惠';
        }
        try {
            // 企业支付
            if($errorMsg = $this->merchantPayService->pay($order->property->open_id, $order->cfm_money * 100, $order->number, $order->name)) {
                return $errorMsg;
            }
            $order->is_paid = true;
            $order->paid_at = Carbon::now();
            $order->save();
            // 发放通知
            $this->smsService->config('site.global.sms')->send(app('request'), $order->mobile, view('template.message.order-assist', [
                'item' => $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name,
                'order_number' => $order->number,
            ])->render());
            // 发送微信模板通知
            $this->wechatNoticeService->notice([
                'touser' => $order->property->open_id,
                'template_id' => 'or7OmOIzB5ucsUPVCDyHjGv2DCk0ok_zMbqSrfcei7k',
                'topcolor' => '#f7f7f7',
                'data' => [
                    'first' => '您的协助'.$order->name.'回收物品成功',
                    'keyword1' => $order->number,
                    'keyword2' => $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name,
                    'keyword3' => '开始时间',
                    'keyword4' => '结束时间',
                    'remark' => '实际发放金额:' . $order->cfm_money,
                ],
            ]);
        } catch(\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @param Order $order
     * @param CouponNumber $number
     * @param bool $force
     * @return string
     */
    public function dispatchCostCouponNumber4Order(Order $order, CouponNumber $number, $force = false) {
        // 不是有成本券则不发放优惠
        if(!$this->checkType($order, '有成本券')) {
            return '订单类型不是有成本券';
        }
        // 如果已经发放过并且不强制发放则不发放
        if($order->is_paid && $force === false) {
            return '订单优惠已经发放';
        }
        // 检测状态
        if(!$this->checkStatus($order)) {
            return '订单状态不允许发放优惠';
        }
        $order->is_paid = true;
        $order->paid_at = Carbon::now();
        $order->coupon_number = $number->value;
        try {
            DB::transaction(function() use(&$order, &$number) {
                $number->order_id = $order->id;
                $number->save();
                $order->save();
            });
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
        // 发送微信模板
        $this->wechatNoticeService->notice([
            'touser' => $order->userWithTrashed->open_id,
            'template_id' => 'fCwJcy_PUgHmi7gCunIYPjU9DJFRWsYD-cmQlgWC-BQ',
//                'url' => url('/user/order/' . $order->id),
            'topcolor' => '#f7f7f7',
            'data' => [
                'first' => '您的物品回收成功,优惠券'.$order->typeCouponWithTrashed->couponWithTrashed->name.'激活成功',
                'keyword1' => $number->value,
                'keyword2' => Carbon::now()->toDateTimeString(),
                'remark' => '到店消费出示此卡号即可享受优惠',
            ],
        ]);
        // 发送短信
        $this->smsService->config('site.global.sms')->send(app('request'), $order->mobile, view('template.message.order-coupon', [
            'item' => $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name,
            'coupon' => [
                'name' => $order->typeCouponWithTrashed->couponWithTrashed->name,
                'number' => $order->coupon_number,
            ],
        ])->render());
    }

    /**
     * 发放有成本券优惠
     * @param Order $order
     * @param bool $force 是否强制发放(不考虑已发放情况)
     * @return null|string
     */
    public function dispatchCostCoupon4Order(Order $order, $force = false) {
        // 取得所选优惠券
        $typeCoupon = $order->typeCouponWithTrashed;
        $coupon = $typeCoupon->couponWithTrashed;
        $number = $coupon->numbers()->whereNull('order_id')->first();
        if($number === null) {
            return '没有可用的优惠券码';
        }
        return $this->dispatchCostCouponNumber4Order($order, $number, $force);
    }

    /**
     * 统一派发
     * @param Order $order
     * @param bool $force
     * @return null|string
     */
    public function dispatch(Order $order, $force = false) {
        if($order->type === '有成本券') {
            $err = $this->dispatchCostCoupon4Order($order, $force);
        } elseif($order->type === '协助下单') {
            $err = $this->dispatchAssist4Order($order, $force);
        } elseif($order->type === '现金转账') {
            $err = $this->dispatchCash4Order($order, $force);
        } else {
            // 以旧换新券
            $err = $this->dispatchOld2NewCoupon4Order($order, $force);
        }
        return $err;
    }
}
