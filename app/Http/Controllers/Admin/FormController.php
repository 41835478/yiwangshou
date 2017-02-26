<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/26
 * Time: 下午6:34
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Carbon\Carbon;
use Icoming\Models\Form;
use Icoming\Repositories\FormRepository;
use Illuminate\Http\Request;

class FormController extends AdminBaseController {

    public function setRepository(FormRepository $repository) {
        $this->repository = $repository;
    }

    public function getIndex() {
        return view('admin.list')
            ->with('thead', [
                '申请者' => 'admin.username',
                '申请时间' => 'created_time',
                '状态' => 'status',
                '操作' => [
                    '查看详情' => [
                        'data-url' => '/admin/form/info',
                        'class' => 'btn btn-primary',
                    ],
                    '删除' => [
                        'data-url' => '/admin/form/delete',
                        'class' => 'btn btn-danger',
                    ],
                ],
            ])
            ->with('data_url', '/admin/form/list');
    }

    public function getList() {
        $data = Form::with('admin')->get()->each(function(Form $form) {
            $form->created_time = $form->created_at->diffForHumans();
            if($form->refused_reason) {
                $form->status = '已拒绝';
            }
        });
        return compact('data');
    }

    public function getTrash() {
        return view('admin.list')
            ->with('thead', [
                '申请者' => 'admin.username',
                '申请时间' => 'created_time',
                '状态' => 'status',
                '操作' => [
                    '恢复' => [
                        'data-url' => '/admin/form/restore',
                        'class' => 'btn btn-warning',
                    ],
//                    '强制删除' => [
//                        'data-url' => '/admin/form/delete',
//                        'class' => 'btn btn-danger',
//                    ],
                ],
            ])
            ->with('data_url', '/admin/form/list-with-trashed');
    }

    public function getListWithTrashed() {
        $data = Form::onlyTrashed()->with('admin')->get()->each(function(Form $form) {
            $form->created_time = $form->created_at->diffForHumans();
            if($form->refused_reason) {
                $form->status = '已拒绝';
            }
        });
        return compact('data');
    }

    public function getInfo($id) {
        $form = $this->repository->find($id);
        $admin = session('admin');
        if($admin->role != '超级管理员') {
            if($form->admin_id != $admin->id) {
                return redirect()->back();
            }
        }
        return view('admin.form.info')
            ->with('curURI', url('/admin/form/' . $admin->role == '超级管理员' ? 'index' : 'plot'))
            ->with('form', $form);
    }

    public function getAgree($id) {
        $form = $this->repository->find($id);
        $form->refused_reason = null;
        $form->status = '已派车';
        $form->save();
        return redirect()->back();
    }

    public function postRefuse(Request $request, $id) {
        $form = $this->repository->find($id);
        $form->refused_reason = $request->input('refused_reason') ?: null;
        $form->save();
        return redirect()->back();
    }

    public function getApply() {
        return view('admin.form.apply');
    }

    public function postApply(Request $request) {
        // 检查表单数据
        $this->validate($request, [
            'remark' => 'required',
        ]);
        session()->forget('form.last_apply_at');
        // 检查是否在60分钟以内发起的
        if(Carbon::now()->timestamp - session('form.last_apply_at', Carbon::now()->subMinutes(60)->timestamp) < 3600) {
            return redirect()->back()->withErrors([
                'error' => '1小时内不能重复发送派车申请',
            ]);
        }
        session()->set('form.last_apply_at', Carbon::now()->timestamp);
        $request->merge([
            'admin_id' => session('admin')->id,
        ]);
        if($this->repository->create($request->all())) {
            return redirect('/admin/form/plot');
        }
        return redirect()->back()->withInput($request->all());
    }


    public function getPlot() {
        return view('admin.list')
            ->with('thead', [
                '备注信息' => 'remark',
                '申请时间' => 'created_time',
                '状态' => 'status',
                '操作' => [
                    '查看详情' => [
                        'data-url' => '/admin/form/info',
                        'class' => 'btn btn-primary',
                    ],
                    '删除' => [
                        'data-url' => '/admin/form/delete',
                        'class' => 'btn btn-danger',
                    ],
                ],
            ])
            ->with('data_url', '/admin/form/plot-list');
    }

    public function getPlotList() {
        $data = Form::whereAdminId(session('admin')->id)->with('admin')->get()->each(function(Form $form) {
            $form->created_time = $form->created_at->diffForHumans();
            if($form->refused_reason) {
                $form->status = '已拒绝';
            }
        });
        return compact('data');
    }

}