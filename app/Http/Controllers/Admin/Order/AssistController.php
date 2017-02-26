<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/28
 * Time: 下午6:40
 */

namespace App\Http\Controllers\Admin\Order;


use App\Http\Controllers\AdminBaseController;
use Icoming\Repositories\ClassificationRepository;
use Icoming\Repositories\OrderRepository;
use Icoming\Repositories\PlotRepository;
use Icoming\Services\Admin\OrderService;
use Illuminate\Http\Request;

class AssistController extends AdminBaseController {

    public function setRepository(OrderRepository $repository) {
        $this->repository = $repository;
    }

    public function getIndex() {
        $admin = session('admin');
        if(!$admin->plot) {
            return redirect()->back();
        }
        return view('admin.order.assist');
    }

    public function postIndex(Request $request, OrderService $orderService) {
        $this->validate($request, [
            'type_id' => 'required|exists:types,id',
            'name' => 'required',
            'mobile' => 'required|digits:11',
            'plot_id' => 'required|exists:plots,id',
            'address' => 'required',
        ], [
            'type_id.exists' => '不存在的型号',
            'mobile.digits' => '不合法的手机号',
            'plot_id.exists' => '不存在的小区',
        ], [
            'type_id' => '型号',
            'name' => '真实姓名',
            'mobile' => '手机号',
            'plot_id' => '小区',
            'address' => '详细地址',
        ]);
        if($order = $orderService->createAssistOrder($request)) {
            return redirect('/admin/order/info/' . $order->id);
        }
        return redirect()->back()->withInput($request->all());
    }

    public function getClassificationCxselect(ClassificationRepository $repository) {
        $classification_types = [
            '家电回收',
            '纸皮回收',
            '旧衣回收',
        ];
        return $repository->getCxselectJson($classification_types);
    }

    public function getPlotCxselect(PlotRepository $repository) {
        $admin = session('admin');
        if($admin->role == '超级管理员') {
            return $repository->getCxselectJson();
        }
        return $repository->getCxselectJson($admin->plot_id);
    }
}