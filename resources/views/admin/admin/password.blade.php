@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>修改密码</h3>
                </div>
                <div class="box-body">
                    {!! Form::open([
                        'class' => 'form-horizontal'
                    ]) !!}
                    <div class="form-group">
                        {!! Form::label('原密码', null, [
                            'class' => 'col-md-3 control-label'
                        ]) !!}
                        <div class="col-md-8">
                            {!! Form::password('password', [
                                'class' => 'form-control',
                                'id' => '原密码',
                            ]) !!}
                            @if($errors->getBag('default')->has('password'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('password'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('新密码', null, [
                            'class' => 'col-md-3 control-label'
                        ]) !!}
                        <div class="col-md-8">
                            {!! Form::password('new_password', [
                                'class' => 'form-control',
                                'id' => '新密码',
                            ]) !!}
                            @if($errors->getBag('default')->has('new_password'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('new_password'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('确认新密码', null, [
                            'class' => 'col-md-3 control-label'
                        ]) !!}
                        <div class="col-md-8">
                            {!! Form::password('new_password_confirmation', [
                                'class' => 'form-control',
                                'id' => '确认新密码',
                            ]) !!}
                            @if($errors->getBag('default')->has('new_password_confirmation'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('new_password_confirmation'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-8">
                            <button type="submit" class="btn btn-primary">确定修改</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>    
@endsection