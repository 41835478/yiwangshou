@extends('layout.admin')

@section('content')
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h3>信息</h3>
                </div>
                <div class="box-body">
                    <table class="table table-bordered table-responsive">
                        <tr>
                            <td>申请人:</td>
                            <td>{{ $form->admin->username }}</td>
                            <td>申请时间:</td>
                            <td>{{ $form->created_at->diffForHumans() }}</td>
                            <td>申请状态:</td>
                            <td>{{ $form->refused_reason ? '已拒绝' : $form->status }}</td>
                        </tr>
                        <tr>
                            <td>备注:</td>
                            <td colspan="5">{{ $form->remark }}</td>
                        </tr>
                    </table>
                </div>
                @if($admin->role == '超级管理员')
                    <div class="box-header">
                        <h3>操作</h3>
                    </div>
                    <div class="box-footer text-center">
                        {!! Form::model($form, [
                            'url' => '/admin/form/refuse/' . $form->id,
                        ]) !!}
                        <div class="form-group">
                            {!! Form::label('拒绝理由') !!}
                            {!! Form::textarea('refused_reason', null, [
                                'class' => 'form-control',
                                'placeholder' => '拒绝理由',
                            ]) !!}
                        </div>
                        <button class="btn btn-danger" type="submit">拒绝</button>
                        <a class="btn btn-primary" href="/admin/form/agree/{{ $form->id }}">同意派车</a>
                        {!! Form::close() !!}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection