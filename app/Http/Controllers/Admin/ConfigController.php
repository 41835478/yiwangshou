<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/27
 * Time: 上午3:26
 */

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\AdminController as Controller;
use Illuminate\Http\Request;

class ConfigController extends Controller {
    public function getGlobal() {
        return view('admin.config')
            ->with('configs', config('site.global', []))
            ->with('lang', trans('site/global'));
    }

    public function postGlobal(Request $request) {
        file_put_contents(config_path('site/global.php'), "<?php\nreturn " . var_export($request->except('_token'), true) . ";");
        return redirect()->back();
    }
}
