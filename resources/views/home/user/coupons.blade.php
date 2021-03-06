@extends('layout.weui')

@section('content')
    <div class="coupon" id="coupons">
    </div>

    <div class="load-more" id="load-page">查看更多</div>
@endsection

@section('scripts')
    @parent
    {!! Html::script('/assets/home/js/paginator.js') !!}
    <script>
        loadPaginator({
            data_url: '/user/ajax-coupons',
            container: $("#coupons"),
            load_btn: $("#load-page"),
            format: function(obj) {
                    return $('<div class="coupon-item '+(obj.coupon_with_trashed.deleted_at ? 'failure' : '')+' clearfix"></div>')
                            .append($('<div class="q-type" style="left: 15px;"></div>')
                                    .append($('<div class="q-name">' + obj.coupon_with_trashed.name + '</div>'))
                                    .append($('<div class="q-txt">' + obj.coupon_with_trashed.remark + '</div>'))
                                    .append($('<div class="q-txt">' + (obj.coupon_with_trashed.deleted_at ? '已失效' : '')+ '</div>'))
                            )
                            .append($('<div class="q-money"></div>')
                                    .append($('<b class="semi-circle"></b>'))
                                    .append($('<div class="q-price"></div>')
                                            .append($('<div>'+(obj.coupon_with_trashed.value < 1 ? (obj.coupon_with_trashed.value * 100 + '<em>折</em>') : ('<em>￥</em>' + obj.coupon_with_trashed.value) )+'</div>'))
                                            .append($('<span>' + (obj.coupon_with_trashed.ext_value > 0 ? '满'+obj.coupon_with_trashed.ext_value+'元可用' : '无限制条件') + '</span>'))
                                    )
                            )

            },
        })
    </script>
@endsection