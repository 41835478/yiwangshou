@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::open() !!}
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-3">
                            {!! Form::label('数量') !!}
                            {!! Form::number('count', 1, [
                                'class' => 'form-control',
                                'id' => '数量',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('count'))  }}</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success pull-right">申请</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

