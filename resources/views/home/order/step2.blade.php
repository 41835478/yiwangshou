@extends('layout.weui')

@section('content')

    <div class="header">
        <div class="recycle-info">
            <span>回收物品：</span>
            <span class="r-name" id="classification_name">{{ $type->classification->name }}</span>
            <span class="r-type" id="type_name">{{ $type->name }}</span>
        </div>
    </div>

    <div class="coupon" id="coupon">
        @foreach($coupons as $typecoupon)
            <div class="coupon-item clearfix" data-id="{{ $typecoupon->id }}">
                <div class="sk-img"> <i></i> </div><div class="q-type"><div class="q-name">
                        {{ $typecoupon->coupon->name }}
                    </div><div class="q-txt">
                        {{ $typecoupon->coupon->remark }}
                    </div></div><div class="q-money"><b class="semi-circle"></b><div class="q-price">
                        <div><em>￥</em>{{ $typecoupon->coupon->value }}</div><span>
                            {{ $typecoupon->coupon->ext_value > 0 ? "满{$typecoupon->coupon->ext_value}元可用" : '无限制条件' }}
                        </span></div></div></div>
        @endforeach
            <div class="coupon-item clearfix" data-id="-{{ $type->id }}">
                <div class="sk-img"> <i></i> </div><div class="q-type"><div class="q-name">
                        现金返还
                    </div><div class="q-txt">
                        商品回收成功后以微信转账的形式返还
                    </div></div><div class="q-money"><b class="semi-circle"></b><div class="q-price">
                        <div><em>￥</em>{{ $type->value }}</div><span>
                            微信转账
                        </span></div></div></div>
    </div>

    <div class="next-step">
        <a id="submit" class="btn_primary">下一步</a>
    </div>

@endsection

@section('scripts')
    <script>
        $(function () {
            var type_coupon_id = 0

            $(".coupon-item").click(function() {
                $(this).addClass('active').siblings().removeClass('active')
                type_coupon_id = 0
                if($(this).hasClass('active')) {
                    type_coupon_id = $(this).data('id')
                }
            })
            $(".coupon-item").first().click()

            $("#submit").click(function() {
                if(type_coupon_id == 0) {
                    toast('请选择优惠类型')
                    return
                }
                window.location.replace('/order/step3/' + {{ $is_unload }} + '/' + {{ $coupon_id }} + '/' + type_coupon_id)
            })
        })
    </script>
@endsection