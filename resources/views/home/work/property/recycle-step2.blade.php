@extends('layout.weui')

@section('content')
    <div class="recycle-datas product-datas">
        <div class="weui_cells weui_cells_form form-container" id="回收型号">
            <div class="weui_cells form-item">
                <div class="weui_cell weui_cell_select">
                    <div class="weui_cell_bd weui_cell_primary">
                        {!! Form::select('classification_type', [
                            $order->model->classification->type => $order->model->classification->type,
                        ], $order->model->classification->type, [
                            'class' => 'weui_select classification_type',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="weui_cells form-item">
                <div class="weui_cell weui_cell_select">
                    <div class="weui_cell_bd weui_cell_primary">
                        {!! Form::select('classification', [
                                $order->model->classification->id => $order->model->classification->name,
                            ], $order->model->classification->id, [
                            'class' => 'weui_select classification',
                            'id' => 'classification',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="weui_cells form-item">
                <div class="weui_cell weui_cell_select">
                    <div class="weui_cell_bd weui_cell_primary">
                        {!! Form::select('type_id', [
                            $order->model->id => $order->model->name,
                            ], $order->model->id, [
                            'class' => 'weui_select type_id',
                            'id' => 'type_id',
                        ]) !!}
                    </div>
                </div>
            </div>

            <div class="weui_cells mb15">
                <div id="is_unload" class="is_unload {{ $order->is_unload ? 'active' : '' }}">
                    <i class="checkbox"></i>
                    <span class="label">是否需要拆卸</span>
                </div>
            </div>

            <div class="weui_cells mb15">
                <div id="is_miss_component" class="is_unload">
                    <i class="checkbox"></i>
                    <span class="label">是否缺件</span>
                </div>
            </div>

            <div class="weui_cell form-item" id="miss_component_reason_box" style="display: none;">
                <div class="weui_cell_bd weui_cell_primary">
                    <textarea name="miss_component_reason" id="miss_component_reason" class="weui_textarea cannot-reason" maxlength="200" placeholder="请填写缺件信息" rows="3"></textarea>
                </div>
            </div>

            @if($order->type === '协助下单' || $order->type === '现金转账')
            <div class="weui_cell form-item confirm-price">
                <div class="weui_cell_bd weui_cell_primary">
                    <input class="weui_input" type="number" id="cfm_money" name="cfm_money" value="{{$order->money}}" step="0.01" min="0.01" max="{{ $order->money }}" placeholder="请填写实发金额: {{$order->money}} 元">
                </div>
            </div>
            @endif

            <div class="weui_cells mb15">
                <div>商品编号：<span class="product-num" id="order_code" data-code_id="">未扫描</span></div>
                <a class="btn_primary btn-scan" id="scan_qr_code">扫描二维码</a>
                <div class="confirm-tip">二维码贴在商品上扫描</div>
            </div>

            <div class="weui_cells mb15">
                <div>商品照片</div>
                <a href="javascript:;" class="btn_primary btn-pic" id="choose_image">点击拍照</a>
                <div class="confirm-tip">1. 照片内必须包括完整的商品<br>2. 照片必须拍摄两张以上</div>
                <div class="product-pics clearfix">
                    <div class="product-pic" id="img_container">
                    </div>
                </div>
            </div>

            <div class="weui_dialog_confirm" id="dialog1" style="display: none;">
                <div class="weui_mask"></div>
                <div class="weui_dialog">
                    <div class="weui_dialog_hd"><strong class="weui_dialog_title">操作提示</strong></div>
                    <div class="weui_dialog_bd" style="text-align:center;">确认删除该图片？</div>
                    <div class="weui_dialog_ft">
                        <a href="javascript:;" class="weui_btn_dialog default">取消</a>
                        <a href="javascript:;" class="weui_btn_dialog primary" style="color:#00b275;">确定</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="next-step">
        <a id="submit" class="btn_primary">确认提交</a>
    </div>
@endsection


@section('scripts')
    @parent
    {!! Html::script('/assets/admin/plugins/cxselect/jquery.cxselect.min.js') !!}
    <script>

        var modelsjson = {!! \Icoming\Models\Type::all()->toJson() !!}
        var models = {}
        for(var i in modelsjson) {
            models[modelsjson[i].id] = modelsjson[i]
        }

        $(function() {
            $('#回收型号').cxSelect({
                url: '/work/property/classification-cxselect',
                selects: ['classification_type', 'classification', 'type_id'],
                jsonValue: 'v',
            })
            @if($order->type === '协助下单' || $order->type === '现金转账')
            $("#type_id").change(function() {
                var m = models[$(this).val()]
                if(m) {
                    $("#cfm_money").val(models[$(this).val()].value).data('max', models[$(this).val()].value)
                } else {
                    $("#cfm_money").val('').data('max', 0)
                }
            })
            @endif

            $(".is_unload").click(function() {
                $(this).toggleClass('active')
                is_unload = 0
                if($(this).hasClass('active')) {
                    is_unload = 1
                }
            })
            $("#is_miss_component").click(function() {
                $("#miss_component_reason").val('')
                $("#miss_component_reason_box").toggle()
            })
        })
    </script>
@endsection

@section('wx')
    @parent
    <script>
        wx.ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#scan_qr_code").click(function() {
                wx.scanQRCode({
                    needResult: 1,
                    success: function(res) {
//                        console.log(res)
                        var result = res.resultStr
                        // 发起验证请求判断二维码是否存在
                        $.getJSON('/work/property/verify-code/' + result, function(json) {
                            if(json.code == 0) {
                                $("#order_code").html(result + '(验证通过)').data('code_id', json.data)
                            } else {
                                $("#order_code").html(result + '(' + json.message + ')')
                            }
                        })
                    }
                })
            })

            $("#choose_image").click(function() {
                var img_container = $("#img_container")
                if(img_container.children().length >= 9) {
                    toast('最多上传九张图片')
                    return
                }
                wx.chooseImage({
                     sizeType: ['original', 'compressed'], // 可以指定是原图还是压缩图，默认二者都有
                     sourceType: ['camera'], // 可以指定来源是相册还是相机，默认二者都有
                    success: function (res) {
                        var localIds = res.localIds; // 返回选定照片的本地ID列表，localId可以作为img标签的src属性显示图片
                        $(localIds).each(function() {
                            var localId = this
//                            console.log(localId)
                            wx.uploadImage({
                                localId: localId.toString(), // 需要上传的图片的本地ID，由chooseImage接口获得
                                success: function (res) {
//                                    console.log(res)
                                    var serverId = res.serverId; // 返回图片的服务器端ID
//                                    console.log(localId + ':' + serverId)
                                    img_container.append($('<img class="delete-tip" src="' + localId + '">').fadeIn().data('serverId', serverId))
                                }
                            });
                        })
                    }
                })
            })

            $('.recycle-datas').on('click', '.delete-tip', function () {
                var img = $(this)
                $("#dialog1 .weui_btn_dialog.primary").one('click', function() {
                    img.fadeOut(function() {
                        img.remove()
                    })
                })
                $('#dialog1').show().on('click', '.weui_btn_dialog', function () {
                    $('#dialog1').off('click').hide();
                });
            });

            var posting = false
            // 提交表单
            $("#submit").click(function() {
                if(posting) {
                    toast('提交中')
                    return false
                }
                var form = {}
                form.type_id = $("#type_id").val()
                if(!form.type_id) {
                    toast('请选择正确型号')
                    return;
                }
                // 缺件信息
                var is_miss_component = $("#is_miss_component").hasClass('active')
                if(is_miss_component) {
                    if(!$("#miss_component_reason").val()) {
                        toast('请填写缺件信息')
                        return
                    }
                    form.miss_component_reason = $("#miss_component_reason").val()
                }
                @if($order->type === '协助下单' || $order->type === '现金转账')
                var $cfm_money = $("#cfm_money")
                var cfm_money = $cfm_money.val()
                if(cfm_money < 1) {
                    toast('实发金额不得小于1元')
                    return
                } else if (cfm_money > $cfm_money.data('max')) {
                    toast('实发金额不得大于' + $cfm_money.data('max') + ' 元')
                    return
                }
                form.cfm_money = cfm_money
                @endif
                form.is_unload = $("#is_unload").hasClass('active')
                form.code_id = $("#order_code").data('code_id')
//                console.log(form)
                if(!form.code_id) {
                    toast('请扫描二维码')
                    return;
                }
                form.imgs = []
                $("#img_container").children().each(function() {
                    form.imgs.push($(this).data('serverId'))
                })
                if(form.imgs.length < 2) {
                    toast('请最少拍两张照片')
                    return;
                }
                posting = true
                $.post(window.href, form, function(json) {
                    if(json.code === '-0') {
                        alert(json.message)
                        window.location.href = json.url
                    } else if(json.code == 0) {
                        window.location.href = json.url
                    } else {
                        posting = false
                        toast(json.message)
                    }
                })
            })

        })
    </script>
@endsection