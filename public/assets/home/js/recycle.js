$(document).ready( function () {
    /*
     * 为头部未开发的tab做弹出提示
     */
    $('.header').on('click', '.showalert', function () {
        $('#dialog2').show().on('click', '.weui_btn_dialog', function () {
            $('#dialog2').off('click').hide();
        });
    });

    /*
     *点击菜单更换图标和数据
     */
    var productNum = $('#product-container li');
    var imgNum = $('#product-container img');
    var dataNum = $('.choose>div');
    for (var i = 0; i < productNum.length; i++ ) {
        productNum[i].index = i;
        productNum[i].onclick = function () {
            for (var i = 0; i < productNum.length; i++ ) {
                var imgsrc = $(imgNum[i]).attr("src");
                var resrc = imgsrc.replace("_selected","");
                $(imgNum[i]).attr('src',resrc);
                $(dataNum[i]).hide();
            };

            $('.choose').css('padding','12px','15px');

            var m = $(this).index();
            var imgsrc = $(imgNum[m]).attr("src");
            var resrc = imgsrc.indexOf(".png");
            var resrc1 = imgsrc.substring(2,resrc);
            var resrc2 = ".." + resrc1 + "_selected.png";
            $(imgNum[m]).attr('src',resrc2);
            $(dataNum[m]).show();


        };
    };

    /*
     * 无成本券单选
     */
    var couponNum = $('.coupon>div');
    var skNum = $(".coupon img");
    for (var i = 0; i < couponNum.length; i++) {
        couponNum[i].onclick = function () {
            for (var i = 0; i < couponNum.length; i++ ) {
                $(couponNum[i]).removeClass('active');
                var imgsrc = $(skNum[i]).attr("src");
                var resrc = imgsrc.replace("_selected","");
                $(skNum[i]).attr('src',resrc);
            };

            var m = $(this).index();
            $(couponNum[m]).addClass('active');
            var imgsrc = $(skNum[m]).attr("src");
            var resrc = imgsrc.indexOf(".png");
            var resrc1 = imgsrc.substring(2,resrc);
            var resrc2 = ".." + resrc1 + "_selected.png";
            $(skNum[m]).attr('src',resrc2);
        };
    };

    /*
     * 绑定手机做弹出提示
     */
    $('.container').on('click', '#blind-phone', function () {
        $('#toast').show();
        setTimeout(function () {
            $('#toast').hide();
        }, 2000);
    });

    /*
     * 我的作业单tab切换
     */
    $('.header').on('click', '.col-3-1', function () {
        var tabNum = $('.header-nav span');
        var containerNum = $('.task-container>div');
        for(var i=0; i < tabNum.length; i++) {
            for(var i=0; i < tabNum.length; i++) {

                tabNum[i].className = '';
                $(containerNum[i]).hide();
            };
            var m = $(this).index();
            $(tabNum[m]).addClass('active');
            $(containerNum[m]).show();
        };
    });

    /*
     * 回收确认页面下，照片编辑，是否拆卸
     */
    $('.recycle-datas').on('click', '.confirm-img', function () {
        var temp1 = $('.confirm-img');
        var temp = $('.confirm-img img');
        var imgsrc = $(temp[0]).attr("src");
        if(imgsrc.indexOf("_selected.png") > 0) {
            var resrc = imgsrc.replace("_selected.png",".png");
            $(temp[0]).attr('src',resrc);
        } else {
            var resrc = imgsrc.replace(".png","_selected.png");
            $(temp[0]).attr('src',resrc);
        }
    });

    $('.recycle-datas').on('click', '.delete-tip', function () {
        $('#dialog1').show().on('click', '.weui_btn_dialog', function () {
            $('#dialog1').off('click').hide();
        });
    });

} );