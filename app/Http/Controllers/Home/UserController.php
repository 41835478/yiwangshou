<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/2
 * Time: 下午9:55
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Payment\Order;
use Icoming\Services\SmsService;
use Illuminate\Http\Request;

class UserController extends Controller {
    protected $user;

    public function __construct() {
        $this->user = session('user');
    }

    public function getCenter() {
        return view('home.user.center');
    }

    public function getInfo() {
        if($this->user->role == '默认') {
            $this->user->role = '普通用户';
        }
        return $this->user;
    }

    public function getOrders() {
        return view('home.user.orders');
    }

    public function getAjaxOrders() {
        $per_page = 5;
        return $this->user->orders()->with('cfmModel.classificationWithTrashed')->with('typeCouponWithTrashed.couponWithTrashed')->orderBy('id', 'desc')->paginate($per_page);
    }

    public function getOrder($order_id, $new = 0) {
        $order = $this->user->orders()->find($order_id);
        // dd($order);
        if(!$order) {
            return redirect('/');
        }
        if($order->type === '以旧换新券' && $order->wechat_paid_at === null) {
            return redirect('/user/order-pay/' . $order_id);
        }
        //ddl_edit
        $plot = $order->plot;
        $salesmen = $plot->users()->whereRole("业务员")->first();
        return view('home.user.order')->with('order', $order)->with('new', $new)->with('salesmen', $salesmen);
    }

    public function getOrderPay($order_id, Application $application) {
        $order = $this->user->orders()->whereType('以旧换新券')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        $attr = [
            'trade_type'       => 'JSAPI',
            'body'             => "{$order->modelWithTrashed->classificationWithTrashed->name} {$order->modelWithTrashed->name}",
            'detail'           => "{$order->modelWithTrashed->classificationWithTrashed->name} {$order->modelWithTrashed->name}",
            'out_trade_no'     => $order->number,
            'total_fee'        => intval($order->money * 100), //单位分
            'notify_url'       => url('/user/order-pay'),// 这个接口要取消csrf
            'openid'           => $this->user->open_id, // 传递openid
        ];
        $wechat_order = new Order($attr);
        $payment = $application->payment;
        $result = $payment->prepare($wechat_order);
        if ($result->return_code != 'SUCCESS' || $result->result_code != 'SUCCESS') {
//            var_dump($result);
//            dd($result);
            return redirect('/user/orders');
        }
        $prepayId = $result->prepay_id;
        $js = $application->js;
        $jssdk_config = $payment->configForJSSDKPayment($prepayId);

        return view('home.user.order-pay')
            ->with('wechat_order', $wechat_order)
            ->with('jssdk_config', $jssdk_config)
            ->with('js', $js)
            ->with('order', $order);
    }

    public function getOrderPaied($order_id) {
        $order = $this->user->orders()->whereType('以旧换新券')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        return view('home.user.order-paied')
            ->with('order', $order);
    }

    public function postOrderPay(Application $application) {
        $response = $application->payment->handleNotify(function($notify, $successful){
            // 使用通知里的商户订单号获取订单
            $order = \Icoming\Models\Order::whereNumber($notify->out_trade_no)->first();
            if(!$order) {
                return 'Order not exist.'; // 告诉微信, 我已经处理完了,订单没找到,别再通知我了
            }
            if($order->wechat_paid_at) {
                return true; // 已经支付成功了不在更新
            }
            // 如果没有支付, 并且支付成功
            if($successful) {
                // 修改对应的以旧换新券0 -
                $order->wechat_paid_at = Carbon::now();
                $order->status = '已支付';
                $order->wechat_number = $notify->transaction_id;
                $order->save();
            }
            return true;
        });

        return $response;
    }

    public function getCoupons() {
        return view('home.user.coupons');
    }

    public function getAjaxCoupons() {
        $per_page = 5;
        $coupons = $this->user->orders()->whereNotNull('coupon_id')->with('couponWithTrashed')->paginate($per_page);
        return $coupons;
    }

    public function getBindMobile() {
        if($this->user->mobile) {
            return redirect('/');
        }
        return view('home.user.bind-mobile');
    }

    public function getSendToken(Request $request, $mobile, SmsService $service) {
        $token = mt_rand(1000, 9999);
        $expire = 10;
        session()->set('bind-mobile', [
            'mobile' => $mobile,
            'token' => $token,
            'expired' => Carbon::now()->addMinutes($expire)->timestamp,
        ]);
        return $service->config('site.global.sms')->send($request, $mobile, view('template.message.token', compact('token', 'expire'))->render());
    }

    public function getVerifyToken(Request $request, $mobile, $token) {
        $true_token = session('bind-mobile', [
            'expired' => Carbon::now()->subMinute()->timestamp,
            'token' => null,
        ]);
        if($true_token['expired'] < Carbon::now()->timestamp || $true_token['mobile'] != $mobile || $true_token['token'] != $token) {
            return [
                'code' => -1,
                'message' => '验证码错误',
            ];
        }
        session()->set('bind-mobile', [
            'mobile' => null,
            'token' => null,
            'expired' => null,
        ]);
        $this->user->update(compact('mobile'));
        return [
            'code' => 0,
            'message' => '绑定成功',
        ];
    }

    public function getOrderCancel($order_id) {
        $order = $this->user->orders()->where('status', '!=', '已取消')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        return view('home.user.order-cancel')->with('order', $order);
    }

    public function postOrderCancel(Request $request, $order_id) {
        $order = $this->user->orders()->where('type', '!=', '以旧换新券')->where(function($query) {
            $query->where('status', '=', '待支付')->orWhere('status', '=', '已支付');
        })->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        $order->status = '已取消';
        $order->cancel_reason = $request->input('cancel_reason', '');
        $order->save();
        return redirect('/user/order/' . $order->id);
    }

    public function postOrderCancel2(Request $request, $order_id) {
        $order = $this->user->orders()->whereType('以旧换新券')->whereStatus('待支付')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        $order->status = '已取消';
        $order->cancel_reason = $request->input('cancel_reason', '');
        $order->save();
        return redirect('/user/order/' . $order->id);
    }
}
