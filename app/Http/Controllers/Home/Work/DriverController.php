<?php
/**
 * Created by PhpStorm.
 * User: zaygeegee
 * Date: 16/7/9
 * Time: 上午10:47
 */

namespace App\Http\Controllers\Home\Work;


use App\Http\Controllers\Controller;
use Carbon\Carbon;
use EasyWeChat\Foundation\Application;
use Icoming\Models\Code;
use Icoming\Models\Order;

class DriverController extends Controller {

    protected $user;

    public function __construct() {
        $this->user = session('user');
    }

    public function getTransport(Application $application) {
        return view('home.work.driver.transport')
            ->with('js', $application->js)
            ->with('apis', [
                'scanQRCode'
            ]);
    }

    public function getAjaxTransport() {
        $per_page = 10;
        return Order::with('code')->whereDriverId($this->user->id)->orderBy('id', 'desc')->paginate($per_page);
    }

    public function getGetOrderByCode($code) {
        $code = Code::whereCode($code)->first();
        if(!$code) {
            return ['code' => -1];
        }
        $order = $code->order()->whereNull('driver_id')->whereStatus('暂存')->first();
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
        return view('home.work.driver.cfm')
            ->with('order', $order);
    }

    public function postCfmTransport($order_id) {
        $order = Order::whereNull('driver_id')->whereStatus('暂存')->find($order_id);
        if(!$order) {
            return redirect('/');
        }
        $order->status = '入库途中';
        $order->driver_id = $this->user->id;
        $order->driver_at = Carbon::now();
        $order->save();
        return redirect('/work/driver/transport');
    }
}