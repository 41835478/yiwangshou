@extends('layout.weui')

@section('content')

    {!! Form::open() !!}
    <div class="weui_cells weui_cells_form form-container" style="background-color: #fff;">
        {{--<div class="weui_cells form-item">--}}
            {{--<div class="weui_cell weui_cell_select">--}}
                {{--<div class="weui_cell_bd weui_cell_primary">--}}
                    {{--<select class="weui_select" name="select1">--}}
                        {{--<option value="" selected="true" disabled="true">原因</option>--}}
                        {{--<option value="1">原因1</option>--}}
                        {{--<option value="2">原因2</option>--}}
                        {{--<option value="3">原因3</option>--}}
                    {{--</select>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
        <div class="weui_cell form-item">
            <div class="weui_cell_bd weui_cell_primary">
                <textarea name="refused_reason" id="refused_reason" class="weui_textarea cannot-reason" placeholder="请填写无法回收理由" rows="3"></textarea>
            </div>
        </div>
    </div>

    <div class="next-step">
        <a class="btn_primary" id="submit">确认提交</a>
    </div>
    {!! Form::close() !!}
@endsection

@section('scripts')
    @parent
    <script>
        $(function() {
            $('#submit').click(function() {
                var refused_reason = $("#refused_reason").val()
                if(!refused_reason) {
                    toast('理由不能为空')
                    return
                }
                $("form").submit()
            })
        })
    </script>
@endsection
