@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>{{ $admin->username }} -> 协助下单</h3>
                </div>
                <div class="box-body">
                    {!! Form::open([
                        'class' => 'form-horizontal',
                    ]) !!}
                    <h4>回收选项</h4>
                    <div class="form-group" id="回收型号">
                        <div class="col-md-3">
                            {!! Form::label('回收类型') !!}
                            {!! Form::select('classification_type', [
                                '家电回收' => '家电回收',
                                old('classification_type') => old('classification_type'),
                            ], old('classification_type', '家电回收'), [
                                'class' => 'form-control classification_type',
                                'id' => '回收类型',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('classification_type'))  }}</span>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('分类') !!}
                            {!! Form::select('classification', [
                                old('classification') => old('classification'),
                                ], old('classification'), [
                                'class' => 'form-control classification',
                                'id' => '分类',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('classification'))  }}</span>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('型号') !!}
                            {!! Form::select('type_id', [
                                old('type_id') => old('type_id'),
                                ], old('type_id'), [
                                'class' => 'form-control type_id',
                                'id' => '型号',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('type_id'))  }}</span>
                        </div>
                        <div class="col-md-3">
                            {!! Form::label('拆卸选项') !!}
                            <div class="checkbox">
                                <label>
                                    {!! Form::checkbox('is_unload', old('is_unload'), old('is_unload'), [
                                        'id' => '拆卸选项',
                                    ]) !!}
                                    是否需要拆卸
                                </label>
                            </div>
                            <span class="help-block">{{ current($errors->getBag('default')->get('is_unload'))  }}</span>
                        </div>
                    </div>

                    <h4>用户信息</h4>
                    <div class="form-group">
                        <div class="col-md-6">
                            {!! Form::label('真实姓名') !!}
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'id' => '真实姓名',
                                'placeholder' => '用户的真实姓名',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('name'))  }}</span>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('联系方式') !!}
                            {!! Form::text('mobile', old('mobile'), [
                                'class' => 'form-control',
                                'id' => '联系方式',
                                'placeholder' => '用户的手机号码',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('mobile'))  }}</span>
                        </div>
                    </div>
                    <h4>用户住址</h4>
                    @if($admin->role == '超级管理员')
                        <div class="form-group" id="location">
                            <div class="col-md-3">
                                {!! Form::label('省') !!}
                                {!! Form::select('province', [
                                    '福建省' => '福建省',
                                    old('province') => old('province'),
                                ], old('province', '福建省'), [
                                    'class' => 'form-control province',
                                    'id' => '省',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('province'))  }}</span>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('市') !!}
                                {!! Form::select('city', [
                                    '福州市' => '福州市',
                                    old('city') => old('city'),
                                ], old('city', '福州市'), [
                                    'class' => 'form-control city',
                                    'id' => '市',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('city'))  }}</span>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('区') !!}
                                {!! Form::select('area', [
                                    old('area') => old('area'),
                                ], old('area'), [
                                    'class' => 'form-control area',
                                    'id' => '区',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('area'))  }}</span>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('小区名字') !!}
                                {!! Form::select('plot_id', [
                                    old('plot_id') => old('plot_id'),
                                ], old('plot_id'), [
                                    'class' => 'form-control plot_id',
                                    'id' => '小区名字',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('plot_id'))  }}</span>
                            </div>
                        </div>
                    @else
                        <div class="form-group" id="location">
                            <div class="col-md-3">
                                {!! Form::label('省') !!}
                                {!! Form::select('province', [
                                    $admin->plot->province => $admin->plot->province,
                                    old('province') => old('province'),
                                ], old('province', $admin->plot->province), [
                                    'class' => 'form-control province',
                                    'id' => '省',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('province'))  }}</span>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('市') !!}
                                {!! Form::select('city', [
                                    $admin->plot->city => $admin->plot->city,
                                    old('city') => old('city'),
                                ], old('city', $admin->plot->city), [
                                    'class' => 'form-control city',
                                    'id' => '市',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('city'))  }}</span>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('区') !!}
                                {!! Form::select('area', [
                                    $admin->plot->area => $admin->plot->area,
                                    old('area') => old('area'),
                                ], old('area', $admin->plot->area), [
                                    'class' => 'form-control area',
                                    'id' => '区',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('area'))  }}</span>
                            </div>
                            <div class="col-md-3">
                                {!! Form::label('小区名字') !!}
                                {!! Form::select('plot_id', [
                                    old('plot_id') => old('plot_id'),
                                ], old('plot_id'), [
                                    'class' => 'form-control plot_id',
                                    'id' => '小区名字',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('plot_id'))  }}</span>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <div class="col-md-12">
                            {!! Form::label('详细地址') !!}
                            {!! Form::text('address', old('address'), [
                                'class' => 'form-control',
                                'id' => '详细地址',
                                'placeholder' => '详细的小区门牌号',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('address'))  }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-success">确认下单</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    {!! Html::script('/assets/admin/plugins/cxselect/jquery.cxselect.min.js') !!}
    <script>
        $(function() {
            $('#回收型号').cxSelect({
                url: '/admin/order/assist/classification-cxselect',
                selects: ['classification_type', 'classification', 'type_id'],
                jsonValue: 'v',
            })
            $("#location").cxSelect({
                url: '/admin/order/assist/plot-cxselect',
                selects: ['province', 'city', 'area', 'plot_id'],
                jsonValue: 'v',
            })
        })
    </script>
@endsection