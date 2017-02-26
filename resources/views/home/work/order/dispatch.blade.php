<div class="product-datas finish-order-container">
    <div class="product-code">
        商品编号：<span class="product-num">{{ $order->code->code }}</span>
    </div>
    <div class="product-pics clearfix">
        <p>商品照片</p>
        <div class="product-pic">
            @foreach($order->orderImages as $img)
                <img src="{!! config('qiniu.domain').'/'.$img->image !!}" alt="">
            @endforeach
        </div>
    </div>

    <div class="contacts">
        联系人：<span class="contacts-name">{{ $order->name }}</span>
    </div>

    <div class="contacts-phone">
        联系电话：<span class="contacts-number">{{ $order->mobile }}</span>
    </div>

    <div class="recycle-product">
        回收物品：
        <span class="p-name">{{ $order->cfmModel->classificationWithTrashed->name }}</span>
        <span class="p-type">{{ $order->cfmModel->name }}</span>
    </div>

    <div class="product-state">
        当前状态：<span class="product-state">
            @inject('orderPresenter', 'Icoming\Presenters\Home\OrderInfoPresenter')
            {{ $orderPresenter->getRecycleStatus($order) }}
        </span>
    </div>

    <div class="return-coupon">
        返还优惠：<span class="coupon-detail">
            {{ $orderPresenter->getReward($order) }}<br>

            {{--@if($order->couponReward())--}}
                {{--<em>优惠券将在商品入库成功后发放</em>--}}
                {{--<em>可在个人中心-我的优惠券中查看</em>--}}
            {{--@else--}}
                {{--<em>回收入库后24小时内返还到微信零钱</em>--}}
            {{--@endif--}}
        </span>
    </div>

    <div class="recycle-address">
        回收地址：<span class="address-detail">
            @inject('plotPresenter', 'Icoming\Presenters\Home\PlotFullNamePresenter')
            {{ $plotPresenter->getFullName($order->plot_id, $order->address) }}
        </span>
    </div>

</div>
