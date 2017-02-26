<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/26
 * Time: 下午5:52
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Carbon\Carbon;
use Icoming\Models\Coupon;
use Icoming\Models\CouponNumber;
use Icoming\Models\Order;
use Icoming\Repositories\CouponRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Collections\CellCollection;
use Maatwebsite\Excel\Collections\RowCollection;
use Maatwebsite\Excel\Facades\Excel;

class CouponController extends AdminBaseController {

    public function setRepository(CouponRepository $repository) {
        $this->repository = $repository;
    }

    public function getCost() {
        return view('admin.list')
            ->with('thead', [
                '名字' => 'name',
                '备注' => 'remark',
                '值(附加值)' => 'value',
                '类型' => 'type',
//                '过期期限' => 'expired_in',
                '操作' => [
                    '删除' => [
                        'data-url' => '/admin/coupon/delete',
                        'class' => 'btn btn-danger',
                    ],
                    '编辑' => [
                        'data-url' => '/admin/coupon/edit',
                        'class' => 'btn btn-primary',
                    ],
                ],
            ])
            ->with('data_url', '/admin/coupon/cost-list');
    }

    public function getCostList() {
        $data = Coupon::whereType('有成本券')->orWhere('type', '=', '以旧换新券')->get()->each(function(Coupon $coupon) {
            if($coupon->ext_value) {
                $coupon->value += "({$coupon->ext_value})";
            }
//            if($coupon->expired_at) {
//                $coupon->expired_in = (new Carbon($coupon->expired_at))->format("Y-m-d");
//            } else if ($coupon->timestamp) {
//                $coupon->expired_in = "自领取起" . Carbon::now()->addSeconds($coupon->timestamp)->diffInDays() . "天后";
//            } else {
//                $coupon->expired_in = '无期限';
//            }
        });
        return compact('data');
    }

    public function getNoCost() {
        return view('admin.list')
            ->with('thead', [
                '名字' => 'name',
                '备注' => 'remark',
                '值(附加值)' => 'value',
//                '过期期限' => 'expired_in',
                '操作' => [
                    '删除' => [
                        'data-url' => '/admin/coupon/delete',
                        'class' => 'btn btn-danger',
                    ],
                    '编辑' => [
                        'data-url' => '/admin/coupon/edit',
                        'class' => 'btn btn-primary',
                    ],
                ],
            ])
            ->with('data_url', '/admin/coupon/no-cost-list');
    }

    public function getNoCostList() {
        $data = Coupon::whereType('无成本券')->get()->each(function(Coupon $coupon) {
            if($coupon->ext_value) {
                $coupon->value += "({$coupon->ext_value})";
            }
//            if($coupon->expired_at) {
//                $coupon->expired_in = (new Carbon($coupon->expired_at))->format("Y-m-d H:i:s");
//            } else if ($coupon->timestamp) {
//                $coupon->expired_in = "自领取起" . Carbon::now()->addSeconds($coupon->timestamp)->diffInDays() . "天后";
//            } else {
//                $coupon->expired_in = '无期限';
//            }
        });
        return compact('data');
    }

    public function getTrash() {
        return view('admin.list')
            ->with('thead', [
                '名字' => 'name',
                '备注' => 'remark',
                '值(附加值)' => 'value',
//                '过期期限' => 'expired_in',
                '类型' => 'type',
                '操作' => [
                    '恢复' => [
                        'data-url' => '/admin/coupon/restore',
                        'class' => 'btn btn-warning',
                    ],
//                    '强制删除' => [
//                        'data-url' => '/admin/coupon/delete',
//                        'class' => 'btn btn-danger',
//                    ],
                ],
            ])
            ->with('data_url', '/admin/coupon/list-with-trashed');
    }

    public function getListWithTrashed() {
        $data = Coupon::onlyTrashed()->orderBy('deleted_at', 'desc')->get()->each(function(Coupon $coupon) {
            if($coupon->ext_value) {
                $coupon->value += "({$coupon->ext_value})";
            }
//            if($coupon->expired_at) {
//                $coupon->expired_in = $coupon->expired_at->format("Y-m-d H:i:s");
//            } else if ($coupon->timestamp) {
//                $coupon->expired_in = "自领取起" . Carbon::now()->addSeconds($coupon->timestamp)->diffInDays() . "天后";
//            } else {
//                $coupon->expired_in = '无期限';
//            }
        });
        return compact('data');
    }

