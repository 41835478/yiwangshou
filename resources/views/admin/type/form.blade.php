@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <h4>基础信息</h4>
                    {!! Form::model($type) !!}
                    <div class="form-group">
                        <div class="col-md-4">
                            {!! Form::label('名称') !!}
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'id' => '名称',
                                'placeholder' => '名称',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('name'))  }}</span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('排序(越小越靠前)') !!}
                            {!! Form::number('sort', old('sort'), [
                                'class' => 'form-control',
                                'min' => '0',
                                'id' => '排序(越小越靠前)',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('sort'))  }}</span>
                        </div>
                        <div class="col-md-4">
                            {!! Form::label('价值') !!}
                            {!! Form::number('value', old('value'), [
                                'class' => 'form-control',
                                'id' => '价值',
                                'placeholder' => '将被做为线下返还和现金转账的金额',
                                'min' => 0.01,
                                'step' => 0.01,
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('value'))  }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success pull-right">保存</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-success">
                @if($type->id)
                    <div class="box-header">
                        <h4>优惠券关联</h4>
                    </div>
                    <div class="box-body">
                        <div class="container-fluid">
                            <div class="row">
                                @forelse($type->typeCoupons as $typeCoupon)
                                    <div class="col-md-2">
                                        <div class="box box-primary type-box">
                                            <div class="box-header with-border">
                                                <h3 class="box-title type-name" data-type_id="{{ $typeCoupon->id }}">
                                                    {{ $typeCoupon->coupon->name }}
                                                </h3>
                                                <div class="box-tools pull-right">
                                                    <a href="/admin/typecoupon/delete/{{ $typeCoupon->id }}" class="btn btn-box-tool {{--type-remove-btn--}}"><i class="fa fa-times"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <h3 class="text-muted text-center">没有任何优惠券关联</h3>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="box-footer">
                        <h5>添加关联</h5>
                        {!! Form::open([
                            'url' => '/admin/typecoupon/add/' . $type->id,
                            'class' => 'form-horizontal',
                        ]) !!}
                        <span class="help-block">{{ current($errors->getBag('default')->get('type_id'))  }}</span>
                        <div class="form-group">
                            {!! Form::label('优惠券', null, [
                                'class' => 'control-label col-md-2',
                            ]) !!}
                            <div class="col-md-8">
                                {!! Form::select('coupon_id',array_map(function($v) {
                                    return $v['name'] . '——' . $v['remark'];
                                }, Icoming\Models\Coupon::whereType('有成本券')->orWhere('type','=','以旧换新券')->get(['name', 'id', 'remark',])->keyBy(function($item) {
                                    return $item['id'];
                                })->toArray())
                                , old('coupon_id'), [
                                    'id' => '优惠券',
                                    'class' => 'form-control',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('coupon_id'))  }}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-success">添加</button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

