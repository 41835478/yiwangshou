<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>后台登录</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    {!! Html::style('/assets/bootstrap/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
    {!! Html::style('/assets/admin/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    {!! Html::style('/assets/admin/css/ionicons.min.css') !!}
    <!-- Theme style -->
    {!! Html::style('/assets/admin/css/AdminLTE.min.css') !!}
    <!-- iCheck -->
    {!! Html::style('/assets/admin/plugins/iCheck/flat/blue.css') !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!! Html::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') !!}
    {!! Html::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}
    <![endif]-->
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <a href="../../index2.html"><b>{{ config('app.name') }}</b>后台管理系统</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg"></p>

        {!! Form::open([
            'id' => 'loginForm',
        ]) !!}
        <div class="form-group has-feedback">
            <input type="username" class="form-control" placeholder="账号" name="username" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="密码" name="password" >
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-md-6 form-group ">
                <input type="text" class="form-control" placeholder="验证码" name="captcha" required>
            </div>
            <div class="col-md-6 form-group text-right">
                <img alt="验证码" id="captcha">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block">登录</button>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.0 -->
{!! Html::script('/assets/admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}
<!-- Bootstrap 3.3.6 -->
{!! Html::script('/assets/bootstrap/js/bootstrap.min.js') !!}
<!-- iCheck -->
{!! Html::script('/assets/admin/plugins/iCheck/icheck.min.js') !!}
<!-- form -->
{!! Html::script('/assets/admin/plugins/form/jquery.form.js') !!}
<script>
    function loadCaptcha($dom) {
        $dom.attr('src', '/captcha/default?' + Math.random())
    }
    $(function () {
        var captcha = $("#captcha")
        loadCaptcha(captcha)
        captcha.click(function() {
            loadCaptcha($(this))
        })
        var loginForm = $("#loginForm")
        loginForm.ajaxForm({
            error: function(e) {
                $(".help-block").fadeOut(function() {
                    $(this).remove()
                })
                loadCaptcha(captcha)
                var json = e.responseJSON
                for(var ip in json) {
                    (function(ip) {
                        var $ip = $('input[name='+ip+']')
                        $ip.parent().addClass('has-error')
                        $(json[ip]).each(function() {
                            var msg = $('<span class="help-block">'+this+'</span>')
                            $ip.after(msg.fadeIn())
                            setTimeout(function() {
                                msg.fadeOut(function() {
                                    $(this).remove()
                                })
                            }, 3000)
                        })
                        setTimeout(function() {
                            $ip.parent().removeClass('has-error')
                        }, 3000)
                    })(ip)
                }
            },
            success: function(json) {
                if(json.code === 0) {
                    window.location.href = json.url
                } else {
                    alert(json.message)
                }
                return false
            }
        })
    })
</script>
</body>
</html>
