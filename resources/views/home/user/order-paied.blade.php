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

    <div class="next-step" style="margin-top:30px;">
        <a href="/user/center" class="btn_primary">查看个人中心</a>
    </div>

@endsection
