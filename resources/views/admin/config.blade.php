@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            {!! Form::open() !!}
            @foreach($configs as $k1 => $config)
                <div class="box">
                    <div class="box-header">
                        <h3>{{ $lang[$k1] }}</h3>
                    </div>
                    <div class="box-body">
                        @foreach($config as $k2 => $col)
                            <div class="form-group row">
                                {!! Form::label("$k1.$k2", $lang["$k1.$k2"], [
                                    'class' => 'col-md-3 control-label'
                                ]) !!}
                                <div class="col-md-9">
                                    {!! Form::text("{$k1}[{$k2}]", $col, [
                                        'id' => "$k1.$k2",
                                        'class' => 'form-control',
                                        'placeholder' => $lang["$k1.$k2"],
                                    ]) !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary">保存</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
@endsection
