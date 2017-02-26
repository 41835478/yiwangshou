@extends('layout.weui')

@section('content')
    <div class="usr-header clearfix">
        <div class="usr-avatar">
            <img id="portrait" src="{{ $user->portrait }}" >
        </div>
        <div class="usr-info fl">
            <div class="usr-name" id="nickname">{{ $user->nickname }} {{ $user->trashed() ? '(已冻结)' : '' }}</div>
            <div class="usr-phone" id="mobile"><span></span>{{ $user->mobile ?: '未绑定' }}</div>
        </div>
        <div class="usr-type fr" id="role">{{ $user->role == '默认' ? '普通用户' : $user->role}}</div>
    </div>

    <div class="my-container">
        <div class="weui_cells weui_cells_access">
            <a href="/user/orders" class="weui_cell usr-item">
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/order.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>我的订单</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
            <a href="/user/coupons" class="weui_cell usr-item">
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/quan.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>我的优惠券</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
            <a href="/work/property/task" class="weui_cell usr-item" id="cell_user_work" {!! $user->role == '业务员' ? '' : 'style="display: none;"' !!}>
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/task.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>我的作业单</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
            <a href="/work/driver/transport" class="weui_cell usr-item" id="cell_user_transport" {!! $user->role == '司机' ? '' : 'style="display: none;"' !!}>
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/tran_ticket.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>我的运输单</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
            <a href="/user/bind-mobile" class="weui_cell usr-item" id="cell_bind_mobile" {!! $user->mobile ? 'style="display: none;"' : '' !!}>
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/blind_phone.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>绑定手机</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
            <a href="/work/in/orders" class="weui_cell usr-item" id="cell_in" {!! $user->role == '入库员' ? '' : 'style="display: none;"' !!}>
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/in.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>入库</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
            <a href="/work/out/orders" class="weui_cell usr-item" id="cell_out" {!! $user->role == '出库员' ? '' : 'style="display: none;"' !!}>
                <div class="weui_cell_hd"><img src="/assets/home/img/usr/out.png" alt="" style="width:24px;margin-right:15px;display:block"></div>
                <div class="weui_cell_bd weui_cell_primary">
                    <p>出库</p>
                </div>
                <div class="weui_cell_ft"></div>
            </a>
        </div>

    </div>

@endsection