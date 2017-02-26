@extends('layout.admin')

@section('content-title')
    <h1>查询</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    <table id="table" class="table table-bordered table-hover text-center ">
                        <thead>
                        <tr>
                            @foreach($thead as $th => $tar)
                                <th>{{ $th }}</th>
                            @endforeach
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    @parent
    {!! Html::script('/assets/admin/plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('/assets/admin/plugins/datatables/dataTables.bootstrap.min.js') !!}
    <script>
        var data_url = '{{ $data_url }}'
        $(function () {
            var table = $('#table').DataTable({
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
                    searchPlaceholder: '输入关键字',
                    zeroRecords: '没有记录搜索到',
                },
                ajax: data_url,
                columns: [
                    @foreach($thead as $th => $tar)
                    {
                        @if(is_array($tar))
                        data: null,
                        orderable: false,
                        searchable: false,
                        defaultContent: '' +
                            @foreach($tar as $b => $a)
                                '<button ' +
                                @foreach($a as $k => $v)
                        '{{ $k }}="{{ $v }}"'+
                                @endforeach
                        ' >{{ $b }}</button> ' +
                            @endforeach
                        '',
                        @else
                            data: '{{ $tar }}'
                        @endif
                    },
                    @endforeach
                ],
            })

            $('#table tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr')).data()
                window.location.href = $(this).data('url') + '/' + data.id
            } );
        })
    </script>
@endsection

@section('styles')
    @parent
    {!! Html::style('/assets/admin/plugins/datatables/dataTables.bootstrap.css') !!}
@endsection
