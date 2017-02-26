<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/29
 * Time: 上午12:15
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Repositories\TypeCouponRepository;
use Illuminate\Http\Request;

class TypeCouponController extends AdminBaseController {
    public function setRepository(TypeCouponRepository $repository) {
        $this->repository = $repository;
    }

    public function postAdd(Request $request, $type_id) {
        $request->merge(compact('type_id'));
        $this->validate($request, [
            'type_id' => 'required|exists:types,id',
            'coupon_id' => 'required|exists:coupons,id',
        ]);
        if($this->repository->getModel()->whereTypeId($type_id)->whereCouponId($request->input('coupon_id'))->first()) {
            return redirect()->back()->withErrors([
                'coupon_id' => '已经存在的关联',
            ]);
        }
        if($this->repository->create($request->all())) {
            return redirect()->back();
        }
        return redirect()->back()->withErrors([
            'coupon_id' => '服务器发生故障,关联失败',
        ]);
    }
}