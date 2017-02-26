@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header"></div>
                <div class="box-body">
                    {!! Form::model($adminModel, [
                        'class' => 'form-horizontal',
                        'autocomplete' => 'off',
                    ]) !!}
                    <div class="form-group">
                        {!! Form::label('账号', null, [
                            'class' => 'col-md-2 col-md-offset-2',
                        ]) !!}
                        <div class="col-md-6">
                            {!! Form::text('username', old('username'), [
                                'class' => 'form-control',
                                'id' => '账号',
                                $adminModel->id ? 'disabled': '' => '',
                            ]) !!}
                            @if($errors->getBag('default')->has('username'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('username'))  }}</span>
                            @endif
                        </div>
                    </div>
                    @if(!$adminModel->password)
                    <div class="form-group">
                        {!! Form::label('密码', null, [
                            'class' => 'col-md-2 col-md-offset-2',
                        ]) !!}
                        <div class="col-md-6">
                            {!! Form::password('password', [
                                'class' => 'form-control',
                                'id' => '密码',
                            ]) !!}
                            @if($errors->getBag('default')->has('v'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('password'))  }}</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <div class="form-group">
                        {!! Form::label('角色', null, [
                            'class' => 'col-md-2 col-md-offset-2',
                        ]) !!}
                        <div class="col-md-6">
                            {!! Form::select('role', [
                                // '超级管理员' => '超级管理员',
                                '小区管理员' => '小区管理员',
                                // '派单员' => '派单员',
                            ], old('role'), [
                                'class' => 'form-control',
                                'id' => '角色',
                            ]) !!}
                            @if($errors->getBag('default')->has('role'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('role'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('服务小区', null, [
                            'class' => 'col-md-2 col-md-offset-2',
                        ]) !!}
                        <div class="col-md-6">
                            {!! Form::select('plot_id', [
                                null => '默认',
                            ] + array_map(function($v) {
                                return $v['name'];
                            }, Icoming\Models\Plot::all(['name', 'id', ])->keyBy(function($item) {
                                return $item['id'];
                            })->toArray()), $plot->id ?: old('plot_id'), [
                                'class' => 'form-control',
                                'id' => '服务小区',
                            ]) !!}
                            @if($errors->getBag('default')->has('plot_id'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('plot_id'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" class="btn btn-primary">保存</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
