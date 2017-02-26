@extends('layout.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-body">
                    {!! Form::model($classification) !!}
                    <div class="form-group">
                        <div class="col-md-6">
                            {!! Form::label('名称') !!}
                            {!! Form::text('name', old('name'), [
                                'class' => 'form-control',
                                'id' => '名称',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('name'))  }}</span>
                        </div>
                        <div class="col-md-6">
                            {!! Form::label('排序(越小越靠前)') !!}
                            {!! Form::number('sort', old('sort'), [
                                'class' => 'form-control',
                                'min' => '0',
                                'id' => '排序(越小越靠前)',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('sort'))  }}</span>
                        </div>
                        <div class="col-md-12">
                            {!! Form::label('图标') !!}
                            {!! Form::text('_icon', old('icon'), [
                                'class' => 'form-control',
                                'id' => '图标',
                                'placeholder' => '请选择图片',
                                'disabled' => '',
                            ]) !!}
                            {!! Form::hidden('icon', old('icon'), [
                                'id' => 'icon',
                            ]) !!}
                            <span class="help-block">{{ current($errors->getBag('default')->get('icon'))  }}</span>
                        </div>
                    </div>
                    <div>
                        @forelse(File::allFiles(public_path('assets/home/img/icon')) as $file)
                            <div class="col-md-3 img_select" data-src="/assets/home/img/icon/{{ $file->getFileName() }}">
                                <img src="/assets/home/img/icon/{{ $file->getFileName() }}" class="img img-responsive">
                            </div>
                        @empty
                            <h3 class="text-muted text-center">
                                <a href="/admin/classification/icon/index">没有图片, 去上传</a>
                            </h3>
                        @endforelse
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-success pull-right">保存</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        $(function () {
            var tp = $("#图标")
            var icon = $("#icon")
            var imgs = $(".img_select")
            imgs.click(function() {
                var src = $(this).data('src')
                tp.val(src)
                icon.val(src)
                $(this).addClass('active').siblings().removeClass('active')
            })

            tp.val(icon.val())
            imgs.each(function() {
                if($(this).data('src') == tp.val()) {
                    $(this).click()
                }
            })
        })
    </script>
@endsection

@section('styles')
    @parent
    <style>
        .img_select img {
            border: 2px solid #fff;
            transition : border 0.5s;
        }
        .img_select.active img {
            border: 2px solid #F1A417;
        }
    </style>
@endsection    