<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/5
 * Time: 下午4:33
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Models\Code;
use Icoming\Repositories\CodeRepository;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CodeController extends AdminBaseController {

    public function setRepository(CodeRepository $repository) {
        $this->repository = $repository;
    }

    /**
     * 取得所有商品编号
     */
    public function getIndex() {
        return view('admin.list')
            ->with('thead', [
                '商品编号' => 'code',
                '生成管理员' => 'admin_name',
                '生成时间' => 'create_time',
                '订单编号' => 'order_number',
                '操作' => [
                    '生成二维码' => [
                        'data-url' => '/admin/code/qr',
                        'class' => 'btn btn-primary',
                    ],
//                    '删除' => [
//                        'data-url' => '/admin/code/delete',
//                        'class' => 'btn btn-danger',
//                    ],
                ],
            ])
            ->with('data_url', '/admin/code/list');
    }

    public function getList() {
        $data = $this->repository->getModel()->whereAdminId(session('admin')->id)->get()->each(function(Code $code) {
            $code->admin_name = $code->admin->username;
            $code->create_time = $code->created_at->diffForHumans();
            $code->order_number = $code->order ? $code->order->number : '未绑定订单';
        });
        return compact('data');
    }

    public function getQr(Request $request, $code_id) {
        $code = $this->repository->find($code_id);
        return response(\QrCode::format('png')->size(300)->generate($code->code))
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="' . $code->code . '.png"');
    }

    public function getApply() {
        return view('admin.code.apply');
    }

    public function postApply(Request $request, CodeRepository $repository) {
        $this->validate($request, [
            'count' => 'required|between:1,10',
        ]);
        $admin = session('admin');
        for($i = 0; $i < $request->input('count'); ++$i) {
            $repository->create([
                'code' => mt_rand(1000, 9999) . date('mdHis') . mt_rand(1000, 9999),
                'admin_id' => $admin->id,
            ]);
        }
        return redirect('/admin/code/index');
    }
}