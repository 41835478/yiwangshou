
<!-- Logo -->
<a class="logo" data-toggle="offcanvas" role="button" >
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>|</b></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>{{ config('app.name') }}</b>后台管理系统</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-fixed-top">
    <!-- Sidebar toggle button-->
    <a class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <!-- Notifications: style can be found in dropdown.less -->
            @include('admin.notification')
            @include('admin.bell')
            <li>
                <a href="/admin/logout">
                    注销
                </a>
            </li>
        </ul>
    </div>
</nav>