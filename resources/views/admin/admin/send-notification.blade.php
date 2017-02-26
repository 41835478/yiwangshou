@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h4>发送消息</h4>
                </div>
                <div class="box-body">
                    {!! Form::open([
                        'class' => 'form-horizontal',
                    ]) !!}
                    <div class="form-group">
                        {!! Form::label('来源', null, [
                            'class' => 'col-md-2 control-label',
                        ]) !!}
                        <div class="col-md-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="from" value="1" checked> {{ $admin->username }} (当前管理员用户)
                                </label>
                            </div>
                        </div>
                        @if($admin->role == '超级管理员')
                        <div class="col-md-offset-2 col-md-10">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="from" value="0"> 官方消息
                                </label>
                            </div>
                            <span class="help-block">{{ current($errors->getBag('default')->get('from_id'))  }}</span>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        {!! Form::label('模板', null, [
                            'class' => 'col-md-2 control-label'
                        ]) !!}
                        <div class="col-md-5">
                            {!! Form::select('view', [
                                old('view') => old('view'),
                                null => '不使用模板',
                            ] + $tpls->map(function($v) {
                                return $v[0];
                            })->toArray(), null, [
                                'class' => 'form-control',
                                'id' => '模板',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('view'))  }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        {!! Form::label('标题', null, [
                            'class' => 'col-md-2 control-label'
                        ]) !!}
                        <div class="col-md-5">
                            {!! Form::text('title', old('title'), [
                                'class' => 'form-control',
                                'id' => '标题',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('title'))  }}</span>
                        </div>
                    </div>
                    <div class="form-group container-fluid">
                        <div id="tpl_" class="row">
                            {!! Form::label('内容', null, [
                                'class' => 'col-md-2 control-label'
                            ]) !!}
                            <div class="col-md-10">
                                {!! Form::textarea('content', old('content'), [
                                    'class' => 'form-control',
                                    'id' => '内容',
                                ]) !!}
                                <span class="help-block">{{ current($errors->getBag('default')->get('content'))  }}</span>
                            </div>
                        </div>
                        @foreach($tpls as $name => $tpl)
                            <div id="tpl_{{ $name }}" class="row" style="display: none;">
                                {!! Form::label('模板插值', null, [
                                    'class' => 'col-md-2 control-label'
                                ]) !!}
                                @foreach($tpl[1]->getColumn() as $col_en => $col_zh)
                                    <div class="col-md-10">
                                        {!! Form::text($col_en, old($col_en), [
                                            'class' => 'form-control',
                                            'placeholder' => $col_zh,
                                        ]) !!}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-8">
                            <button type="submit" class="btn btn-primary">发送</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection


@section('scripts')
    <script>
        $(function () {
            $("#模板").change(function() {
                $("#tpl_" + $(this).val()).fadeIn(function() {
                    $(this).find('input,textarea').removeAttr('disabled')
                }).siblings().fadeOut(function() {
                    $(this).find('input,textarea').attr('disabled', 'disabled')
                })
            })
        })
    </script>
@endsection