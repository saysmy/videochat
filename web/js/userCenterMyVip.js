define(['layer'], function(require) {
    var layer_id = null;
    var buy_type = 'month';
    var month_price = 29.9;
    $('#btn-buy').click(function() {
        layer_id = $.layer({
            type : 1,
            area : ['600px', '450px'],
            title : false,
            border : 0,
            closeBtn : false,
            page : {
                dom : '.ucenter-overlay'
            }
        })
        return false;
    })

    $('.ucenter-overlay .buy-close').click(function() {
        layer.close(layer_id);
        return false;
    })

    $('.buy-time').click(function() {
        if ($(this).attr('time') == 'month' && !$(this).hasClass('on')) {
            $(this).addClass('on');
            $('.buy-time[time=year]').removeClass('on');
            $('.buy-month').show();
            $('.buy-year').hide();
            buy_type = 'month';
            _computePayAmount();
        }
        else if ($(this).attr('time') == 'year' && !$(this).hasClass('on')) {
            $(this).addClass('on');
            $('.buy-time[time=month]').removeClass('on');
            $('.buy-year').show();
            $('.buy-month').hide();
            buy_type = 'year';
            _computePayAmount();
        }
        return false;
    })

    $('#vip-buy').click(function() {
        var num = null;
        if (buy_type == 'month') {
            num = $.trim($('.buy-month-num').val());
        }
        else {
            num = $.trim($('.buy-year-num').val());
        }
        $.ajax({
            url : '/userCenter/buyVip/type/' + buy_type + '/num/' + num,
            dataType : 'json',
            success : function(resp) {
                if (resp.errno == 0) {
                    layer.alert('开通成功', 1);
                }
                else if (resp.errno == 105){
                    layer.alert('余额不足');
                }
                else {
                    layer.alert('开通失败');
                }
            }
        })
        return false;
    })

    $('.buy-month-num').change(function() {
        _computePayAmount();
    })

    $('.buy-year-num').change(function() {
        _computePayAmount();
    })

    function _computePayAmount() {
        var buy_month = null;
        if (buy_type == 'month') {
            var num = $.trim($('.buy-month-num').val());
            if (!isNaN(num)) {
                buy_month = num;
            }
        }
        else {
            var num = $.trim($('.buy-year-num').val());
            if (!isNaN(num)) {
                buy_month = num * 12;
            }
        }
        if (buy_month) {
            var need_pay = buy_month * month_price;
            //浮点数不能准确表示，取小数点后一位
            need_pay = Math.round(need_pay*10)/10;
            $('.need-pay').text(need_pay);
            var my_coin = parseInt($('.my-coin').text());
            if (my_coin < need_pay) {
                $('.buy-error .error-num').text(Math.round((need_pay - my_coin)*10)/10);
                $('.buy-error').show();
            }
            else {
                $('.buy-error').hide();
            }
        }
    }


})