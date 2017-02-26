<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title or '易网收' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0" />
    {!! Html::style('assets/home/css/weui.css') !!}
    {!! Html::style('assets/home/css/main.css') !!}
    @yield('styles')

</head>
<body ontouchstart="" class="scan-container">
<div class="container">
    @yield('content')
</div>

<div id="toasts">

</div>
{!! Html::script('assets/home/js/jquery-1.10.2.js') !!}
<script>
    toast = (function() {
        var container = $("#toasts")
        return function(msg, timer) {
            var timer = timer || 1000
            var toast = $('<div> <div class="weui_mask_transparent"></div> <div class="weui_toast"> <i class="weui_icon_toast"></i> <p class="weui_toast_content">' + msg + '</p> </div> </div>')
            container.append(toast.fadeIn())
            console.log(container.children())
            setTimeout(function() {
                toast.fadeOut(function() {
                    toast.remove()
                })
            }, timer)
        }
    })()
</script>
@yield('scripts')
@if(isset($js))
    {!! Html::script('http://res.wx.qq.com/open/js/jweixin-1.0.0.js') !!}
    <script>
        wx.config({!! $js->config(isset($apis) ? $apis : [], false) !!})
    </script>

    @yield('wx')
@endif
</body>
</html>