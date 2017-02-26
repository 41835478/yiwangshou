<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/6/25
 * Time: 下午9:41
 */

namespace App\Http\Controllers\Admin\Classification;


use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class IconController extends AdminController {

    public function getIndex() {
        return view('admin.classification.icon');
    }

    public function postUpload() {
        $fn = (isset($_SERVER['HTTP_X_FILENAME']) ? $_SERVER['HTTP_X_FILENAME'] : false);
        if ($fn) {
            $ext = explode('.', $fn);
            file_put_contents(
                public_path('assets/home/img/icon/' . time() . mt_rand(100000, 999999)) . '.' . end($ext),
                file_get_contents('php://input')
            );
        }
        return '';
    }

    public function getDel($src) {
        $filepath = public_path('assets/home/img/icon/'.$src);
        if(unlink($filepath)) {
            return ['code' => 0];
        } else {
            return ['code' => -1, 'message' => '删除失败,权限不足'];
        }
    }
}