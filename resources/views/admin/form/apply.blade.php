@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>填写申请单</h3>
                </div>
                <div class="box-body">
                    {!! Form::open() !!}
                    <div class="form-group">
                        <span class="help-block">{{ current($errors->getBag('default')->get('error'))  }}</span>
                        {!! Form::label('请求备注') !!}
                        {!! Form::textarea('remark', null, [
                            'class' => 'form-control',
                            'id' => '请求备注',
                            'placeholder' => '派车申请的备注信息',
                        ]) !!}
                        <span class="help-block">{{ current($errors->getBag('default')->get('remark'))  }}</span>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success pull-right">发起申请</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection