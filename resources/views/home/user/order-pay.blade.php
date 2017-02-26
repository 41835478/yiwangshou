@extends('layout.weui')

@section('content')

    <div class="product-datas finish-order-container" style="margin-bottom:0;">

        <div class="wait-item">

            <div class="wait-states">
                <span class="p-name">{{ $order->cfmModel->classificationWithTrashed->name }}</span>
                <span class="p-type">{{ $order->cfmModel->name }}</span>
                @inject('orderInfo', 'Icoming\Presenters\OrderInfoPresenter')
                <div class="wait-state">{{ $orderInfo->getStatus($order) }}</div>
            </div>

            <div class="wait-datas">
                <div class="f-data">
                    <span class="contacts-name">{{ $order->name }}</span>
                    <span style="color:#999;">{{ $order->mobile }}</span>
                </div>
                <div class="recycle-address">
                    @inject('plotFullNamePresenter', 'Icoming\Presenters\Home\PlotFullNamePresenter')
                    <span class="address-detail">{{ $plotFullNamePresenter->getFullName($order->plot_id, $order->address) }}</span>
                </div>
                <div class="return-coupon">
                    <span class="coupon-detail">
                        {{ $order->typeCoupon->coupon->name }}
                    </span>
                    <span class="coupon-detail">
                        {{ $order->typeCoupon->coupon->remark }}
                    </span>
                </div>
            </div>

            <div class="pay-money">
                预支付金额：<span>￥{{ $order->money }}</span>
            </div>

        </div>

    </div>

    <p class="add-order-tip">
        备注：预支付金额在回收成功后24小时内全额退还到微信零钱. 如果实际回收物品与所填写物品不一致. 中间差额将从预付金中抵扣.
    </p>


    @if($order->status == '待支付')
        <div class="next-step" style="margin-top:30px;">
            <a id="pay_btn" class="btn_primary">确认支付</a>
        </div>
    <div class="next-step">
        <a href="/user/order-cancel/{{ $order->id }}" class="btn_primary" style="background-color:#fff;border: 1px solid #dedede;color:#999;">取消订单</a>
    </div>
        @elseif($order->status == '已取消')
        <div class="next-step" style="margin-top:30px;">
            <a href="/user/center" class="btn_primary">返回个人中心</a>
        </div>
    @endif

@endsection

@section('scripts')
    @parent
    {!! Html::script('http://res.wx.qq.com/open/js/jweixin-1.0.0.js') !!}
@endsection

@section('wx')
    @parent
    @if($order->status == '待支付')
        <script>
            $(function() {
                wx.config(
                        {!! $js->config([
                            'chooseWXPay'
                        ]) !!}
                );
                wx.ready(function() {
                    $("#pay_btn").click(function() {
                        wx.chooseWXPay({
                            timestamp: {{ $jssdk_config['timestamp'] }},
                            nonceStr: '{{ $jssdk_config['nonceStr'] }}',
                            package: '{{ $jssdk_config['package'] }}',
                            signType: '{{ $jssdk_config['signType'] }}',
                            paySign: '{{ $jssdk_config['paySign'] }}', // 支付签名
                            success: function (res) {
                                // 支付成功后的回调函数
                                console.log(res)
                                window.location.reload()
                            }
                        });
                    })
                })
            })
        </script>
    @endif
@endsection