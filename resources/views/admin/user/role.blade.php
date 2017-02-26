@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <p>基本信息</p>
                </div>
                <div class="box-body">
                    {!! Form::model($user, [
                        'class' => 'form-horizontal',
                    ]) !!}
                    <div class="form-group">
                        <label class="col-md-2 control-label">微信openid</label>
                        <div class="col-md-10">
                            {!! Form::text('open_id', null, [
                                'class' => 'form-control',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-2 control-label">昵称</label>
                        <div class="col-md-10">
                            {!! Form::text('nickname', null, [
                                'class' => 'form-control',
                                'disabled' => 'disabled',
                            ]) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="role" class="col-md-2 control-label">角色</label>
                        <div class="col-md-10">
                            {!! Form::select('role', [
                                '默认' => '默认',
                                '司机' => '司机',
                                '业务员' => '业务员',
                                '入库员' => '入库员',
                                '出库员' => '出库员',
                            ], null, [
                                'class' => 'form-control',
                                'id' => 'role',
                            ]) !!}
                            @if($errors->getBag('default')->has('role'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('role'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="plot_id" class="col-md-2 control-label">所属小区</label>
                        <div class="col-md-10">
                            {!! Form::select('plot_id', [
                                null => '默认',
                            ] + array_map(function($v) {
                                return $v['name'];
                            }, Icoming\Models\Plot::all(['name', 'id', ])->keyBy(function($item) {
                                return $item['id'];
                            })->toArray()), null, [
                                'class' => 'form-control',
                                'id' => 'plot_id',
                            ]) !!}
                            @if($errors->getBag('default')->has('plot_id'))
                                <span class="help-block">{{ current($errors->getBag('default')->get('plot_id'))  }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-offset-2 col-md-offset-10">
                            {!! Form::submit('提交', [
                                'class' => 'btn btn-primary'
                            ]) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
            @if($user->role === '业务员')
            <div class="box">
                <div class="box-header">
                    <p>服务的小区(高亮则表示正在服务)</p>
                </div>
                <div class="box-body">
                    @forelse(\Icoming\Models\Plot::get() as $plot)
                        <div class="col-md-2">
                            <div class="box {{ $user->plots->contains($plot) ? 'box-primary' : '' }} admin-box toggle_serve" data-plot_name="{{ $plot->name }}" data-plot_id="{{ $plot->id }}" style="cursor: pointer">
                                <div class="box-header with-border text-center">
                                    <h3 class="box-title text-center">
                                        <i class="fa fa-home"> {{ $plot->name }} </i>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    @empty
                        <h3 class="text-center text-muted">系统中没有小区信息</h3>
                    @endforelse
                </div>
            </div>
            @endif
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            var user_id = {{ $user->id }}
            $(".toggle_serve").click(function() {
                var self = $(this)
                var plot_id = $(this).data('plot_id')
                $.getJSON('/admin/user/serve-plot/' + user_id + '/' + plot_id, function(json) {
                    if(json.data === 0) {
                        toastr.warning('当前业务员取消服务小区:' + self.data('plot_name'))
                        self.removeClass('box-primary')
                    } else {
                        toastr.success('当前业务员新增服务小区:' + self.data('plot_name'))
                        self.addClass('box-primary')
                    }
                })
            })
        })
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .box-primary .fa {
            color: #3c8dbc;
        }
    </style>
@endsection
