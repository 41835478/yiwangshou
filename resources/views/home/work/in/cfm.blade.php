@extends('layout.weui')

@section('content')

    <div class="product-datas">
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
        <div class="product-state">
            当前状态：<span class="product-state">
            @inject('orderPresenter', 'Icoming\Presenters\Home\OrderInfoPresenter')
                {{ $orderPresenter->getRecycleStatus($order) }}
        </span>
        </div>
        <div class="recycle-product">
            回收物品：
            <span class="p-name">{{ $order->cfmModel->classificationWithTrashed->name }}</span>
            <span class="p-type">{{ $order->cfmModel->name }}</span>
        </div>

        {!! Form::open([
            'id' => 'form'
        ]) !!}
        <div class="weui_cell form-item confirm-price">
            <div class="weui_cell_bd weui_cell_primary">
                <input disabled class="weui_input" type="number" id="cfm_money" name="cfm_money" value="{{ $order->cfm_money }}" step="0.01" max="{{ $order->money }}" placeholder="￥{{ $order->cfm_money }}">
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    @if($order->status == '入库途中')
    <div class="next-step">
        <a id="submit" class="btn_primary">确定入库</a>
    </div>
    @else
        <div class="next-step">
            <a href="/work/in/orders" class="btn_primary">返回我的作业单</a>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            $("#submit").click(function() {
                if($("#cfm_money").val() > {{ $order->cfm_money }}) {
                    toast("最大金额不超过{{ $order->cfm_money }}")
                    return false
                }
                if($("#cfm_money").val() < 1) {
                    toast("最小金额不低于1元")
                    return false
                }
                $("#form").submit()
            })
        })
    </script>
@endsection