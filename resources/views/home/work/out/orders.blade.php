@extends('layout.weui')

@section('content')

    <div class="scan-code">
        <a id="scan_btn" class="btn_primary">扫描二维码</a>
        <p class="tran-num">您已出库<span id="orders_count">0</span>件物品</p>
    </div>

    <div class="tran-items">
        <div class="weui_cells weui_cells_access" id="transport_container">
        </div>
    </div>

    <div class="load-more" id="load_btn">查看更多</div>
@endsection


@section('scripts')
    @parent
    {!! Html::script('/assets/home/js/paginator.js') !!}
    <script>
        $(function () {
            loadPaginator({
                data_url: '/work/out/ajax-transport',
                container: $("#transport_container"),
                load_btn: $("#load_btn"),
                format: function(obj) {
                    return $('<a class="weui_cell usr-item" href="/work/out/cfm-transport/' + obj.id + '" id="' + obj.code.code + '"></a>')
                                    .append('<div class="weui_cell_bd weui_cell_primary"><p>'+obj.code.code+'</p></div>')

                },
                after: function(data) {
                    $("#orders_count").html(data.total)
                }
            })
        })
    </script>
@endsection

@section('wx')
    @parent
    <script>

        wx.ready(function () {
            $("#scan_btn").click(function () {
                @if($user->trashed())
                    toast("你已经被冻结,无法操作")
                    return false
                @endif
                wx.scanQRCode({
                    needResult: 1,
                    success: function(res) {
                        var result = res.resultStr
                        // 根据code  取得orderid,
//                        result = '123123123123123123'
                        // 判断result 是否存在列表
                        if($('#' + result).length >= 1) {
                            toast('已扫描过的商品')
                            return
                        }
                        $.getJSON('/work/out/get-order-by-code/' + result,  function(json) {
                            if(json.code === 0) {
                                window.location.href = '/work/out/cfm-transport/' + json.data
                            } else {
                                toast('不存在的商品编号')
                            }
                        })
                    }
                })
            })
        })
    </script>
@endsection