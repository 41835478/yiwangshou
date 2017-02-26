<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/26
 * Time: 下午5:30
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Models\PlotProperty;
use Icoming\Models\User;
use Icoming\Repositories\UserRepository;
use Illuminate\Http\Request;

class UserController extends AdminBaseController {

    public function setRepository(UserRepository $repository) {
        $this->repository = $repository;
    }

    public function getIndex() {
        return view('admin.list')
            ->with('thead', [
                '昵称' => 'nickname',
                '性别' => 'sex',
                '手机号' => 'mobile',
                '角色' => 'role',
                '所属小区' => 'plot_name',
                '操作' => [
                    '冻结' => [
                        'data-url' => '/admin/user/delete',
                        'class' => 'btn btn-info',
                    ],
                    '设置' => [
                        'data-url' => '/admin/user/role',
                        'class' => 'btn btn-warning',
                    ],
                ],
            ])
            ->with('data_url', '/admin/user/list');
    }

    public function getList() {
        $data = User::with('plot')->orderBy('id', 'desc')->get()->each(function(User $user) {
            if(!$user->plot) {
                $user->plot_name = '未设置';
            } else {
                $user->plot_name = $user->plot->name;
            }
        });
        return compact('data');
    }

    public function getTrash() {
        return view('admin.list')
            ->with('thead', [
                '昵称' => 'nickname',
                '性别' => 'sex',
                '手机号' => 'mobile',
                '角色' => 'role',
                '所属小区' => 'plot_name',
                '操作' => [
                    '恢复' => [
                        'data-url' => '/admin/user/restore',
                        'class' => 'btn btn-danger',
                    ],
//                    '彻底删除' => [
//                        'data-url' => '/admin/user/delete',
//                        'class' => 'btn btn-warning',
//                    ],
                ],
            ])
            ->with('data_url', '/admin/user/list-with-trashed');
    }

    public function getListWithTrashed() {
        $data = User::onlyTrashed()->orderBy('deleted_at', 'desc')->with('plot')->get()->each(function(User $user) {
            if(!$user->plot) {
                $user->plot_name = '未设置';
            } else {
                $user->plot_name = $user->plot->name;
            }
        });
        return compact('data');
    }

    public function getRole($id) {
        $user = $this->repository->getModel()->with('plots')->find($id);
        if(!$user) {
            return redirect()->back();
        }
        return view('admin.user.role')
            ->with('curURI', url('admin/user/index'))
            ->with('user', $user);
    }

    public function getServePlot($property_id, $plot_id) {
        if($relate = PlotProperty::wherePropertyId($property_id)->wherePlotId($plot_id)->first()) {
            $relate->delete();
        } else {
            if(PlotProperty::create(compact('property_id', 'plot_id'))) {
                return [
                    'code' => 0,
                    'data' => 1,
                ];
            }
        }
        return [
            'code' => 0,
            'data' => 0,
        ];
    }

    public function postRole(Request $request, $id) {
        $user = $this->repository->find($id);
        if(!$user) {
            return redirect()->back();
        }
        $this->validate($request, [
            'role' => 'required|in:默认,司机,业务员,入库员,出库员',
            'plot_id' => 'exists:plots,id',
        ], [
            'role.in' => '角色必须是合法的选项',
            'plot_id' => '服务小区必须是存在的合法小区',
        ], [
            'role' => '角色',
            'plot_id' => '服务小区',
        ]);
        if($user->update(array_map(function($v) {
            return $v ?: null;
        }, $request->only(['role', 'plot_id', ])))) {
            return redirect('/admin/user/index');
        }
        return redirect()->back();
    }

    public function getPlot() {
        return view('admin.list')
            ->with('thead', [
                '昵称' => 'nickname',
                '性别' => 'sex',
                '手机号' => 'mobile',
//                '角色' => 'role',
                '操作' => [
                    '冻结' => [
                        'data-url' => '/admin/user/plot-delete',
                        'class' => 'btn btn-info',
                    ],
                ],
            ])
            ->with('data_url', '/admin/user/plot-list');
    }

    public function getPlotList() {
        $admin = session('admin');
        if(!$admin->plot) {
            return [
                'data' => [],
            ];
        }
        $data = User::whereRole('业务员')->wherePlotId($admin->plot->id)->with('plot')->get();
        return compact('data');
    }


    public function getPlotFreeze() {
        return view('admin.list')
            ->with('thead', [
                '昵称' => 'nickname',
                '性别' => 'sex',
                '手机号' => 'mobile',
//                '角色' => 'role',
                '操作' => [
                    '解冻' => [
                        'data-url' => '/admin/user/plot-restore',
                        'class' => 'btn btn-warning',
                    ],
                ],
            ])
            ->with('data_url', '/admin/user/plot-freeze-list');
    }

    public function getPlotFreezeList() {
        $admin = session('admin');
        if(!$admin->plot) {
            return [
                'data' => [],
            ];
        }
        $data = User::onlyTrashed()->whereRole('业务员')->wherePlotId($admin->plot->id)->with('plot')->get();
        return compact('data');
    }

    public function getPlotDelete(Request $request, $id) {
        $model = $this->repository->withTrashed()->find($id);
        if($model->plot_id != session('admin')->plot->id) {
            return redirect()->back();
        }
        if($model && $model->trashed()) {
            $model->forceDelete();
        } else if ($model) {
            $model->delete();
        }
        if($request->ajax()) {
            return [
                'code' => 0,
                'message' => '删除成功',
            ];
        }
        return redirect()->back();
    }

    public function getPlotRestore(Request $request, $id) {
        $model = $this->repository->withTrashed()->find($id);
        if($model->plot_id != session('admin')->plot->id) {
            return redirect()->back();
        }
        if($model) {
            $model->restore();
        }
        if($request->ajax()) {
            return [
                'code' => 0,
                'message' => '恢复成功',
            ];
        }
        return redirect()->back();
    }

}