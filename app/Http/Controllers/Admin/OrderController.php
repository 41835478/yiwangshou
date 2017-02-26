<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/27
 * Time: 下午7:50
 */

namespace App\Http\Controllers\Admin;

use Session;
use App\Http\Controllers\AdminBaseController;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use Icoming\Models\CouponNumber;
use Icoming\Models\Order;
use Icoming\Repositories\OrderRepository;
use Icoming\Services\OrderService;
use Icoming\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends AdminBaseController {

    public function setRepository(OrderRepository $repository) {
        $this->repository = $repository;
    }

    public function getMoreUnReadList($moreId) {
        // 如果是超级管理员

        // 如果是小区管理员则只加载当前小区的新单
        return [
            'code' => 0,
            'data' => Order::whereIsRead(false)->orderBy('id', 'desc')->take(5)->where('id', '<', $moreId)->get(),
        ];
    }

    public function getUnReadList($id = null) {
        $admin = Session::get('admin');
        // 如果是超级管理员

        // 如果是小区管理员则只加载当前小区的新单
        $s = 0;
        while(true) {
            $s++;
            // $id 为 null 代表最后一条
            $q = Order::whereIsRead(false)->orderBy('id', 'desc');
            if($id) {
                $q = $q->where('id', '>', $id);
            } else {
                $q = $q->take(5);
            }
            if($admin->role === '小区管理员') {
                $q = $q->wherePlotId($admin->plot_id);
            }
            $r = $q->get();
            if(count($r) > 0) {
                return [
                    'code' => 0,
                    'message' => 'ok',
                    'total' => Order::whereIsRead(false)->count(),
                    'data' => $r->toArray(),
                ];
            }
            sleep(1);
            if($s === 10) break;
        }
        return [
            'code' => -1,
            'message' => 'timeout',
        ];
    }

    public function getIndex() {
        return view('admin.list')
            ->with('thead', [
                '订单号' => 'number',
                '类型' => 'type',
                '回收型号' => 'modelName',
                '金额' => 'money',
                '状态' => 'status',
                '是否已返利' => 'is_paid',
                '姓名' => 'name',
                '电话' => 'mobile',
                '下单时间' => 'created_at',
                '操作' => [
                    '查看' => [
                        'data-url' => '/admin/order/info',
                        'class' => 'btn btn-primary',
                    ],
                    '删除' => [
                        'data-url' => '/admin/order/delete',
                        'class' => 'btn btn-danger',
                    ],
                ],
            ])
            ->with('data_url', '/admin/order/list');
    }

    public function getList() {
        $data = Order::orderBy('created_at', 'desc')->get()->each(function(Order $order) {
            $order->modelName = $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name;
            $order->is_paid = $order->is_paid ? '是' : '否';
            $orderRepository = new OrderRepository($order);
            $order->status = $orderRepository->getOrderStatus();
        });
        return compact('data');
    }

    public function getInfo($id) {
        $order = $this->repository->getModel()->withTrashed()->find($id);
        if($order) {
            $order->is_read = true; // 标记已读
            $order->save(); // 保存
            return view('admin.order.form')
                ->with('curURI', url('/admin/order/index'))
                ->with('order', $order);
        } else {
            return redirect()->back();
        }
    }

    public function getPlot() {
        return view('admin.list')
            ->with('thead', [
                '订单号' => 'number',
                '类型' => 'type',
                '回收型号' => 'modelName',
                '金额' => 'money',
                '状态' => 'status',
                '是否已返利' => 'is_paid',
                '操作' => [
                    '查看' => [
                        'data-url' => '/admin/order/plot-info',
                        'class' => 'btn btn-primary',
                    ],
                ],
            ])
            ->with('data_url', '/admin/order/plot-list');
    }

    public function getPlotList() {
        $admin = session('admin');
        if(!$admin->plot) {
            return [
                'data' => [],
            ];
        }
        $data = Order::wherePlotId($admin->plot->id)->orderby('id', 'desc')->get()->each(function(Order $order) {
            $order->modelName = $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name;
            $order->is_paid = $order->is_paid ? '是' : '否';
        });
        return compact('data');
    }

    public function getPlotInfo($id) {
        $order = $this->repository->find($id);
        if($order->plot_id != session('admin')->plot->id) {
            return redirect()->back();
        }
        return view('admin.order.form')
            ->with('curURI', url('/admin/order/index'))
            ->with('order', $order);
    }

    public function getAssist() {
        return view('admin.list')
            ->with('thead', [
                '订单号' => 'number',
                '金额' => 'money',
                '状态' => 'status',
                '操作' => [
                    '确认发放奖励' => [
                        'data-url' => '/admin/order/pay-assist',
                        'class' => 'btn btn-primary',
                    ],
                ],
            ])
            ->with('data_url', '/admin/order/assist-list');
    }

    public function getAssistList() {
        $admin = session('admin');
        if(!$admin->plot) {
            return [
                'data' => [],
            ];
        }
        $data = Order::wherePlotId($admin->plot->id)->whereType('协助下单')->whereIsPaid(false)->get();
        return compact('data');
    }

    /**
     * 发放奖励
     */
    public function postPay(Request $request, $order_id, OrderService $orderService) {
        $order = $this->repository->getModel()->find($order_id);
        if(!$order) {
            return redirect()->back();
        }

        if($order->type === '有成本券') {
            $coupon_number = $request->input('coupon_number', '');
            $err = null;
            if($coupon_number) {
                try {
                    $err = DB::transaction(function() use(&$coupon_number, &$order, &$orderService) {
                        $number = CouponNumber::create([
                            'value' => $coupon_number,
                            'coupon_id' => $order->typeCouponWithTrashed->coupon_id,
                        ]);
                        return $orderService->dispatchCostCouponNumber4Order($order, $number);
                    });
                } catch (\Exception $e) {
                    $err = $e->getMessage();
                }
            } else {
                $err = $orderService->dispatchCostCoupon4Order($order);
            }
        } elseif($order->type === '以旧换新券') {
            $err = $this->dispatchOld2NewCoupon4Order($order);
        } else {
            // 现金优惠和协助下单
            $this->validate($request, [
                'cfm_money' => 'required',
            ]);
            $order->cfm_money = $request->input('cfm_money');
            if($order->cfm_money < 1) {
                return redirect()->back()->with('alert', "奖励发放金额不能低于1元");
            }
            $err = $orderService->dispatch($order);
        }
        if($err) {
            return redirect()->back()->with('alert', $err);
        } else {
            return redirect()->back();
        }
    }

    /**
     * 确认发放奖励
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getPayAssist($id) {
        $order = $this->repository->find($id);
        $admin = session('admin');
        if($admin->role == '小区管理员' && $order->plot_id != $admin->plot_id) {
            return redirect()->back();
        }
        $order->is_paid = true;
        $order->paid_at = Carbon::now();
        $order->save();
        return redirect()->back();
    }

    public function getTrash() {
        return view('admin.list')
            ->with('thead', [
                '订单号' => 'number',
                '类型' => 'type',
                '回收型号' => 'modelName',
                '金额' => 'money',
                '状态' => 'status',
                '是否已返利' => 'is_paid',
                '姓名' => 'name',
                '电话' => 'mobile',
                '下单时间' => 'created_at',
                '操作' => [
                    '查看' => [
                        'data-url' => '/admin/order/info',
                        'class' => 'btn btn-primary',
                    ],
                    '恢复' => [
                        'data-url' => '/admin/order/restore',
                        'class' => 'btn btn-warning',
                    ],
                ],
            ])
            ->with('data_url', '/admin/order/list-with-trashed');
    }

    public function getListWithTrashed() {
        $data = Order::onlyTrashed()->orderBy('deleted_at', 'desc')->get()->each(function(Order $order) {
            $order->modelName = $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name;
            $order->is_paid = $order->is_paid ? '是' : '否';
        });
        return compact('data');
    }


}
