@extends('layout.weui')

@section('content')

    <div class="product-datas finish-order-container"  style="background-color:#fff;margin-top:0;padding:15px;padding-bottom: 0;">

        <div class="contacts">
            联系人&nbsp;&nbsp;&nbsp;：<span class="contacts-name">{{ $order->name }}</span>
        </div>

        <div class="contacts-phone">
            联系电话：<a class="contacts-number" href="tel:{{ $order->mobile }}">{{ $order->mobile }}</a>
        </div>

        <div class="recycle-product">
            回收物品：<span class="p-name">{{ $order->modelWithTrashed->classificationWithTrashed->name }}</span><span class="p-type">{{ $order->modelWithTrashed->name }}</span>
        </div>

        <div class="product-state">
            @inject('orderInfo', 'Icoming\Presenters\OrderInfoPresenter')
            当前状态：<span class="product-state">{{ $orderInfo->getStatus($order) }}</span>
        </div>

        <div class="return-coupon">
            @if($order->type == '协助下单')
                {{--忽略返现金额--}}
            @else
            返还优惠：<span class="coupon-detail">
                @if($order->type == '现金转账')现金红包￥{{ $order->money }}
                @else{{ $order->typeCoupon->coupon->name }}
                @endif<br><em>@if($order->type === '现金转账')回收入库后24小时内返还到微信零钱@else{{ $order->typeCoupon->coupon->remark }}@endif</em>
            </span>
            @endif
        </div>
        <div class="recycle-address">
            @inject('plotFullNamePresenter', 'Icoming\Presenters\Home\PlotFullNamePresenter')
            回收地址：<span class="address-detail">{{ $plotFullNamePresenter->getFullName($order->plot_id, $order->address) }}</span>
        </div>
        @if($order->remarks)
        <div class="recycle-address">
            备&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;注：<span class="address-detail">{{ $order->remarks }}</span>
        </div>
        @endif

        @if($new)
            <div class="recycle-address">
                <p class="add-order-tip" style="padding:5px 0; color: red;">2小时内工作人员将会与您联系确认。</p>
            </div>
        @else
            @if ($salesmen)
                <div class="recycle-address">
                    回收员&nbsp;&nbsp;&nbsp;：<span class="contacts-name">{{ $salesmen->nickname }}</span>
                    <!-- <p class="add-order-tip" style="padding:5px 0;">回收员:{{ $salesmen->nickname }}</p> -->
                </div>
                <div class="recycle-address">
                    回收电话：<span class="contacts-name">{{ $salesmen->mobile }}</span>
                    <!-- <p class="add-order-tip" style="padding:5px 0;">回收电话:{{ $salesmen->mobile }}</p> -->
                </div>
            @endif
        @endif
    </div>

    <div class="next-step" style="margin-top:30px;">
        <a href="/user/center" class="btn_primary">返回个人中心</a>
    </div>
    @if($order->type != '以旧换新券' && ($order->status == '已支付' || $order->status == '待支付'))
    <div class="next-step">
        <a href="/user/order-cancel/{{ $order->id }}" class="btn_primary" style="background-color:#fff;border: 1px solid #dedede;color:#999;">取消订单</a>
        <p class="add-order-tip" style="padding:5px 0;">
            派单前才能取消订单
        </p>
    </div>
    @endif
@endsection
