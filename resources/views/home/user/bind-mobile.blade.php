@extends('layout.weui')

@section('content')

    <div class="weui_cells weui_cells_form form-container">

        <div class="weui_cell form-item">
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" pattern="[0-9]*" placeholder="请输入手机号码" id="mobile">
            </div>
        </div>

        <div class="weui_cell form-item">
            <div class="weui_cell_bd weui_cell_primary">
                <input class="weui_input" type="number" pattern="[0-9]*" placeholder="请输入验证码" id="token">
            </div>
            <div class="weui_cell_hd"><a class="weui_label get-code" id="get_token_btn">获取验证码</a></div>
        </div>
    </div>

    <div class="next-step">
        <a href="javascript:;" class="btn_primary" id="blind-phone">确认绑定</a>
    </div>

@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            var $send_btn = $("#get_token_btn")
            var timer = null
            var startCount = (function() {
                return function(seconds) {
                    if(timer) {
                        clearInterval(timer)
                        timer = null
                    }
                    timer = setInterval(function() {
                        $send_btn.html("剩余" + seconds-- + '秒')
                        if(seconds === -1) {
                            clearInterval(timer)
                            timer = null
                            $send_btn.html("获取验证码")
                        }
                    }, 1000)
                }
            })()
            $send_btn.click(function() {
                if($(this).html() === '获取验证码') {
                    var mobile = $("#mobile").val()
                    if(mobile) {
                        $.getJSON('/user/send-token/' + mobile, function(json) {
                            console.log(json)
                            if(json.code == 0) {
                                startCount(120)
                                toast("已发送")
                            } else {
                                startCount(json.message)
                            }
                        })
                    } else {
                        toast('请填写正确的手机号')
                    }
                }
            })
            $("#blind-phone").click(function() {
                var mobile = $("#mobile").val()
                var token = $("#token").val()
                if(mobile && token) {
                    $.getJSON('/user/verify-token/' + mobile + '/' + token, function(json) {
                        console.log(json)
                        if(json.code == 0) {
                            window.location.href = '/user/center'
                        } else {
                            toast(json.message)
                        }
                    })
                } else {
                    toast('请填写正确的手机号或者验证码')
                }
            })
        })
    </script>
@endsection