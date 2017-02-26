@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h4>订单基础信息</h4>
                </div>
                <div class="box-body table-responsive">
                    <table class="table table-responsive table-bordered">
                        <tr>
                            <th>订单编号</th>
                            <td>{{ $order->number }}</td>
                            <th>订单类型</th>
                            <td>{{ $order->type }}</td>
                            <th>订单状态</th>
                            <td>
                                @if($order->type == '以旧换新券')
                                    {{ $order->status }}
                                @elseif($order->status == '已支付')
                                    等待物业上门回收
                                @else
                                    {{ $order->status }}
                                @endif
                            </td>
                            <th>订单价值</th>
                            <td>{{ $order->money }}</td>
                        </tr>
                        <tr>
                            <th>是否需要拆卸</th>
                            <td>{{ $order->is_unload ? '是' : '否' }}</td>
                            <th>商品型号</th>
                            <td><a href="/admin/type/edit/{{ $order->modelWithTrashed->id }}">{{ $order->modelWithTrashed->classificationWithTrashed->name.$order->modelWithTrashed->name }}</a></td>
                            <th>微信用户</th>
                            <td>
                                @if($order->user)
                                    <a href="/admin/user/role/{{ $order->userWithTrashed->id }}">{{ $order->userWithTrashed->nickname }}</a>
                                @else
                                    无绑定用户
                                @endif
                            </td>
                            <th>创建时间</th>
                            <td>{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                            <th>真实姓名</th>
                            <td>{{ $order->name }}</td>
                            <th>联系方式</th>
                            <td>{{ $order->mobile }}</td>
                            <th>小区名称</th>
                            <td>
                                <a href="/admin/plot/edit/{{ $order->plotWithTrashed->id }}">{{ $order->plotWithTrashed->name }}</a>
                                {{--@if($order->plot)--}}
                                    {{--<a href="/admin/plot/edit/{{ $order->plot->id }}">{{ $order->plot->name }}</a>--}}
                                {{--@else--}}
                                    {{--未绑定小区--}}
                                {{--@endif--}}
                            </td>
                            <th>详细地址</th>
                            <td>{{ $order->address }}</td>
                        </tr>
                        @if($order->remarks)
                        <tr>
                            <th>用户备注</th>
                            <td colspan="7">{{ $order->remarks }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>



        <div class="col-md-12">
            <ul class="timeline">
                <li class="time-label">
                  <span class="bg-blue">
                    {{ $order->created_at }}
                  </span>
                </li>
                <li>
                    <i class="fa fa-user bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fa fa-clock-o"></i> {{ $order->created_at->diffForHumans() }}</span>
                        <h3 class="timeline-header no-border">
                            @if($order->type == '协助下单')
                                <a>{{ $order->name }}</a> 预约了回收订单
                            @else
                                <a>{{ $order->userWithTrashed->nickname }}</a> 预约了回收订单
                            @endif
                        </h3>
                    </div>
                </li>

                {{--是否取消--}}
                @if($order->isCanceled())
                    <li>
                        <i class="fa fa-user"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fa fa-clock-o"></i> {{ $order->updated_at->diffForHumans() }}</span>
                            <h3 class="timeline-header no-border"><a>{{ $order->userWithTrashed->nickname }}</a> 取消了订单(取消原因:{{ $order->cancel_reason }})</h3>
                        </div>
                    </li>
                @else
                    @if($order->wechat_number)
                        <li>
                            <i class="fa fa-user bg-aqua"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ (new \Carbon\Carbon($order->wechat_paid_at))->diffForHumans() }}</span>
                                <h3 class="timeline-header no-border"><a>{{ $order->userWithTrashed->nickname }}</a> 支付订单(微信订单号:{{ $order->wechat_number }})</h3>

                            </div>
                        </li>
                    @endif
                    @if($order->isRefused())
                        <li>
                            <i class="fa fa-user bg-red"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fa fa-clock-o"></i> {{ (new \Carbon\Carbon($order->property_at))->diffForHumans() }}</span>
                                <h3 class="timeline-header no-border">业务员 <a>{{ $order->property->nickname }}</a> 拒绝回收订单(拒绝原因:{{ $order->refused_reason }})</h3>
                            </div>
                        </li>
                    @else
                        @if($order->property_id)
                            {{--已暂存--}}
                            <li>
                                <i class="fa fa-user bg-yellow"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ (new \Carbon\Carbon($order->property_at))->diffForHumans() }}</span>
                                    <h3 class="timeline-header no-border">业务员 <a>{{ $order->property->nickname }}:{{ $order->property->mobile }}</a> 完成派单(商品编号:{{ $order->code->code }}, 确认型号:<a href="/admin/type/edit/{{ $order->cfmModel->id }}">{{ $order->cfmModel->classificationWithTrashed->name.$order->cfmModel->name }})</a></h3>
                                    <div class="timeline-body">
                                        @foreach($order->orderImages as $image)
                                            <img width="100" height="150" src="{!! config('qiniu.domain').'/'.$image->image !!}" class="margin">
                                        @endforeach
                                    </div>
                                </div>
                            </li>
                        @endif
                        @if($order->driver_id)
                            {{--正在运输中--}}
                            <li>
                                <i class="fa fa-user bg-purple"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ (new \Carbon\Carbon($order->driver_at))->diffForHumans() }}</span>
                                    <h3 class="timeline-header no-border">司机 <a>{{ $order->driver->nickname }}</a> 正在运输中</h3>
                                </div>
                            </li>
                        @endif
                        @if($order->in_id)
                            {{--已入库--}}
                            <li>
                                <i class="fa fa-user bg-purple"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ (new \Carbon\Carbon($order->in_at))->diffForHumans() }}</span>
                                    <h3 class="timeline-header no-border">入库员 <a>{{ $order->in->nickname }}</a> 操作入库</h3>
                                </div>
                            </li>
                        @endif
                        @if($order->out_id)
                            <li>
                                <i class="fa fa-user bg-purple"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fa fa-clock-o"></i> {{ (new \Carbon\Carbon($order->out_at))->diffForHumans() }}</span>
                                    <h3 class="timeline-header no-border">出库员 <a>{{ $order->out->nickname }}</a> 操作出库</h3>
                                </div>
                            </li>
                        @endif
                    @endif
                @endif
            </ul>
        </div>

        @if($admin->role == '超级管理员')
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header">
                        <h4>奖励发放(奖励发放金额不低于1元)</h4>
                    </div>
                    <div class="box-body table-responsive">
                        @if($order->is_paid)
                            <h1 class="text-muted text-center">奖励已发放
                                @if($order->type == '有成本券')
                                    (优惠券码:{{ $order->coupon_number }})
                                @else
                                    (¥{{ $order->cfm_money }})
                                @endif
                            </h1>
                        @elseif($order->status != '已入库' && $order->status != '暂存' && $order->status != '入库途中'  && $order->status != '已出库')
                            <h2 class="text-muted text-center">目前无法发放奖励</h2>
                            <p class="text-muted text-center">商品未入库</p>
                        @else
                            {!! Form::open([
                                'url' => '/admin/order/pay/' . $order->id,
                            ]) !!}
                            @if($order->type == '有成本券')
                                {!! Form::text('coupon_number', '', [
                                    'placeholder' => '请输入发放的券号, 为空则自动从优惠券编码列表发放一个',
                                    'class' => 'form-control',
                                ]) !!}
                            @else
                                {!! Form::number('cfm_money', $order->cfm_money, [
                                    'step' => 0.01,
                                    'min' => 1.0,
                                    'placeholder' => '请输入发放金额, 不低于1元',
                                    'class' => 'form-control',
                                    'required',
                                    // 'max' => $order->money,
                                ]) !!}
                            @endif
                            {!! Form::submit('确认发放', [
                                'class' => 'btn btn-success'
                            ]) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        @if(session()->has('alert'))
            alert('{{ session()->get('alert') }}')
        @endif
    </script>
@endsection
