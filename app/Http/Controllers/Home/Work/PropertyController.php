<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/9
 * Time: 上午10:47
 */

namespace App\Http\Controllers\Home\Work;



use Carbon\Carbon;
use Icoming\Repositories\OrderImageRepository;
use Icoming\Services\OrderService;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use App\Http\Controllers\Controller;
use EasyWeChat\Foundation\Application;
use Icoming\Models\Code;
use Icoming\Models\Order;
use Icoming\Repositories\ClassificationRepository;
use Icoming\Repositories\OrderRepository;
use Icoming\Repositories\TypeRepository;
use Illuminate\Http\Request;

class PropertyController extends Controller {


    protected $user;

    public function __construct() {
        $this->user = session('user');
    }

    public function getTask(Application $application) {
        return view('home.work.property.task');
    }

    public function getAjaxTaskReady() {
//        $per_page = 5;
//        return $this->user->plot->orders()->with('modelWithTrashed.classificationWithTrashed')->whereStatus('已支付')->paginate($per_page);
        $per_page = 5;

        return Order::leftJoin('plots', 'orders.plot_id', '=', 'plots.id')
            ->whereRaw('plot_id in (select plot_id from plot_properties where property_id = ?)', [$this->user->id])
            ->whereNull('property_id')
            ->with('modelWithTrashed.classificationWithTrashed')->whereStatus('已支付')
            ->orderBy('orders.id', 'desc')
            ->select('*', 'orders.created_at as orders_created_at')
            ->paginate($per_page);
    }

    public function getAjaxTaskTemp() {
//        $per_page = 5;
//        return $this->user->plot
//            ->orders()
//            ->with('cfmModel.classificationWithTrashed')
//            ->whereStatus('暂存')
//            ->wherePropertyId($this->user->id)
//            ->orderBy('id', 'desc')
//            ->paginate($per_page);
        $per_page = 5;
        return Order::join('plots', 'plots.id', '=', 'orders.plot_id')
            ->whereRaw('plot_id in (select plot_id from plot_properties where property_id = ?)', [$this->user->id])
            ->with('cfmModel.classificationWithTrashed')
            ->whereStatus('暂存')
            ->wherePropertyId($this->user->id)
            ->select('*', 'orders.created_at as orders_created_at')
            ->orderBy('orders.id', 'desc')
            ->paginate($per_page);
    }

    public function getAjaxTaskOther() {
        $per_page = 5;
//        return $this->user->plot
//            ->orders()
        return Order::join('plots', 'plots.id', '=', 'orders.plot_id')
            ->whereRaw('plot_id in (select plot_id from plot_properties where property_id = ?)', [$this->user->id])
            ->with('modelWithTrashed.classificationWithTrashed')
            ->where('status', '!=', '待支付')
            ->where('status', '!=', '已支付')
            ->where('status', '!=', '暂存')
            ->wherePropertyId($this->user->id)
            ->select('*', 'orders.created_at as orders_created_at')
            ->orderBy('orders.id', 'desc')
            ->paginate($per_page);
    }

    public function getRecycleStep1($order_id ,OrderRepository $orderRepository) {
        $order = $orderRepository->getOrderWithModel($order_id);
        if(!$order) {
            return redirect('/');
        }
        /// ddl_edit 未知作用 方法也未找到
        // if(!$order->isRecyclable()) {
        //     return redirect()->back();
        // }
        return view('home.work.property.recycle-step1')
            ->with('order', $order);
    }

    public function getRecycleCannot() {
        return view('home.work.property.recycle-cannot');
    }

    public function postRecycleCannot(Request $request, $order_id) {
        $order = Order::find($order_id);
        if(!$order) {
            return redirect('/');
        }
        // 不是可回收的
        if(!$order->isRecyclable()) {
            return redirect()->back();
        }
        $request->merge([
            'property_id' => $this->user->id,
            'status' => '无法回收',
            'property_at' => Carbon::now(),
        ]);
        $order->update($request->all());
        return redirect('/work/property/task');
    }

    public function getRecycleStep2($order_id ,OrderRepository $orderRepository, Application $application) {
        $order = $orderRepository->getOrderWithModel($order_id);
        if(!$order) {
            return redirect('/');
        }
        if(!$order->isRecyclable()) {
            return redirect()->back();
        }
        return view('home.work.property.recycle-step2')
            ->with('order', $order)
            ->with('js', $application->js)
            ->with('apis', ['scanQRCode', 'chooseImage', 'uploadImage']);
    }

