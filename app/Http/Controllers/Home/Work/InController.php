<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/9
 * Time: 上午11:42
 */

namespace App\Http\Controllers\Home\Work;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use Icoming\Models\Code;
use Icoming\Models\Order;
use Illuminate\Http\Request;

class InController extends Controller {

    protected $user;

    public function __construct() {
        $this->user = session('user');
    }
    public function getOrders(Application $application) {
        return view('home.work.in.orders')
            ->with('js', $application->js)
            ->with('apis', [
                'scanQRCode'
            ]);
    }

    public function getAjaxOrders() {
        $per_page = 10;
        return Order::with('code')->whereInId($this->user->id)->paginate($per_page);
    }


    public function getGetOrderByCode($code) {
        $code = Code::whereCode($code)->first();
        if(!$code) {
            return ['code' => -1];
        }
        $order = $code->order()->whereNull('in_id')->whereStatus('入库途中')->first();
        if($order) {
            return ['code' => 0, 'data' => $order->id];
        }
        return ['code' => -1];
    }

    public function getCfmTransport($order_id) {
        $order = Order::find($order_id);
        if(!$order) {
            return redirect('/');
        }
        return view('home.work.in.cfm')
            ->with('order', $order);
    }

    public function postCfmTransport(Request $request, $order_id) {
        $order = Order::whereNull('in_id')->whereStatus('入库途中')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
//        $cfm_money = $request->input('cfm_money', $order->cfm_money);
//        if($cfm_money > $order->cfm_money || $cfm_money <= 0) {
//            return redirect()->back();
//        }
        $order->status = '已入库';
        $order->in_id = $this->user->id;
        $order->in_at = Carbon::now();
//        $order->cfm_money = $cfm_money;
        $order->save();
        return redirect('/work/in/orders');
    }
}