@extends('layout.admin')

@section('content')
    <div class="content">
        <div class="row box">
            {!! Form::model($plot, [
                'class' => 'form',
            ]) !!}
            <div class="box-body">
                <div class="form-group" id="location">
                    <div class="col-md-4">
                        {!! Form::label('省') !!}
                        {!! Form::select('province', [
                            '福建省' => '福建省',
                            $plot->province => $plot->province,
                        ], old('province', '福建省'), [
                            'class' => 'form-control province',
                            'id' => '省',
                        ]) !!}
                        <span class="help-block">{{ current($errors->getBag('default')->get('province'))  }}</span>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('市') !!}
                        {!! Form::select('city', [
                            '福州市' => '福州市',
                            $plot->city => $plot->city,
                        ], old('city', '福州市'), [
                            'class' => 'form-control city',
                            'id' => '市',
                        ]) !!}
                        <span class="help-block">{{ current($errors->getBag('default')->get('city'))  }}</span>
                    </div>
                    <div class="col-md-4">
                        {!! Form::label('区') !!}
                        {!! Form::select('area', [
                            $plot->area => $plot->area,
                        ], old('area'), [
                            'class' => 'form-control area',
                            'id' => '区',
                        ]) !!}
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-12">
                        {!! Form::label('小区名字') !!}
                        {!! Form::input('text', 'name', old('name'), [
                            'class' => 'form-control',
                            'id' => '小区名字',
                            'placeholder' => '小区名字',
                        ]) !!}
                        @if($errors->getBag('default')->has('name'))
                            <span class="help-block">{{ current($errors->getBag('default')->get('name'))  }}</span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="box-footer">
                <div class="form-group">
                    <input type="submit" value="保存" class="btn btn-success pull-right">
                </div>
            </div>
            {!! Form::close() !!}
        </div>

        @if($plot->id)
            <div class="row box">
                <div class="box-header">
                    <p>管理员</p>
                </div>
                <div class="box-body">
                    @forelse($plot->admins as $_admin)
                        <div class="col-md-2">
                            <div class="box box-primary admin-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-user"></i> {{ $_admin->username }}
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool admin-remove-btn" data-admin_id="{{ $_admin->id }}"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h3 class="text-center text-muted">没有管理员</h3>
                        @endforelse
                    <div class="col-md-1">
                        <div class="box box-primary admin-box">
                            <div class="box-header with-border text-center">
                                <h3 class="box-title text-center">
                                    <a href="/admin/admin/add/{{ $plot->id }}"><i class="fa fa-plus"></i></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row box">
                <div class="box-header">
                    <p>业务员</p>
                </div>
                <div class="box-body">
                    @forelse($plot->properties as $property)
                        <div class="col-md-2">
                            <div class="box box-primary admin-box">
                                <div class="box-header with-border">
                                    <h3 class="box-title">
                                        <i class="fa fa-user"></i> {{ $property->nickname }}
                                    </h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool admin-remove-btn"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3 class="text-center text-muted">没有业务员</h3>
                    @endforelse
                </div>
            </div>
        @endif
    </div>
@endsection

@section('scripts')
    @parent
    {!! Html::script('/assets/admin/plugins/cxselect/jquery.cxselect.min.js') !!}
    <script>
        $(function() {
            $.cxSelect.defaults.url = '/assets/admin/plugins/cxselect/cityData.min.json';
            $('#location').cxSelect({
                selects: ['province', 'city', 'area']
            });

            $(".admin-box").on('click', '.admin-remove-btn', function() {
                // 移除角色——未完成
                var admin_id = $(this).data('admin_id')
                var $btn = $(this)
                $.getJSON('/admin/admin/plot-null/' + admin_id, function(json) {
                    if(json.code == 0) {
                        $btn.parents('.admin-box').parent().fadeOut(function() {
                            $(this).remove()
                        })
                    } else {
                        alert(json.message)
                    }
                })
            })
        })
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .admin-box {
            -webkit-transition: box-shadow 1s;
            -moz-transition: box-shadow 1s;
            -ms-transition: box-shadow 1s;
            -o-transition: box-shadow 1s;
            transition: box-shadow 1s;
            cursor: pointer;
        }
        .admin-box:hover {
            box-shadow: 1px 2px 2px rgba(0,0,0,0.3);
        }
    </style>
@endsection