@extends('layout.admin')

@section('content')
    <h3> 所有图片 </h3>
    <div class="row">
        {{-- 这里显示所有的图片 --}}
        @forelse(File::allFiles(public_path('assets/home/img/icon')) as $file)
            <div class="col-md-1 img_select" data-src="{{ $file->getFileName() }}">
                <img src="/assets/home/img/icon/{{ $file->getFileName() }}" class="img img-responsive">
            </div>
        @empty
            <h3 class="text-muted text-center">
                没有图片
            </h3>
        @endforelse
    </div>
    <h3> 图片上传 </h3>
    <div class="row">
        {{--这里是上传的表单--}}
        <div class="col-md-12">
            <div class="upload_main">
                <div class="upload_choose">
                    <input id="fileInput" type="file" size="30" name="files[]" multiple />
                    {{--<span id="fileDragArea" class="upload_drag_area">或者将图片拖到此处</span>--}}
                </div>
                <div id="preview" class="upload_preview"></div>
            </div>
            <div class="upload_submit">
                <button type="button" id="fileSubmit" class="upload_submit_btn">确认上传图片</button>
            </div>
            <div id="uploadInf" class="upload_inf"></div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    {!! Html::script('/assets/home/js/md5.js') !!}
    {!! Html::script('/assets/home/js/zxxFile.js') !!}
    <script>
        $(function() {
            $('.img_select').click(function() {
                var self = $(this)
                if(confirm('是否要删除这个图标')) {
                    $.getJSON('/admin/classification/icon/del/' + $(this).data('src'), function(json) {
                        if(json.code == 0) {
                            self.fadeOut(function() {
                                $(this).remove()
                            })
                        } else {
                            alert(json.message)
                        }
                    })
                }
            })
            ZXXFILE = $.extend(ZXXFILE, {
                csrf_token: $('meta[name="csrf-token"]').attr('content'),
                fileInput: $("#fileInput").get(0),
                dragDrop: $("#fileInput").get(0),
                upButton: $("#fileSubmit").get(0),
                url: '/admin/classification/icon/upload',
                filter: function(files) {
                    var arrFiles = [];
                    for (var i = 0, file; file = files[i]; i++) {
                        if (file.type.indexOf("image") == 0) {
                            if (file.size >= 512000) {
                                alert('您这张"'+ file.name +'"图片大小过大，应小于500k');
                            } else {
                                arrFiles.push(file);
                            }
                        } else {
                            alert('文件"' + file.name + '"不是图片。');
                        }
                    }
                    return arrFiles;
                },
                onSelect: function(files) {
                    var html = '', i = 0;
                    $("#preview").html('<div class="upload_loading"></div>');
                    var funAppendImage = function() {
                        file = files[i];
                        if (file) {
                            var reader = new FileReader()
                            reader.onload = function(e) {
                                html = html + '<div id="uploadList_'+ i +'" class="upload_append_list"><p><strong>' + file.name + '</strong>'+
                                        '<a href="javascript:" class="upload_delete" title="删除" data-index="'+ i +'">删除</a><br />' +
                                        '<img id="uploadImage_' + i + '" src="' + e.target.result + '" class="upload_image" /></p>'+
                                        '<span id="uploadProgress_' + i + '" class="upload_progress"></span>' +
                                        '</div>';

                                i++;
                                funAppendImage();
                            }
                            reader.readAsDataURL(file);
                        } else {
                            $("#preview").html(html);
                            if (html) {
                                //删除方法
                                $(".upload_delete").click(function() {
                                    ZXXFILE.funDeleteFile(files[parseInt($(this).attr("data-index"))]);
                                    return false;
                                });
                                //提交按钮显示
                                $("#fileSubmit").show();
                            } else {
                                //提交按钮隐藏
                                $("#fileSubmit").hide();
                            }
                        }
                    };
                    funAppendImage();
                },
                onDelete: function(file) {
                    $("#uploadList_" + file.index).fadeOut();
                },
                onDragOver: function() {
                    $(this).addClass("upload_drag_hover");
                },
                onDragLeave: function() {
                    $(this).removeClass("upload_drag_hover");
                },
                onProgress: function(file, loaded, total) {
                    var eleProgress = $("#uploadProgress_" + file.index), percent = (loaded / total * 100).toFixed(2) + '%';
                    eleProgress.show().html(percent);
                },
                onSuccess: function(file, response) {
//                    $("#uploadInf").append("<p>上传成功</p>");
                },
                onFailure: function(file) {
//                    $("#uploadInf").append("<p>图片" + file.name + "上传失败！</p>");
//                    $("#uploadImage_" + file.index).css("opacity", 0.2);
                },
                onComplete: function() {
                    window.location.reload()
//                    //提交按钮隐藏
//                    $("#fileSubmit").hide();
//                    //file控件value置空
//                    $("#fileImage").val("");
//                    $("#uploadInf").append("<p>当前图片全部上传完毕，可继续添加上传。</p>");
                }
            });
            ZXXFILE.init();
        })
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .upload_main{
            border-width:1px 1px 2px;
            border-style:solid;
            border-color:#ccc #ccc #ddd;
            background-color:#fbfbfb;
        }
        .upload_choose{
            padding:1em;
        }
        .upload_drag_area{
            display:inline-block;
            width:100%;
            margin-top: 10px;
            padding:4em 0;
            margin-left:.5em;
            border:1px dashed #ddd;
            color:#999;
            text-align:center;
            vertical-align:middle;
        }
        .upload_drag_hover{
            border-color:#069;
            box-shadow:inset 2px 2px 4px rgba(0, 0, 0, .5);
            color:#333;
        }
        .upload_preview{border-top:1px solid #bbb; border-bottom:1px solid #bbb; background-color:#fff; overflow:hidden; _zoom:1;}
        .upload_append_list{height:300px; padding:0 1em; float:left; position:relative;}
        .upload_delete{margin-left:2em;}
        .upload_image{max-height:250px; padding:5px;}
        .upload_submit{padding-top:1em; padding-left:1em;}
        .upload_submit_btn{display:none; height:32px; font-size:14px;}
        .upload_loading{height:250px;}
        .upload_progress{display:none; padding:5px; border-radius:10px; color:#fff; background-color:rgba(0,0,0,.6); position:absolute; left:25px; top:45px;}

        .img_select {
            cursor: pointer;
        }
        .img_select:before {
            content: '×';
            width: 10px;
            height: 10px;
            position: absolute;
            opacity: 0;
            font-size: 24px;
        }

        .img_select:hover:before {
            opacity: 1;
        }
    </style>
    {{--{!! Html::style('/assets/home/css/imgareaselect/animated.css') !!}--}}
@endsection