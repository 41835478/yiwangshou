<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/26
 * Time: 下午10:40
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminBaseController;
use Icoming\Models\Type;
use Icoming\Repositories\TypeRepository;
use Illuminate\Http\Request;

class TypeController extends AdminBaseController {
    public function setRepository(TypeRepository $repository) {
        $this->repository = $repository;
    }

    public function getAdd() {
        return view('admin.type.form')
            ->with('curURI', url('/admin/classification/index'))
            ->with('type', new Type());
    }

    public function postAdd(Request $request, $classification_id) {
        $request->merge(compact('classification_id'));
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required|numeric|min:0.01',
            'classification_id' => 'required|exists:classifications,id',
            'sort' => 'required|numeric|min:0',
        ]);
        if($this->repository->create($request->all())) {
            return redirect('/admin/classification/index');
        }
        return redirect()->back()->withInput($request->all());
    }

    public function getEdit($id) {
        $type = $this->repository->find($id);
        return view('admin.type.form')
            ->with('curURI', url('/admin/classification/index'))
            ->with('type', $type);
    }

    public function postEdit(Request $request, $id) {
        $this->validate($request, [
            'name' => 'required',
            'value' => 'required|numeric|min:0.01',
            'sort' => 'required|numeric|min:0',
        ]);
        $classification = $this->repository->find($id);
        if($classification->update($request->all())) {
            return redirect('/admin/classification/index');
        }
        return redirect()->back();
    }

}