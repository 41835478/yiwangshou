@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="box">
            <div class="box-body">
                {!! Form::model($coupon, [
                    'class' => 'form-horizontal',
                ]) !!}
                
                <div class="form-group">
                    {!! Form::label('名字', null, [
                        'class' => 'col-md-2 control-label'
                    ]) !!}
                    <div class="col-md-8">
                        {!! Form::text('name', old('name'), [
                            'class' => 'form-control',
                            'id' => '名字',
                            'placeholder' => '名字',
                        ]) !!}
                        @if($errors->getBag('default')->has('name'))
                            <span class="help-block">{{ current($errors->getBag('default')->get('name'))  }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('备注', null, [
                        'class' => 'col-md-2 control-label'
                    ]) !!}
                    <div class="col-md-8">
                        {!! Form::text('remark', old('remark'), [
                            'class' => 'form-control',
                            'id' => '备注',
                            'placeholder' => '备注',
                        ]) !!}
                        @if($errors->getBag('default')->has('remark'))
                            <span class="help-block">{{ current($errors->getBag('default')->get('remark'))  }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('数值', null, [
                        'class' => 'col-md-2 control-label'
                    ]) !!}
                    <div class="col-md-8">
                        {!! Form::number('value', old('value'), [
                            'class' => 'form-control',
                            'id' => '数值',
                            'placeholder' => '数值',
                            'step' => '0.01',
                            'min' => 0,
                        ]) !!}
                        @if($errors->getBag('default')->has('value'))
                            <span class="help-block">{{ current($errors->getBag('default')->get('value'))  }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('满多少可用', null, [
                        'class' => 'col-md-2 control-label'
                    ]) !!}
                    <div class="col-md-8">
                        {!! Form::number('ext_value', old('ext_value'), [
                            'class' => 'form-control',
                            'id' => '满多少可用',
                            'placeholder' => '满多少可用',
                            'step' => '0.01',
                            'min' => 0,
                        ]) !!}
                        @if($errors->getBag('default')->has('ext_value'))
                            <span class="help-block">{{ current($errors->getBag('default')->get('ext_value'))  }}</span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('类型', null, [
                        'class' => 'col-md-2 control-label'
                    ]) !!}
                    <div class="col-md-8">
                        {!! Form::select('type', [
                            '有成本券' => '有成本券',
                            '无成本券' => '无成本券',
                            '以旧换新券' => '以旧换新券',
                        ], old('type'), [
                            'class' => 'form-control',
                            'id' => '类型',
                            'step' => '0.01',
                        ]) !!}
                        @if($errors->getBag('default')->has('type'))
                            <span class="help-block">{{ current($errors->getBag('default')->get('type'))  }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">保存</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    @if($coupon->type === '有成本券')
        <div class="row">
            <div class="box">
                <div class="box-header">
                    <h3>
                        优惠券编码
                        <button id="import_numbers" class="btn btn-primary pull-right" data-toggle="tooltip" data-placement="left" title="优惠券编码按行存放,仅支持utf-8编码(尽量不包含中文)。csv、xls格式: 每行一个编码, 首尾不能含有空格。json格式: 应该包含一个json数组。 如果格式错误整个文件的数据将都无法保存成功。">导入(支持csv, xls, xlsx, json格式)</button>
                        <form id="upload_form" action="/admin/coupon/import-numbers/{{ $coupon->id }}" style="display: none;" method="post" enctype="multipart/form-data">
                            <input type="file" name="file" id="upload_file">
                        </form>
                    </h3>
                </div>
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover text-center ">
                        <thead>
                        <tr>
                            <th>编码</th>
                            <th>关联订单</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('scripts')
    @parent
    <script>
        @if(session()->has('alert'))
            alert('{{ session()->get('alert') }}')
        @endif
    </script>
    @if($coupon->type === '有成本券')
    {!! Html::script('/assets/admin/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('/assets/admin/plugins/datatables/dataTables.bootstrap.min.js') !!}
    {!! Html::script('/assets/home/js/jquery.form.js') !!}
    <script>
        var data_url = '{{ $data_url or '' }}'
        $(function () {
            var table = $('#table').DataTable({
                autoWidth: false,
                order: [],
                language: {
                    paginate: {
                        first: '第一页',
                        last: '最后一页',
                        next: '下一页',
                        previous: '上一页',
                    },
                    emptyTable: '空数据',
                    info: '', // 当前页数 _PAGE_ / _PAGES_ start end total max
                    infoEmpty: '', // 没有记录可以显示
                    infoFiltered: '', // 过滤这么多条记录
                    "lengthMenu": '每页显示 <select>'+
                    '<option value="-1">全部</option>'+
                    '<option value="5">5</option>'+
                    '<option value="10">10</option>'+
                    '<option value="20">20</option>'+
                    '<option value="30">30</option>'+
                    '<option value="40">40</option>'+
                    '<option value="50">50</option>'+
                    '</select> 记录',
                    loadingRecords: '加载中...请稍后',
                    processing: '加载中...',
                    search: '搜索',
                    searchPlaceholder: '输入编号或者关联订单号',
                    zeroRecords: '没有记录搜索到',
                },
                ajax: data_url,
                columns: [
                    {
                        data: 'value',
                    },
                    {
                        data: 'order_number',
                    },
                    {
                        data: 'type',
                        searchable: false,
                    },
                ],
            })

            $("#import_numbers").click(function() {
                return $("#upload_file").click()
            })

            $("#upload_form").on('change', '#upload_file', function() {
                $("#upload_form").ajaxSubmit({
                    success: function(d) {
                        console.log(d)
                        if(d.code === 0) {
                            table.ajax.reload()
                        }
                        alert(d.message)
                        $("#upload_form").html('<input type="file" name="file" id="upload_file" value="">')
                    },
                    error: function() {
                        alert('上传文件时候发成错误。服务器发生错误, 请联系管理员解决')
                        $("#upload_form").html('<input type="file" name="file" id="upload_file" value="">')
                    }
                })
            })

        })

    </script>
    @endif
@endsection

@section('styles')
    @parent
    {!! Html::style('/assets/admin/plugins/datatables/dataTables.bootstrap.css') !!}
@endsection