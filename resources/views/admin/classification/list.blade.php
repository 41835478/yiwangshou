@extends('layout.admin')

@section('content')
    <div class="row">
        @foreach($classifications as $typeName => $cs)
        <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h1 class="box-title">
                        {{ $typeName }}
                    </h1>
                    <div class="box-tools pull-right">
                        <a href="/admin/classification/add/{{ $typeName }}" class="btn btn-box-tool"><i class="fa fa-plus"></i></a>
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body" id="data-body">
                    <div class="container-fluid">
                        <div class="row">
                            @foreach($cs as $classification)
                                <div class="col-md-12 classification-box">
                                    <div class="box box-warning">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">
                                                {{ $classification->name }}
                                            </h3>
                                            <div class="box-tools pull-right">
                                                <a href="/admin/classification/edit/{{ $classification->id }}" class="btn btn-box-tool"><i class="fa fa-edit"></i></a>
                                                {{--<button type="button" class="btn btn-box-tool classification-trash" data-classification_id="{{ $classification->id }}"><i class="fa fa-trash-o"></i></button>--}}
                                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                                            </div>
                                        </div>
                                        <div class="box-body">
                                            <div class="container-fluid">
                                                <div class="row">
                                                    @foreach($classification->types()->orderBy('sort', 'asc')->get() as $type)
                                                        <div class="col-md-2">
                                                            <div class="box box-primary type-box">
                                                                <div class="box-header with-border">
                                                                    <h3 class="box-title type-name" data-type_id="{{ $type->id }}">
                                                                        {{ $type->name }}
                                                                    </h3>
                                                                    <div class="box-tools pull-right">
                                                                        <a href="/admin/type/edit/{{ $type->id }}" class="btn btn-box-tool {{--type-remove-btn--}}" data-type_id="{{ $type->id }}"><i class="fa fa-edit"></i></a>
                                                                        {{--<a href="/admin/type/delete/{{ $type->id }}" class="btn btn-box-tool --}}{{--type-remove-btn--}}{{--" data-type_id="{{ $type->id }}"><i class="fa fa-times"></i></a>--}}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <div class="col-md-1">
                                                        <div class="box box-primary type-box">
                                                            <div class="box-header with-border text-center">
                                                                <h3 class="box-title text-center">
                                                                    <a href="/admin/type/add/{{ $classification->id }}" class="{{--add-type--}}" data-classification_id="{{ $classification->id }}"><i class="fa fa-plus"></i></a>
                                                                </h3>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {


            $("#data-body").on('click', '.classification-trash', function() {
                var classification_id = $(this).data('classification_id')
                var $btn = $(this)
                $.getJSON('/admin/classification/delete/' + classification_id, function(json) {
                    if(json.code == 0) {
                        $btn.parents('.classification-box').fadeOut(function() {
                            $(this).remove()
                        })
                    } else {
                        alert(json.message)
                    }
                })
            })

            $("#data-body").on('click', '.type-remove-btn', function() {
                var type_id = $(this).data('type_id')
                var $btn = $(this)
                $.getJSON('/admin/type/delete/' + type_id, function(json) {
                    if(json.code == 0) {
                        $btn.parents('.col-md-2').fadeOut(function() {
                            $(this).remove()
                        })
                    } else {
                        alert(json.message)
                    }
                })
            })

            $("#data-body").on('click', ".add-type", function() {
                var classification_id = $(this).data('classification_id')
                var name = window.prompt("请输入型号名称")
                var add_btn = $(this)
                if(name) {
                    $.getJSON('/admin/type/add', {
                        name: name,
                        classification_id: classification_id,
                    }, function(json) {
                        if(json.code == 0) {
                            var $col = add_btn.parents('.col-md-1')
                            $col.before($('<div class="col-md-2"><div class="box box-primary type-box"><div class="box-header with-border">' +
                                    '<h3 class="box-title">' + json.data.name + '</h3>' +
                                    '<div class="box-tools pull-right"><button type="button" class="btn btn-box-tool type-remove-btn" data-type_id="' + json.data.id + '"><i class="fa fa-times"></i></button></div>' +
                                    '</div></div></div>').fadeIn())
                        } else {
                            alert(json.message)
                        }
                    })
                } else {
                    alert("添加失败")
                }
                return false
            })

            $("#data-body").on('dblclick', '.type-name', function() {
                var type_id = $(this).data('type_id')
                var $btn = $(this)
                var new_name = window.prompt("请输入新的型号名")
                if(new_name) {
                    $.getJSON('/admin/type/edit/' + type_id, {
                        name: new_name,
                    }, function(json) {
                        if(json.code == 0) {
                            $btn.html(json.data.name)
                        } else {
                            alert(json.message)
                        }
                    })
                }
            })
        })
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .type-box {
            -webkit-transition: box-shadow 1s;
            -moz-transition: box-shadow 1s;
            -ms-transition: box-shadow 1s;
            -o-transition: box-shadow 1s;
            transition: box-shadow 1s;
            cursor: pointer;
        }
        .type-box:hover {
            box-shadow: 1px 2px 2px rgba(0,0,0,0.3);
        }
    </style>
@endsection