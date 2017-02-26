<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/26
 * Time: 下午10:39
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Models\Classification;
use Icoming\Repositories\ClassificationRepository;
use Illuminate\Http\Request;

class ClassificationController extends AdminBaseController {
    public function setRepository(ClassificationRepository $repository) {
        $this->repository = $repository;
    }

    public function getIndex() {
        $classifications = [
            '家电回收' => [],
            '纸皮回收' => [],
            '旧衣回收' => [],
        ];
        foreach($classifications as $type => &$classification) {
            $classification = $this->repository->getModel()->whereType($type)->orderBy('sort', 'asc')->get();
        }
        return view('admin.classification.list')
            ->with('classifications', $classifications);
    }

    public function getAdd() {
        return view('admin.classification.form')
            ->with('curURI', url('/admin/classification/index'))
            ->with('classification', new Classification());
    }

    public function postAdd(Request $request, $type) {
        $request->merge(compact('type'));
        $this->validate($request, [
            'name' => 'required',
            'icon' => 'required',
            'type' => 'required|in:家电回收,纸皮回收,旧衣回收',
            'sort' => 'required|numeric|min:0',
        ]);
        if($this->repository->create($request->all())) {
            return redirect('/admin/classification/index');
        }
        return redirect()->back()->withInput($request->all());
    }

    public function getEdit($id) {
        $classification = $this->repository->find($id);
        return view('admin.classification.form')
            ->with('curURI', url('/admin/classification/index'))
            ->with('classification', $classification);
    }

    public function postEdit(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'icon' => 'required',
            'sort' => 'required|numeric|min:0',
        ]);
        $classification = $this->repository->find($id);
        if($classification->update($request->all())) {
            return redirect('/admin/classification/index');
        }
        return redirect()->back();
    }

}