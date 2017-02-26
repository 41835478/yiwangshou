<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/28
 * Time: 下午10:32
 */

namespace Icoming\Services\Admin;


use Icoming\Models\User;
use Icoming\Repositories\OrderRepository;
use Icoming\Repositories\TypeCouponRepository;
use Icoming\Repositories\TypeRepository;
use Icoming\Service;
use Illuminate\Http\Request;
use DB;

class OrderService  extends Service {

    protected $orderRepository;
    protected $typeRepository;
    protected $typeCouponRepository;

    /**
     * OrderService constructor.
     *
     * @param OrderRepository      $orderRepository
     * @param TypeRepository       $typeRepository
     * @param TypeCouponRepository $typeCouponRepository
     */
    public function __construct(OrderRepository $orderRepository, TypeRepository $typeRepository, TypeCouponRepository $typeCouponRepository) {
        $this->orderRepository = $orderRepository;
        $this->typeRepository = $typeRepository;
        $this->typeCouponRepository = $typeCouponRepository;
    }


    /**
     * 生成订单号
     * 年月日时分秒****(四位随机数)
     *
     * @return string
     */
    public function createNumber() {
        return date('YmdHis') . mt_rand(1000, 9999);
    }

    /**
     * 协助下单
     *
     * @param Request $request
     *
     * @return static
     */
    public function createAssistOrder(Request $request) {
        return $this->createOrder([
                'is_unload' => $request->has('is_unload'),
                'type' => '协助下单',
                'money' => $this->typeRepository->getValueById($request->input('type_id')),
                'status' => '已支付',
            ] + $request->all());
    }

    /**
     * 创建用户订单
     *
     * @param User    $user
     * @param Request $request
     *
     * @return OrderService
     */
    public function createUserOrder(User $user, Request $request) {
        if($request->has('type_coupon_id')) {
            // 优惠券
            $typeCoupon = $this->typeCouponRepository->find($request->input('type_coupon_id'));
            return $this->createOrder($request->all() + [
                    'is_unload' => $request->has('is_unload'),
                    'user_id' => $user->id,
                    'type' => $typeCoupon->coupon->type,
                    'coupon_id' => $request->has('coupon_id') ?: null,
                    'money' => $typeCoupon->coupon->value,
                    'status' => $typeCoupon->coupon->type == '以旧换新券' ? '待支付' : '已支付',
                    'type_id' => $typeCoupon->type->id,
                    'cfm_type_id' => $typeCoupon->type->id,
                    'type_coupon_id' => $typeCoupon->id,
                ]);
        }
        // 现金返现
        return $this->createOrder($request->all() + [
            'is_unload' => $request->has('is_unload'),
            'user_id' => $user->id,
            'type' => '现金转账',
            'money' => $this->typeRepository->getValueById($request->input('type_id')),
            'type_id' => $request->input('type_id'),
            'cfm_type_id' => $request->input('type_id'),
            'coupon_id' => $request->has('coupon_id') ?: null,
            'status' => '已支付',
        ]);
    }

    /**
     * @param $data
     *
     * @return mixed
     */
    protected function createOrder($data) {
        return $this->orderRepository->create($data + [
                'number' => $this->createNumber(),
            ]);
    }
}