    public function getAdd() {
        return view('admin.coupon.form')
            ->with('coupon', new Coupon());
    }

    public function postAdd(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'remark' => 'required',
            'value' => 'required|numeric',
            'ext_value' => 'numeric',
            'type' => 'required|in:有成本券,无成本券,以旧换新券',
//            'timestamp' => 'integer',
        ], [], [
            'name' => '优惠券名字',
            'remark' => '备注',
            'value' => '数值',
            'ext_value' => '附加数值',
            'type' => '类型',
//            'timestamp' => '有效天数',
//            'expired_at' => '到期时间',
        ]);
        $data = $request->all();
        array_walk($data, function(&$v, $k) {
            if($k == 'expired_at') {
                $v = Carbon::createFromTimestamp(strtotime($v));
            }
        });
        $coupon = $this->repository->create($data);
        return redirect('/admin/coupon/edit/' . $coupon->id)->with('alert', '添加成功');
    }

    public function getEdit($id) {
        $coupon = $this->repository->find($id);
        return view('admin.coupon.form')
            ->with('curURI', url('/admin/coupon/cost'))
            ->with('data_url', '/admin/coupon/numbers/' . $coupon->id)
            ->with('coupon', $coupon);
    }

    public function getNumbers($id) {
        $data = Coupon::findOrFail($id)->numbers()->orderBy('id', 'desc')->with('order')->get()->each(function($model) {
            if($model->order_id) {
                $model->type = '已使用';
                $model->order_number = "<a href='/admin/order/info/{$model->order_id}'>{$model->order->number}</a>";
            } else {
                $model->type = '未使用';
                $model->order_number = '未绑定';
            }
        });
        return compact('data');
    }

    public function postImportNumbers(Request $request, $id) {
        $coupon = Coupon::findOrFail($id);
        if($request->hasFile('file')) {
            $file = $request->file('file');
            $res = null;
            switch($file->getClientOriginalExtension()) {
                case 'json':
                    $content = file_get_contents($file->getPathname());
                    $res = json_decode($content, true);
                    break;
                case 'csv':
                case 'xls':
                case 'xlsx':

                    $data = Excel::load($file->getPathname())->get();
                    $res = array_map(function($v) {
                        return $v->get('1');
                    }, $data->all());
                    break;
                default:
                    return [
                        'code' => -1,
                        'message' => '不合法的文件格式',
                    ];
                    break;
            }
            $res = array_filter($res);
            if(!is_array($res) || !count($res)) {
                return [
                    'code' => -1,
                    'message' => '数据结构不正确, 请上传正确结构的文档。',
                ];
            }

            try {
                DB::transaction(function() use(&$res, &$coupon) {
                    (new Collection($res))->each(function($v) use(&$coupon) {
                        $v = (string) $v;
                        CouponNumber::create([
                            'value' => $v,
                            'coupon_id' => $coupon->id,
                        ]);
                    });
                });
            } catch(\Exception $exception) {
                return [
                    'code' => -1,
                    'message' => '数据结构不正确, 或者服务器繁忙, 请稍后再试, 如果频繁出错请联系管理员。',
                ];
            }
            return [
                'code' => 0,
                'message' => '导入数据成功',
            ];

        } else {
            // 文件不存在
            return [
                'code' => -1,
                'message' => '文件不存在',
            ];
        }

    }

    public function postEdit(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'remark' => 'required',
            'value' => 'required|numeric',
            'ext_value' => 'numeric',
            'type' => 'required|in:有成本券,无成本券,以旧换新券',
//            'timestamp' => 'integer',
        ], [], [
            'name' => '优惠券名字',
            'remark' => '备注',
            'value' => '数值',
            'ext_value' => '附加数值',
            'type' => '类型',
//            'timestamp' => '有效天数',
//            'expired_at' => '到期时间',
        ]);
        $coupon = $this->repository->find($id);
        $coupon->update(array_map(function($v) {
            return $v ?: null;
        }, $request->all()));
        return redirect()->back();
    }
}
