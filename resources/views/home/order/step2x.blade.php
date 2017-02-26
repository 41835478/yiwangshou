@extends('layout.weui')

@section('content')
    {!! Form::open([
        'id' => 'form',
    ]) !!}
        <div class="weui_cells weui_cells_form form-container" style="background: #fff;">
            <div class="weui_cell form-item">
                <div class="weui_cell_bd weui_cell_primary">
                    {!! Form::text('name', $last_order ? $last_order->name : null, [
                        'class' => 'weui_input',
                        'placeholder' => '请输入联系人姓名',
                        'id' => 'name',
                    ]) !!}
                </div>
            </div>

            <div class="weui_cell form-item">
                <div class="weui_cell_bd weui_cell_primary">
                    {!! Form::number('mobile', $last_order ? $last_order->mobile: ($user->mobile ?: null), [
                        'class' => 'weui_input',
                        'pattern' => '[0-9]*',
                        'placeholder' => '请输入联系人手机号码',
                        'id' => 'mobile',
                    ]) !!}
                </div>
            </div>
            <div id="location">
            <div class="clearfix">
                <div class="weui_cells form-item fl mr16">
                    <div class="weui_cell weui_cell_select">
                        <div class="weui_cell_bd weui_cell_primary">
                            {!! Form::select('province', [
                                ($last_order ? $last_order->plot->province : '福建省') => ($last_order ? $last_order->plot->province : '福建省'),
                            ], $last_order ? $last_order->plot->province : '福建省', [
                                'class' => 'weui_select wd-select province',
                                'require' => '',
                                'id' => 'province',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="weui_cells form-item fl mr16">
                    <div class="weui_cell weui_cell_select">
                        <div class="weui_cell_bd weui_cell_primary">
                            {!! Form::select('city', [
                                ($last_order ? $last_order->plot->city : '福州市') => ($last_order ? $last_order->plot->city : '福州市'),
                            ], $last_order ? $last_order->plot->city : '福州市', [
                                'class' => 'weui_select wd-select city',
                                'require' => '',
                                'id' => 'city',
                            ]) !!}
                        </div>
                    </div>
                </div>
                <div class="weui_cells form-item fl">
                    <div class="weui_cell weui_cell_select">
                        <div class="weui_cell_bd weui_cell_primary">
                            {!! Form::select('area', [
                            ($last_order ? $last_order->plot->area : null) => ($last_order ? $last_order->plot->area : null),
                            ], $last_order ? $last_order->plot->area : null, [
                                'class' => 'weui_select wd-select area',
                                'require' => '',
                                'id' => 'area',
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="weui_cells form-item">
                <div class="weui_cell weui_cell_select">
                    <div class="weui_cell_bd weui_cell_primary">
                        {!! Form::select('plot_id', [
                        ($last_order ? $last_order->plot->id : null) => ($last_order ? $last_order->plot->id : null),
                        ], $last_order ? $last_order->plot->id : null, [
                            'class' => 'weui_select plot_id',
                            'placeholder' => '请选择小区',
                            'require' => '',
                            'id' => 'plot_id',
                        ]) !!}
                    </div>
                </div>
            </div>
            </div>
            <div class="weui_cell form-item">
                <div class="weui_cell_bd weui_cell_primary">
                    {!! Form::textarea('address', $last_order ? $last_order->address : null, [
                        'class' => 'weui_textarea',
                        'placeholder' => '请输入详细地址',
                        'rows' => 3,
                        'require' => '',
                        'id' => 'address',
                    ]) !!}
                </div>
            </div>
            <div class="weui_cell form-item">
                <div class="weui_cell_bd weui_cell_primary">
                    {!! Form::textarea('remarks', null, [
                        'class' => 'weui_textarea',
                        'placeholder' => '请输入备注信息(可选)',
                        'rows' => 3,
                        'require' => '',
                        'id' => 'remarks',
                    ]) !!}
                </div>
            </div>
            <div class="confirm-info">
                <div class="product-info">
                    <span>回收物品：</span>
                    <span class="r-name">{{ $type->classification->name }}</span>
                    <span class="r-type">
                        {{ $type->name }}
                        @if($is_unload)
                            (需要拆卸)
                        @endif
                    </span>
                </div>
                <div class="coopon-info">
                    @if($non_cost_coupon)
                        <span>无成本优惠券：</span>
                        <span class="r-price">{{ $non_cost_coupon->name }}(￥{{ $non_cost_coupon->value }})</span>
                    @endif
                </div>
                {{--<div class="coopon-info">--}}
                    {{--@if($coupon)--}}
                        {{--<span>优惠券：</span>--}}
                        {{--<span class="r-price">{{ $coupon->name }}(￥{{ $coupon->value }})</span>--}}
                    {{--@else--}}
                        {{--<span>现金返还：</span>--}}
                        {{--<span class="r-price">￥{{ $type->value }}</span>--}}
                    {{--@endif--}}
                {{--</div>--}}
            </div>
        </div>

        <div class="next-step">
            <a id="submit" class="btn_primary">提交</a>
        </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    {!! Html::script('/assets/admin/plugins/cxselect/jquery.cxselect.min.js') !!}
    {!! Html::script('/assets/home/js/jquery.form.js') !!}
    <script>
        $(function() {
            $("#location").cxSelect({
                url: '/order/plot-cxselect',
                selects: ['province', 'city', 'area', 'plot_id'],
                jsonValue: 'v',
            })
            var $form = $("#form")
            $("#submit").click(function() {
                if(!$("#name").val()) {
                    toast("请填写姓名")
                    return
                }
                if(!$("#mobile").val()) {
                    toast("请填写手机号")
                    return
                }
                if(!$("#plot_id").val()) {
                    toast("请选择小区")
                    return
                }
                if(!$("#address").val()) {
                    toast("请填写详细地址")
                    return
                }
                $form.ajaxSubmit(function(json) {
                    if(json.code == 0) {
                        window.location.replace('/user/order/' + json.data.id + '/1')
                    } else {
                        toast(json.message)
                    }
                })

//                $form.submit()
                return false
            })
        })
    </script>
@endsection    