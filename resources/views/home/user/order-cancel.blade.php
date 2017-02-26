@extends('layout.weui')

@section('content')

    <div class="weui_cells weui_cells_form form-container">
        <div class="weui_cell form-item">
            <div class="weui_cell_bd weui_cell_primary">
                {!! Form::open([
                    'url' => '/user/order-cancel'. ($order->isRecyclable() ? '' : '2') . '/' . $order->id,
                    'id' => 'form'
                ]) !!}
                <textarea name="cancel_reason" class="weui_textarea cancel-reason" placeholder="请填写取消原因" rows="3"></textarea>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="next-step">
        <a id="submit" class="btn_primary">确认提交</a>
    </div>
@endsection

@section('scripts')
    @parent

    <script>
        $(function() {

            $("#submit").click(function() {
                $("#form").submit()
                return false
            })

        })
    </script>
@endsection