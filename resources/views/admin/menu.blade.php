
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
        @inject('menuParser', 'Icoming\Presenters\Admin\MenuParser')
        <li class="header">{{ $admin->role }}</li>
        @foreach(config('admin-menu.role.' . $admin->role, []) as $menu)
            {!! $menuParser->parse($menu) !!}
        @endforeach
        <li class="header">通用</li>
        @foreach(config('admin-menu.global', []) as $menu)
            {!! $menuParser->parse($menu) !!}
        @endforeach
    </ul>
</section>
<!-- /.sidebar -->

@section('scripts')
    @parent
    <script>
        var curURI = '{{  $curURI or Request::url() }}'
        $(function() {
            $(".sidebar-menu a").each(function () {
                if($(this).attr('href') == curURI) {
                    $(this).parent().addClass('active').parents('.treeview').addClass('active')
                }
            })
        })
    </script>
@endsection