    public function getClassificationCxselect(ClassificationRepository $repository) {
        $classification_types = [
            '家电回收',
            '纸皮回收',
            '旧衣回收',
        ];
        return $repository->getCxselectJson($classification_types);
    }

    public function getVerifyCode($code) {
        $model = Code::whereCode($code)->first();
        if(!$model) {
            return [
                'code' => -2,
                'message' => '不存在的二维码',
            ];
        }
        if($model->order) {
            return [
                'code' => -2,
                'message' => '该二维码已经被使用',
            ];
        }
        if($model) {
            return [
                'code' => 0,
                'data' => $model->id,
            ];
        }
        return [
            'code' => -1,
            'message' => '不存在的商品编号',
        ];
    }

    // 提交保存
    public function postRecycleStep2(Request $request, $order_id, OrderRepository $orderRepository, TypeRepository $typeRepository, Application $application, UploadManager $uploadManager, OrderService $orderService) {
        $order = $orderRepository->getOrderWithModel($order_id);
        if(!$order) {
            return [
                'code' => -1,
                'message' => '无效的订单',
            ];
        }
        if(!$order->isRecyclable()) {
            return [
                'code' => -1,
                'message' => '非法订单',
            ];
        }
        // 更新cfm_is_unload, cfm_money (根据提交的type_id)
        $type = $typeRepository->find($request->input('type_id'));
        if(!$type) {
            return [
                'code' => -1,
                'message' => '非法类型',
            ];
        }
        $order->cfm_is_unload = $request->input('is_unload') == 'true';
        if($miss_component_reason = $request->input('miss_component_reason')) {
            $order->miss_component_reason = $miss_component_reason;
        }
        if(($cfm_money = $request->input('cfm_money')) && $cfm_money <= $type->value) {
            $order->cfm_money = $cfm_money;
        } else {
            $order->cfm_money = $type->value;
        }
        // + 业务员确定新的型号
        $order->cfm_type_id = $type->id;
        // 更新status
        $order->status = '暂存';
        // 更新code_id
        $order->code_id = $request->input('code_id');
        // 更新property_id
        $order->property_id = $this->user->id;
        $order->property_at = Carbon::now();
        // 根据imgs 上传图片到七牛并设置回调更新orderImages
        $imgs = $request->input('imgs');
        $temporary = $application->material_temporary;
        $auth = new Auth(config('qiniu.AccessKey'), config('qiniu.SecretKey'));
        $bucket = 'anlaishou';
        $token = $auth->uploadToken($bucket, null, 3600, [
            'callbackUrl' => url('/qiniu/order-images'),
            'callbackBody' => 'hash=$(etag)&order_id=' . $order->id,
        ]);
        foreach($imgs as $img) {
            $temporary->download($img, storage_path('app/wechat_media'), $img);
            $uploadManager->putFile($token, null, storage_path('app/wechat_media/' . $img . '.jpg'));
        }
        $order->save();
        try {
            $err = $orderService->dispatch($order);
        } catch(\Exception $e) {
            $err = '服务器发生错误';
        }
        if($err) {
            return [
                'code' => '-0',
                'url' => '/work/property/order/' . $order->id,
                'message' => '奖励没有发放: 失败原因' . $err . '。请告知用户在24小时内会补发给用户。',
            ];
        }
        return [
            'code' => 0,
            'url' => '/work/property/order/' . $order->id,
        ];
    }

    public function anyOrderImages(Request $request, OrderImageRepository $repository) {
        logger($request->all());
        $auth = new Auth(config('qiniu.AccessKey'), config('qiniu.SecretKey'));
        //获取回调的body信息
        $callbackBody = file_get_contents('php://input');
        //回调的contentType
        $contentType = 'application/x-www-form-urlencoded';
        //回调的签名信息，可以验证该回调是否来自七牛
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];

        //七牛回调的url，具体可以参考
        $url = url('/qiniu/order-images');

        $isQiniuCallback = $auth->verifyCallback($contentType, $authorization, $url, $callbackBody);

        if ($isQiniuCallback) {
            $filename = $request->input('hash');
            $order_id = $request->input('order_id');
            $order = Order::find($order_id);
            if($order) {
                $repository->create([
                    'image' => $filename,
                    'order_id' => $order_id,
                ]);
            }
            $resp = array('ret' => 'success');
        } else {
            $resp = array('ret' => 'failed');
        }
        echo json_encode($resp);
    }

    public function getOrder($order_id) {
        $order = Order::wherePropertyId($this->user->id)->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        return view('home.work.property.order')
            ->with('order', $order);
    }
}
