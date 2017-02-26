<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $title or config('app.name') . '后台管理系统' }}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    {!! Html::style('/assets/bootstrap/css/bootstrap.min.css') !!}
    <!-- Font Awesome -->
    {!! Html::style('/assets/admin/css/font-awesome.min.css') !!}
    <!-- Ionicons -->
    {!! Html::style('/assets/admin/css/ionicons.min.css') !!}
    <!-- Theme style -->
    {!! Html::style('/assets/admin/css/AdminLTE.min.css') !!}
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    {!! Html::style('/assets/admin/css/skins/_all-skins.min.css') !!}
    <!-- iCheck -->
    {!! Html::style('/assets/admin/plugins/iCheck/flat/blue.css') !!}
    <!-- Morris chart -->
    {!! Html::style('/assets/admin/plugins/morris/morris.css') !!}
    <!-- jvectormap -->
    {!! Html::style('/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css') !!}
    <!-- Date Picker -->
    {!! Html::style('/assets/admin/plugins/datepicker/datepicker3.css') !!}
    <!-- Daterange picker -->
{!! Html::style('/assets/admin/plugins/daterangepicker/daterangepicker-bs3.css') !!}
{!! Html::style('/toastr/toastr.css') !!}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    {!! Html::script('https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js') !!}
    {!! Html::script('https://oss.maxcdn.com/respond/1.4.2/respond.min.js') !!}
    <![endif]-->
    @yield('styles')
    <style>
        #main-content {
            padding-top: 50px;
        }

        @media screen and (max-width: 768px) {
            #main-content {
                padding-top: 0px;
            }
        }
    </style>
</head>
<body class="hold-transition skin-black sidebar-mini">
<div class="wrapper">
    <div class="main-header">
        @include('admin.navbar')
    </div>
    <div class="main-sidebar">
        @include('admin.menu')
    </div>
    <div class="content-wrapper" id="main-content">
        <section class="content-header">
            {{-- <h1> --}}
            @yield('content-title')
            {{--
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Tables</a></li>
                <li class="active">Simple</li>
            </ol>
            --}}
            @yield('breadcrumb')
        </section>

        <section class="content">
            @yield('content')
        </section>
    </div>
    <div class="main-footer">
        @include('admin.footer')
    </div>
</div>

<!-- jQuery 2.2.0 -->
{!! Html::script('/assets/admin/plugins/jQuery/jQuery-2.2.0.min.js') !!}
<!-- jQuery UI 1.11.4 -->
{!! Html::script('/assets/admin/plugins/jQueryUI/jquery-ui.min.js') !!}
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
</script>
<!-- Bootstrap 3.3.6 -->
{!! Html::script('/assets/bootstrap/js/bootstrap.min.js') !!}
<!-- Morris.js charts -->
{!! Html::script('/assets/admin/plugins/raphael/raphael-min.js') !!}
{!! Html::script('/assets/admin/plugins/morris/morris.min.js') !!}
<!-- Sparkline -->
{!! Html::script('/assets/admin/plugins/sparkline/jquery.sparkline.min.js') !!}
<!-- jvectormap -->
{!! Html::script('/assets/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') !!}
{!! Html::script('/assets/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') !!}
<!-- jQuery Knob Chart -->
{!! Html::script('/assets/admin/plugins/knob/jquery.knob.js') !!}
<!-- daterangepicker -->
{!! Html::script('/assets/admin/plugins/moment/moment.min.js') !!}
{!! Html::script('/assets/admin/plugins/daterangepicker/daterangepicker.js') !!}
<!-- datepicker -->
{!! Html::script('/assets/admin/plugins/datepicker/bootstrap-datepicker.js') !!}
<!-- Slimscroll -->
{!! Html::script('/assets/admin/plugins/slimScroll/jquery.slimscroll.min.js') !!}
<!-- FastClick -->
{!! Html::script('/assets/admin/plugins/fastclick/fastclick.js') !!}
{!! Html::script('/toastr/toastr.js') !!}
<!-- AdminLTE App -->
{!! Html::script('/assets/admin/js/app.min.js') !!}
@yield('scripts')
</body>
</html>
