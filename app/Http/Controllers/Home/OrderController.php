<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/3
 * Time: 下午8:41
 */

namespace App\Http\Controllers\Home;


use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Icoming\Models\Coupon;
use Icoming\Models\Type;
use Icoming\Models\TypeCoupon;
use Icoming\Repositories\ClassificationRepository;
use Icoming\Repositories\CouponRepository;
use Icoming\Repositories\OrderRepository;
use Icoming\Repositories\PlotRepository;
use Icoming\Repositories\TypeCouponRepository;
use Icoming\Repositories\TypeRepository;
use Icoming\Services\Admin\OrderService;
use Icoming\Services\SmsService;
use Illuminate\Http\Request;

class OrderController extends Controller {

    protected $user;

    public function __construct() {
        $this->user = session('user');
    }

    public function getStep1(ClassificationRepository $repository, CouponRepository $couponRepository) {
        return view('home.order.step1')
            ->with('classifications', $repository->getJson())
            ->with('non_cost_coupons', $couponRepository->getModel()->whereType('无成本券')->get());
    }

    public function getStep2($type_id, $is_unload, $coupon_id) {
        $type = Type::with('classification')->find($type_id);
        $coupons = $type->typeCoupons()->with('coupon')->get();
        return view('home.order.step2')
            ->with('type', $type)
            ->with('coupons', $coupons)
            ->with('is_unload', $is_unload)
            ->with('coupon_id', $coupon_id);
    }

    public function getStep2x($type_id, $is_unload, $coupon_id,
                              OrderRepository $orderRepository,
                              CouponRepository $couponRepository,
                              Application $application) {
        $type = Type::with('classification')->find($type_id);
        $non_cost_coupon = null;
        if($coupon_id > 0) {
            $non_cost_coupon = $couponRepository->find($coupon_id);
        }
        $last_order = $orderRepository->getLastOrder($this->user);
        return view('home.order.step2x')
            ->with('type', $type)
            ->with('non_cost_coupon', $non_cost_coupon)
            ->with('last_order', $last_order)
            ->with('js', $application->js)
            ->with('is_unload', $is_unload);
    }

    public function getStep3($is_unload, $non_cost_coupon_id, $type_coupon_id,
                             OrderRepository $orderRepository,
                             TypeRepository $typeRepository,
                             TypeCouponRepository $typeCouponRepository,
                             CouponRepository $couponRepository,
                             Application $application) {
        $coupon = null;
        if($type_coupon_id > 0) {
            $typeCoupon = $typeCouponRepository->find($type_coupon_id);
            $type = $typeCoupon->type()->with('classification')->first();
            $coupon = $typeCoupon->coupon;
        } else {
            $type = $typeRepository->getModel()->with('classification')->find(-$type_coupon_id);
        }
        $non_cost_coupon = null;
        if($non_cost_coupon_id > 0) {
            $non_cost_coupon = $couponRepository->find($non_cost_coupon_id);
        }
        $last_order = $orderRepository->getLastOrder($this->user);
        return view('home.order.step3')
            ->with('type', $type)
            ->with('coupon', $coupon)
            ->with('non_cost_coupon', $non_cost_coupon)
            ->with('last_order', $last_order)
            ->with('js', $application->js)
            ->with('is_unload', $is_unload);
    }

