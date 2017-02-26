@extends('layout.weui')
@section('content')
    @if($order->isRefused())
        {{--拒绝回收订单--}}
        @include('home.work.order.refused')
    @else
        {{--已经派发的订单--}}
        @include('home.work.order.dispatch')
    @endif
    <div class="next-step" style="margin-top:30px;">
        <a href="/user/center" class="btn_primary">返回个人中心</a>
    </div>
@endsection
