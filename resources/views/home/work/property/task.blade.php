@extends('layout.weui')

@section('content')


    <div class="header">
        <div class="header-nav">
            <a class="col-3-1 active" data-target="ready"><span>待回收</span></a>
            <a class="col-3-1" data-target="temp"><span>已暂存</span></a>
            <a class="col-3-1" data-target="other"><span>其他</span></a>
        </div>
    </div>

    <div class="task-container">

        <div id="ready_container" >
            <div id="ready_box"></div>
            <div class="load-more" id="load-ready-btn">查看更多</div>
        </div>

        <div id="temp_container" style="display:none;">
            <div id="temp_box"></div>
            <div class="load-more" id="load-temp-btn">查看更多</div>
        </div>

        <div id="other_container" style="display:none;">
            <div id="other_box"></div>
            {{--<a class="task-item" href="failure_order.html">--}}
                {{--<div class="recycle-product">--}}
                    {{--回收物品：--}}
                    {{--<span class="p-name">空调</span>--}}
                    {{--<span class="p-type">2P</span>--}}
                {{--</div>--}}
                {{--<div class="recycle-coupon">--}}
                    {{--返还优惠：--}}
                    {{--<span class="p-coupon">现金50元</span>--}}
                {{--</div>--}}
                {{--<div class="task-time">--}}
                    {{--2016-06-19 15:30--}}
                {{--</div>--}}
                {{--<div class="task-state">无法回收</div>--}}
            {{--</a>--}}
            <div class="load-more" id="load-other-btn">查看更多</div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    {!! Html::script('/assets/home/js/paginator.js') !!}
    <script>
        $(function() {
            $(".header a").click(function() {
                $(this).addClass('active').siblings().removeClass('active')
                var target = $(this).data('target')
                $('#' + target + '_container').fadeIn().siblings().hide()
            })
            loadPaginator({
                data_url: '/work/property/ajax-task-ready',
                container: $("#ready_box"),
                load_btn: $("#load-ready-btn"),
                format: function(obj) {
                    return $('<a class="task-item" href="/work/property/recycle-step1/' + obj.id + '">')
                                    .append($('<div class="recycle-product"></div>')
                                            .append('回收物品:')
                                            .append('<span class="p-name">' + obj.model_with_trashed.classification_with_trashed.name + '</span>')
                                            .append('<span class="p-type">' + obj.model_with_trashed.name + '</span>')
                                    )
                                    .append($('<div class="recycle-coupon"></div>')
                                            .append('返还优惠:')
                                            .append('<span class="p-coupon">' + (obj.type == '现金转账' ? '现金' + obj.money : '优惠券') + '</span>')
                                    )
                                    .append($('<div class="recycle-coupon"></div>')
                                            .append('详细地址:')
                                            .append('<span class="p-coupon">' + obj.name + obj.address + '</span>')
                                    )
                                    .append('<div class="task-time">' + obj.orders_created_at + '</div>')
                }
            })
            loadPaginator({
                data_url: '/work/property/ajax-task-temp',
                container: $("#temp_box"),
                load_btn: $("#load-temp-btn"),
                format: function(obj) {
                    return $('<a class="task-item" href="/work/property/order/' + obj.id + '">')
                            .append($('<div class="recycle-product"></div>')
                                    .append('回收物品:')
                                    .append('<span class="p-name">' + obj.cfm_model.classification_with_trashed.name + '</span>')
                                    .append('<span class="p-type">' + obj.cfm_model.name + '</span>')
                            )
                            .append($('<div class="recycle-coupon"></div>')
                                    .append('返还优惠:')
                                    .append('<span class="p-coupon">' + (obj.type == '现金转账' ? '现金' + obj.money : '优惠券') + '</span>')
                            )
                            .append('<div class="task-time">' + obj.created_at + '</div>')
                }
            })
            loadPaginator({
                data_url: '/work/property/ajax-task-other',
                container: $("#other_box"),
                load_btn: $("#load-other-btn"),
                format: function(obj) {
                    return $('<a class="task-item" href="/work/property/order/' + obj.id + '">')
                            .append($('<div class="recycle-product"></div>')
                                    .append('回收物品:')
                                    .append('<span class="p-name">' + obj.model_with_trashed.classification_with_trashed.name + '</span>')
                                    .append('<span class="p-type">' + obj.model_with_trashed.name + '</span>')
                            )
                            .append($('<div class="recycle-coupon"></div>')
                                    .append('返还优惠:')
                                    .append('<span class="p-coupon">' + (obj.type == '现金转账' ? '现金' + obj.money : '优惠券') + '</span>')
                            )
                            .append('<div class="task-time">' + obj.created_at + '</div>')
                }
            })

            @if($user->trashed())
                $("body").on('click', '.task-item', function() {
                    toast("你已经被冻结,无法操作")
                    return false
                })
            @endif

        })
    </script>
@endsection