    public function postStep2x(Request $request, $type_id, $is_unload, $non_cost_coupon_id, OrderService $orderService, Application $application, SmsService $smsService) {
        // 表单验证
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'plot_id' => 'required|exists:plots,id',
        ]);
        if($is_unload) {
            $request->merge(compact('is_unload'));
        }
        if($non_cost_coupon_id > 0) {
            $request->merge(['coupon_id' => $non_cost_coupon_id]);
        }
        $request->merge(['type_id' => $type_id]);
        $request->merge(['cfm_type_id' => $type_id]);
        $request->merge(['user_id' => $this->user->id, ]);

        // 创建订单
        $order = $orderService->createAssistOrder($request);
        if($order) {
            return $this->notice($request, $order, $application, $smsService);
//            // 更新用户的小区
//            $this->user->plot_id = $order->plot_id;
//            $this->user->save();
//            $notice = $application->notice;
//            $messageId = $notice->send([
//                'touser' => $this->user->open_id,
//                'template_id' => 'qbX3UTad_ICw6H2pZnvzn2aiO1C3S3dQijAdXxNmtDE',
//                'url' => url('/user/order/' . $order->id),
//                'topcolor' => '#f7f7f7',
//                'data' => [
//                    'first' => '您已成功预约  >>查看订单详情',
//                    'keyword1' => $order->number,
//                    'keyword2' => $order->money,
//                    'keyword3' => $order->name,
//                    'keyword4' => $order->mobile,
//                    'keyword5' => $order->plot->province.$order->plot->city.$order->plot->area.$order->plot->name.$order->address,
//                    'remark' => '请核对信息',
//                ],
//            ]);
//            // 通知当前订单小区的所有业务员
//            $plot = $order->plot;
//            $properties = $plot->properties->each(function($property) use ($notice, $smsService, $request, $order, $plot) {
//                // 发送短信
//                if($property->mobile) {
//                    // $smsService->config('site.global.sms')->send($request, $property->mobile, view('template.message.property', compact('token', 'expire'))->render());
//                }
//
//                // 发送微信通知
//                $notice->send([
//                    'touser' => $property->open_id,
//                    'template_id' => 'fFiNsV2EAyp8_mL6H9ZULllfcumWn8bAzG2E2WTUqvg',
//                    'url' => url('/work/property/recycle-step1/' . $order->id),
//                    'topcolor' => '#f7f7f7',
//                    'data' => [
//                        'first' => '您好, 你当前服务小区[' . $plot->name . '] 有新订单:',
//                        'keyword1' => $order->name,
//                        'keyword2' => $order->mobile,
//                        'keyword3' => $order->type,
//                        'keyword4' => '上门回收',
//                        'remark' => '请尽快前往回收, 谢谢! ',
//                    ],
//                ]);
//            });
//            return [
//                'code' => 0,
//                'data' => [
//                    'id' => $order->id,
//                    'number' => $order->number,
//                    'type' => $order->type,
//                ],
//            ];
        } else {
            return [
                'code' => -1,
                'message' => '服务器繁忙, 创建订单时出错',
            ];
        }
    }

    /**
     * 生成订单
     *
     * @param Request      $request
     * @param              $is_unload
     * @param              $non_cost_coupon_id
     * @param              $type_coupon_id
     * @param OrderService $orderService
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|mixed
     */
    public function postStep3(Request $request, $is_unload, $non_cost_coupon_id, $type_coupon_id, OrderService $orderService, Application $application, SmsService $smsService) {
        // 表单验证
        $this->validate($request, [
            'name' => 'required',
            'mobile' => 'required',
            'address' => 'required',
            'plot_id' => 'required|exists:plots,id',
        ]);
        if($is_unload) {
            $request->merge(compact('is_unload'));
        }
        if($non_cost_coupon_id > 0) {
            $request->merge(['coupon_id' => $non_cost_coupon_id]);
        }
        if($type_coupon_id > 0) {
            $request->merge(compact('type_coupon_id'));
        } else {
            $request->merge(['type_id' => -$type_coupon_id]);
        }

        // 创建订单
        $order = $orderService->createUserOrder($this->user, $request);
        if($order) {
            return $this->notice($request, $order, $application, $smsService);
        } else {
            return [
                'code' => -1,
                'message' => '服务器繁忙, 创建订单时出错',
            ];
        }
    }

    public function notice($request, $order, $application, $smsService) {
        // 更新用户的小区
        $this->user->plot_id = $order->plot_id;
        $this->user->save();
        $notice = $application->notice;
        $messageId = $notice->send([
            'touser' => $this->user->open_id,
            'template_id' => 'qbX3UTad_ICw6H2pZnvzn2aiO1C3S3dQijAdXxNmtDE',
            'url' => url('/user/order/' . $order->id),
            'topcolor' => '#f7f7f7',
            'data' => [
                'first' => '您已成功预约  >>查看订单详情',
                'keyword1' => $order->number,
                'keyword2' => $order->money,
                'keyword3' => $order->name,
                'keyword4' => $order->mobile,
                'keyword5' => $order->plot->province.$order->plot->city.$order->plot->area.$order->plot->name.$order->address,
                'remark' => '请核对信息',
            ],
        ]);
        // 通知当前订单小区的所有业务员
        $plot = $order->plot;;
        $properties = $plot->properties->each(function($property) use ($notice, $smsService, $request, $order, $plot) {
            // 发送短信
            if($property->mobile) {
                $address = $property->plot()->first()->name;
                // $smsService->config('site.global.sms')->send($request, $property->mobile, view('template.message.property', compact('token', 'expire'))->render());
                $smsService->config('site.global.sms')->send($request, $property->mobile, "您当前服务的小区“".$address."”有新的回收订单待处理，请注意查收微信消息。【易网收】");
            }
            // 发送微信通知
            $notice->send([
                'touser' => $property->open_id,
                'template_id' => 'fFiNsV2EAyp8_mL6H9ZULllfcumWn8bAzG2E2WTUqvg',
                'url' => url('/work/property/recycle-step1/' . $order->id),
                'topcolor' => '#f7f7f7',
                'data' => [
                    'first' => '您好, 你当前服务小区[' . $plot->name . '] 有新订单:',
                    'keyword1' => $order->name,
                    'keyword2' => $order->mobile,
                    'keyword3' => $order->type,
                    'keyword4' => '上门回收',
                    'remark' => '请尽快前往回收, 谢谢! ',
                ],
            ]);
        });
        return [
            'code' => 0,
            'data' => [
                'id' => $order->id,
                'number' => $order->number,
                'type' => $order->type,
            ],
        ];
    }

    public function getPlotCxselect(PlotRepository $repository) {
        return $repository->getCxselectJson();
    }
}
