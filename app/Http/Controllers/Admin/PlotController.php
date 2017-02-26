<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/25
 * Time: 下午9:40
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Models\Plot;
use Icoming\Repositories\PlotRepository;
use Illuminate\Http\Request;

class PlotController extends AdminBaseController {

    public function setRepository(PlotRepository $repository) {
        $this->repository = $repository;
    }

    public function getIndex() {
        return view('admin.list')
            ->with('thead', [
                '省' => 'province',
                '市' => 'city',
                '区' => 'area',
                '名字' => 'name',
                '管理员' => 'admin_lists',
                '操作' => [
                    '编辑' => [
                        'data-url' => '/admin/plot/edit',
                        'class' => 'btn btn-primary',
                    ],
//                    '删除' => [
//                        'data-url' => '/admin/plot/delete',
//                        'class' => 'btn btn-danger',
//                    ],
                ],
            ])
            ->with('data_url', '/admin/plot/list');
    }

    public function getList() {
        $data = Plot::with('admins')->get()->each(function(Plot $plot) {
            $plot->admin_lists = join(',', array_map(function($v) {
                return $v['username'];
            }, $plot->admins->toArray()));
            if(!$plot->admin_lists) {
                $plot->admin_lists = '未设置管理员';
            }
        });
        return compact('data');
    }

    public function getTrash() {
        return view('admin.list')
            ->with('thead', [
                '省' => 'province',
                '市' => 'city',
                '区' => 'area',
                '名字' => 'name',
                '管理员' => 'admin_lists',
                '操作' => [
                    '恢复' => [
                        'data-url' => '/admin/plot/restore',
                        'class' => 'btn btn-danger',
                    ],
                    '彻底删除' => [
                        'data-url' => '/admin/plot/delete',
                        'class' => 'btn btn-warning',
                    ],
                ],
            ])
            ->with('data_url', '/admin/plot/list-with-trashed');
    }

    public function getListWithTrashed() {
        $data = Plot::onlyTrashed()->orderBy('deleted_at', 'desc')->with('admins')->get()->each(function(Plot $plot) {
            $plot->admin_lists = join(',', array_map(function($v) {
                return $v['username'];
            }, $plot->admins->toArray()));
            if(!$plot->admin_lists) {
                $plot->admin_lists = '未设置管理员';
            }
        });
        return compact('data');
    }

    public function getAdd() {
        return view('admin.plot.form')
            ->with('plot', new Plot);
    }

    public function postAdd(Request $request) {
        $this->validate($request, [
            'province' => 'required',
            'city' => 'required',
            'name' => 'required',
        ], [ ], [
            'province' => '省',
            'city' => '市',
            'name' => '小区名字',
        ]);
        $plot = $this->repository->create($request->all());
        if($plot->id) {
            return redirect()->to('/admin/plot/edit/' . $plot->id);
        }
        return redirect()->back()->withInput($request->all());
    }

    public function getEdit($id) {
        $plot = $this->repository->getModel()->with('admins')->find($id);
        return view('admin.plot.form')
            ->with('curURI', url('admin/plot/index'))
            ->with('plot', $plot);
    }

    public function postEdit(Request $request, $id) {
        // 向当前管理员角色发送消息(管理员修改了你管辖的小区的信息) ——未完成
        $this->validate($request, [
            'province' => 'required',
            'city' => 'required',
            'name' => 'required',
        ], [ ], [
            'province' => '省',
            'city' => '市',
            'name' => '小区名字',
        ]);
        $plot = $this->repository->find($id);
        if($plot->update($request->all())) {
            return redirect()->to('/admin/plot/edit/' . $plot->id);
        }
        return redirect()->back()->withInput($request->all());
    }


    public function getMyPlot() {
        $admin = session('admin');
        return view('admin.plot.my')
            ->with('plot', $admin->plot);
    }
}