@extends('layout.weui')

@section('content')

    <div class="header">
        <div class="header-nav">
            <a class="col-3-1 classification_type" data-type="家电回收"><span>家电回收</span></a>
            <!-- <a class="col-3-1 classification_type" data-type="纸皮回收" ><span>纸皮回收</span></a> -->
            <!-- <a class="col-3-1 classification_type" data-type="旧衣回收"><span>旧衣回收</span></a> -->
            <!--  ddl edit  方法添加在expired上-->
            <a class="col-3-1  expired" data-type="纸皮回收" ><span>纸皮回收</span></a>
            <a class="col-3-1  expired" data-type="旧衣回收"><span>旧衣回收</span></a>
        </div>
    </div>

    <div class="item-wrap clearfix">
        <ul id="product_container">
            @foreach($classifications as $classification)
                <li class="product" data-id="{{ $classification->id }}" data-type="{{ $classification->type }}">
                    <img class="product-image" src="{{ $classification->icon }}">
                    <div class="product-name">{{ $classification->name }}</div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="choose" id="choose_container">
        @foreach($classifications as $classification)
            <div class="type classification_{{ $classification->id }}"> <h2>选择{{ $classification->name }}型号</h2>
                @foreach($classification->types as $type)
                    <div class="type-item" data-id="{{ $type->id }}">{{ $type->name }}</div>
                @endforeach
            </div>
        @endforeach
    </div>

    <div class="coupon" id="coupon">
        @foreach($non_cost_coupons as $coupon)
            @if(!\Icoming\Models\Order::whereUserId($user->id)->whereCouponId($coupon->id)->first())

                <div class="coupon-item clearfix" data-id="{{ $coupon->id }}">
                    <div class="sk-img"> <i></i> </div><div class="q-type"><div class="q-name">
                            {{ $coupon->name }}
                        </div><div class="q-txt">
                            {{ $coupon->remark }}
                        </div>
                    </div>
                    <div class="q-money"><b class="semi-circle"></b><div class="q-price">
                            <div>
                                @if($coupon->value < 1)
                                    {{ $coupon->value * 100 }} <em>折</em>
                                @else
                                    <em>￥</em>{{ $coupon->value }}
                                @endif
                            </div>
                        <span>
                            {{ $coupon->ext_value > 0 ? "满{$coupon->ext_value}元可用" : '无限制条件' }}
                        </span>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <div class="is_unload">
        <span class="label">是否需要拆卸：</span>
        <span id="unload"><i class="checkbox"></i></span>
        <span class="label">&nbsp;是&nbsp;</span>
        <span class="active" id="no_unload"><i class="checkbox"></i></span>
        <span class="label">&nbsp;否&nbsp;</span>
    </div>
    @if(!$user->mobile)
        <div class="next-step">
            <a href="/user/bind-mobile" class="btn_primary disabled">未绑定手机号</a>
        </div>
    @elseif($user->trashed())
        <div class="next-step">
            <a class="btn_primary disabled">你已被冻结</a>
        </div>
    @else
        <div class="next-step">
            <a id="submit" class="btn_primary">下一步</a>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            var type_id = 0
            var coupon_id = 0
            var is_unload = 0

            // 加载分类和型号
            $(".classification_type").click(function() {
                var type = $(this).data('type')
                $(".classification_type").removeClass('active')
                $(this).addClass('active')
                $(".product").each(function() {
                    if($(this).data('type') === type) {
                        $(this).fadeIn()
                    } else {
                        $(this).hide()
                    }
                })
            })
            $(".product").click(function() {
                var id = $(this).data('id')
                $(".product").removeClass('active')
                $(this).addClass('active')
                $(".classification_" + id).fadeIn().siblings().hide()
            })
            $(".type-item").click(function() {
                $('.type-item').removeClass('active')
                $(this).addClass('active')
                type_id = $(this).data('id')
            })
            $(".classification_type").first().click()
            $(".product").first().click()
            $(".type-item").first().click()
            // 加载无成本购物券
            $(".coupon-item").click(function() {
                $(this).toggleClass('active').siblings().removeClass('active')
                coupon_id = 0
                if($(this).hasClass('active')) {
                    coupon_id = $(this).data('id')
                }
            })
            $(".is_unload").click(function() {
                is_unload = !is_unload
                if(is_unload == 0) {
                    $("#no_unload").addClass('active')
                    $("#unload").removeClass('active')
                } else {
                    $("#no_unload").removeClass('active')
                    $("#unload").addClass('active')
                }
            })
            $("#submit").click(function() {
                if(type_id <= 0) {
                    toast('请选择型号')
                    return
                }
                window.location.href = '/order/step2/' + type_id + '/' + is_unload + '/' + coupon_id
            })

            $(".expired").click(function(){
                alert("即将开放,敬请期待");
            })

        })



    </script>
@endsection
