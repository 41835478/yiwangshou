<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/26
 * Time: 下午8:36
 */

namespace App\Http\Controllers;


use Icoming\Repository;
use Icoming\Services\Admin\AdminLogService;
use Illuminate\Http\Request;

class AdminBaseController extends AdminController {

    /**
     * @var Repository
     */
    protected $repository;

    public function __construct(AdminLogService $adminLogService) {
        parent::__construct($adminLogService);
        app()->call([$this, 'setRepository']);
    }

    public function getDelete(Request $request, $id) {
        $model = $this->repository->withTrashed()->find($id);
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

    public function getRestore(Request $request, $id) {
        $model = $this->repository->onlyTrashed()->find($id);
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
