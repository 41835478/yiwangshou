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
    </div>
    @if($order->status == '已入库')
        <div class="next-step">
            <a id="submit" class="btn_primary">确定出库</a>
        </div>
    @else
        <div class="next-step">
            <a href="/work/out/orders" class="btn_primary">返回我的作业单</a>
        </div>
    @endif
    {!! Form::open([
        'id' => 'form'
    ]) !!}
    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            $("#submit").click(function() {
                $("#form").submit()
            })
        })
    </script>
@endsection