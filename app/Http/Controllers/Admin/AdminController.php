<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/27
 * Time: 上午2:59
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Models\Admin;
use Icoming\Models\Plot;
use Icoming\Repositories\AdminRepository;
use Icoming\Repositories\NotificationRepository;
use Icoming\Services\Admin\NotificationService;
use Illuminate\Http\Request;
use Icoming\Presenters\Template\Notification\TestTemplate;

class AdminController extends AdminBaseController {

    public function setRepository(AdminRepository $repository) {
        $this->repository = $repository;
    }

    public function getPassword() {
        return view('admin.admin.password');
    }

    public function postPassword(Request $request) {
        $this->validate($request, [
            'password' => 'required',
            'new_password' => 'required|confirmed',
        ], [], [
            'password' => '原密码',
            'new_password' => '新密码',
        ]);
        $admin = session('admin');
        if(!password_verify($request->input('password'), $admin->password)) {
            return redirect()->back()->withErrors([
                'password' => ['原密码错误',],
            ]);
        }
        $admin->password = bcrypt($request->input('new_password'));
        $admin->save();
        return redirect('/admin/logout');
    }

    public function getPlotNull($id) {
        $admin = $this->repository->find($id);
        if(!$admin) {
            return [
                'code' => -1,
                'message' => '不存在的管理员',
            ];
        }
        $admin->plot_id = null;
        $admin->save();
        return [
            'code' => 0,
            'message' => 'ok',
        ];
    }

    public function getAdd($plot_id = null) {
        $plot = Plot::find($plot_id);
        return view('admin.admin.form')
            ->with('plot', $plot)
            ->with('curURI', url('/admin/admin/role'))
            ->with('adminModel', new Admin());
    }

    public function postAdd(Request $request) {
        $this->validate($request, [
            'username' => 'required|unique:admins',
            'password' => 'required',
            'role' => 'required|in:超级管理员,小区管理员,派单员',
            'plot_id' => 'exists:plots,id',
        ], [
            'username.unique' => '管理员账号已经存在',
            'role.in' => '角色不是合法的选项',
        ], [
            'username' => '管理员账号',
            'password' => '管理员密码',
            'role' => '角色',
            'plot_id' => '服务小区',
        ]);
        $request->merge([
            'password' => bcrypt($request->input('password')),
        ]);
        if($admin = $this->repository->create(array_map(function($v) {
            return $v ?: null;
        }, $request->all()))) {
            if($admin->plot_id) {
                return redirect("/admin/plot/edit/{$admin->plot_id}");
            }
            return redirect("/admin/admin/role");
        }
        return redirect()->back();
    }

    public function getEdit($id) {
        $admin = $this->repository->find($id);
        return view('admin.admin.form')
            ->with('plot', new Plot())
            ->with('curURI', url('/admin/admin/role'))
            ->with('adminModel', $admin);
    }

    public function postEdit(Request $request, $id) {
        $this->validate($request, [
            'role' => 'required|in:超级管理员,小区管理员,派单员',
            'plot_id' => 'exists:plots,id',
        ], [
            'username.unique' => '管理员账号已经存在',
            'role.in' => '角色不是合法的选项',
        ], [
            'username' => '管理员账号',
            'password' => '管理员密码',
            'role' => '角色',
            'plot_id' => '服务小区',
        ]);
        $admin = $this->repository->find($id);


        if($admin->update(array_map(function($v) {
            return $v ?: null;
        }, $request->all()))) {
            return redirect()->back();
        }
        return redirect("/admin/admin/role");
    }

    public function getRole() {
        return view('admin.list')
            ->with('thead', [
                '账号' => 'username',
                '角色' => 'role',
                '服务的小区' => 'plot_name',
                '操作' => [
                    '编辑' => [
                        'data-url' => '/admin/admin/edit',
                        'class' => 'btn btn-primary',
                    ],
                    '发送消息' => [
                        'data-url' => '/admin/admin/send-notification',
                        'class' => 'btn btn-warning',
                    ],
                    '删除' => [
                        'data-url' => '/admin/admin/delete',
                        'class' => 'btn btn-danger',
                    ],
                ],
            ])
            ->with('data_url', '/admin/admin/list');
    }

    public function getList() {
        $data = Admin::with('plot')->get()->each(function(Admin $admin) {
            if($admin->plot_id) {
                $admin->plot_name = $admin->plot->name;
            } else {
                $admin->plot_name = '未设置';
            }
        });
        return compact('data');
    }

    public function getSendNotification() {
        return view('admin.admin.send-notification')
            ->with('curURI', url('/admin/admin/role'))
            ->with('tpls',
                collect([
                    TestTemplate::class,
                ])->keyBy(function($tpl) {
                    $tpl = app()->make($tpl);
                    return $tpl->getNamespace() . '_' . $tpl->getView();
                })->map(function($tpl) {
                    $tplIns = app()->make($tpl);
                    return [
                        $tplIns->getName(),
                        $tplIns
                    ];
                })
            );
    }

    public function postSendNotification(Request $request, NotificationService $notificationService, $to_id) {
        $request->merge(compact('to_id'));
        $this->validate($request, [
            'to_id' => 'required|exists:admins,id',
            'from' => 'required|in:0,1',
            'title' => 'required',
        ], [], [
            'title' => '标题',
            'to_id' => '接受者',
            'from' => '消息来源',
        ]);
        $admin = session('admin');
        if($admin->role != '超级管理员' && $request->input('from') == 0) {
            return redirect()->back()->withErrors([
                'form' => '你没有权限选择官方来源',
            ]);
        }
        if($request->input('from') == 1) {
            $request->merge([
                'from_id' => $admin->id,
            ]);
        }
        if($request->input('view')) {
            $view = $request->input('view');
            $view = 'template.'.trim(join('.', explode('_', $view)), '.');
            $request->merge([
                'content' => view($view, $request->except(['from_id', 'to_id', 'title', 'content']))->render(),
            ]);
        } else {
            $this->validate($request, [
                'content' => 'required',
            ], [], [
                'content' => '内容',
            ]);
        }
        $notificationService->send(array_filter($request->only([
            'from_id', 'to_id', 'title', 'content'
        ])));
        return redirect()->back();
    }
}