@extends('layout.weui')

@section('content')

    <div class="wait-container">
        <div class="wait-item">
            <div class="wait-states">
                <span class="p-name">{{ $order->model->classification->name }}</span>
                <span class="p-type">{{ $order->model->name }}</span>
                <div class="wait-state">
                    @inject('orderPresenter', 'Icoming\Presenters\Home\OrderInfoPresenter')
                    {{ $orderPresenter->getRecycleStatus($order) }}
                </div>
            </div>
            <div class="wait-datas">
                <div class="f-data">
                    <span class="contacts-name">{{ $order->name }}</span>
                    <span class="contacts-number">{{ $order->mobile }}</span>
                    <a href="tel:{{ $order->mobile }}"><img src="/assets/home/img/tel.png"></a>
                </div>
                <div class="recycle-address">
                    <span class="address-detail">
                        @inject('plotPresenter', 'Icoming\Presenters\Home\PlotFullNamePresenter')
                        {{ $plotPresenter->getFullName($order->plot_id, $order->address) }}
                    </span>
                </div>
                <div class="return-coupon">
                    <span class="coupon-detail">{{ $orderPresenter->getReward($order) }}</span>
                </div>
            </div>
            <div class="cannot-recycle">
                <a href="/work/property/recycle-cannot/{{ $order->id }}">无法回收？</a>
            </div>
        </div>
    </div>

    <div class="next-step">
        <a href="/work/property/recycle-step2/{{ $order->id }}" class="btn_primary">下一步</a>
    </div>
@endsection
