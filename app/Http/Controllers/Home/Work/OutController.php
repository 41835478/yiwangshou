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

class OutController extends Controller {


    protected $user;

    public function __construct() {
        $this->user = session('user');
    }

    public function getOrders(Application $application) {
        return view('home.work.out.orders')
            ->with('js', $application->js)
            ->with('apis', [
                'scanQRCode'
            ]);
    }

    public function getAjaxTransport() {
        $per_page = 10;
        return Order::with('code')->whereOutId($this->user->id)->paginate($per_page);
    }

    public function getGetOrderByCode($code) {
        $code = Code::whereCode($code)->first();
        if(!$code) {
            return ['code' => -1];
        }
        $order = $code->order()->whereNull('out_id')->whereStatus('已入库')->first();
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
        return view('home.work.out.cfm')
            ->with('order', $order);
    }

    public function postCfmTransport($order_id) {
        $order = Order::whereNull('out_id')->whereStatus('已入库')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        $order->status = '已出库';
        $order->out_id = $this->user->id;
        $order->out_at = Carbon::now();
        $order->save();
        return redirect('/work/out/orders');
    }

}