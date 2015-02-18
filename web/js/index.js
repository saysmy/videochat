define('index', ['cookie', 'user', 'common'], function(require, exports) {

    var user = require('user');
    var common = require('common');

    $(".sidebar-room").hover(function(){
        $(this).addClass("on");
    }, function(){
        $(this).removeClass("on");
    });

    var rids = [];
    $('.sidebar-room').each(function() {
        rids.push($(this).attr('room'));
    })
    $('.mainBig dt').each(function() {
        rids.push($(this).attr('room'));
    })
    $.ajax({
        url : '/index/getRoomPublishInfo',
        data : {rids : rids},
        type : 'post',
        dataType : 'json',
        success : function(resp) {
            for(var rid in resp.data) {
                $('.sidebar-room[room=' + rid + '] .pnum').text(resp.data[rid].online_num);
                if (resp.data[rid].nickname) {
                    $('.sidebar-room[room=' + rid + '] .rinfo p').text('在麦：' + resp.data[rid].nickname);
                }
                if (resp.data[rid].publish_mid != -1) {
                    $('.mainBig dt[room=' + rid + '] .on').show();
                }
            }
        }
    })

    exports.showActivity = function() {
        var last_come_time = $.cookies.get('last_come_time');
        $.ajax({
            url : '/activity/home' + (last_come_time ? '/last_come_time/' + last_come_time : ''), 
            dataType : 'json',
            success : function(resp) {
                if (resp.data.pic) {
                    common.showContentWin('<a href="' + resp.data.url + '"><img src="' + resp.data.pic + '"/></a>', resp.data.picWidth, resp.data.picHeight);
                }
                $.cookies.set('last_come_time', resp.data.current_time, {expires : 86400 * 365});
            }
        })
    }

    var visible_start = 0;
    var visible_end = 2;
    var sliding = false;
    var marginLeft = 0;
    curr_index = 0;

    exports.slide = function(num) {

        $('#sliderPanel li').click(function() {
            curr_index = $(this).index();
            doSlide($(this).index());
        })
        setInterval(function() {
            curr_index ++;
            if (curr_index >= num) {curr_index = 0};
            doSlide(curr_index);
        }, 10000);

        $('.sliderRight').click(function() {
            if(curr_index + 1 == num) {
                curr_index = -1;
            }
            doSlide(++curr_index);
        })

        $('.sliderLeft').click(function() {
            if(curr_index == 0) {
                curr_index = num;
            }
            doSlide(--curr_index);
        })

        $('.sliderReg').click(function() {
            user.showLoginPanel();
        })

        $('.btn-start').click(function() {
            if ($(this).attr('href')) {
                return true;
            }
            var video_url = $('#sliderItem .sliderItem:eq(' + curr_index + ')').attr('video-url');
            if (!video_url) {
                return false;
            }

            common.showContentWin('<div id="video-area"></div>', 800, 480);

            var flashvars={
                f : video_url,
                c : 0,
                p : 1
            };
            var params={
                bgcolor:'#FFF',
                allowFullScreen:true,
                allowScriptAccess:'always',
                wmode:'transparent'
            };

            CKobject.embedSWF('/swf/ckplayer/ckplayer.swf','video-area','ckplayer_a1','800','480',flashvars,params);

            return false;
        })

        $('.like').click(function() {
            var rid = $(this).attr('rid');
            var me = $(this);
            $.ajax({
                  url : '/room/love/rid/' + rid,
                  dataType : 'json',
                  success : function(resp) {
                      if (resp.errno == -100) {
                          user.showLoginPanel();
                      }
                      else if (resp.errno == 0){
                          var love_num = me.text();
                          if (resp.data.action == 'love') {
                              me.addClass('likeOn');
                              me.text(++love_num)
                          }
                          else {
                              me.removeClass('likeOn');
                              me.text(--love_num);
                          }
                      }
                  }
             })
        })

    }

    function doSlide(index) {
        if (sliding) {
            return;
        }
        var toIcon = $('#sliderPanel li:eq(' + index + ')');
        if (toIcon.hasClass('on')) {
            return false;
        };
        var current = $('#sliderPanel li.on');
        current.removeClass('on');
        toIcon.addClass('on');
        $('#sliderItem .sliderItem:eq(' + current.index() + ')').fadeOut(200, function() {
            $('#sliderItem .sliderItem:eq(' + index + ')').fadeIn(200);
        })

        if (index < visible_start) {
            marginLeft += (visible_start - index) * 95;
            $('.sliderSmall ul').css('marginLeft', marginLeft + 'px');
            visible_start = index;
            visible_end = visible_start + 2;
        }
        else if (index > visible_end) {
            marginLeft += (visible_end - index) * 95;
            $('.sliderSmall ul').css('marginLeft', marginLeft + 'px');
            visible_start = index - 2;
            visible_end = index;
        }

        sliding = false;

    }

    var sliderItems = $('#sliderItem .sliderItem');
    var sliderTimes = $('.sliderTime');
    var current_time = 0;

    exports.startTimer = function(time) {
        current_time = time;
        setInterval(syncTime, 1000);

        timer();
        setInterval(timer, 10000);
    }

    function syncTime() {
        current_time ++;
    }

    function timer() {
        sliderItems.each(function() {
            var item = $(this);
            var index = item.index();
            var play_start_time = item.attr('play-start-time');
            var play_end_time = item.attr('play-end-time');
            var left = play_start_time - current_time;
            if (left < 0) {
                left = 0;
            }

            var day = Math.floor(left/60/60/24) + '';
            var hour = Math.floor(left/60/60)%24 + '';
            var min = Math.floor(left/60)%60 + '';

            var timeItem = $(sliderTimes[index]);
            timeItem.find('.days dt').text(day.length > 1 ? day.substr(0, 1) : 0); 
            timeItem.find('.days dd').text(day.length > 1 ? day.substr(-1, 1): day);   

            timeItem.find('.hours dt').text(hour.length > 1 ? hour.substr(0, 1) : 0); 
            timeItem.find('.hours dd').text(hour.length > 1 ? hour.substr(-1, 1): hour); 

            timeItem.find('.mins dt').text(min.length > 1 ? min.substr(0, 1) : 0); 
            timeItem.find('.mins dd').text(min.length > 1 ? min.substr(-1, 1): min);  

            if (current_time >= play_start_time && current_time <= play_end_time) {
                item.find('.btn-start').attr('href', item.attr('room'));
                item.find('.timeLive').show();
                item.find('.timeCont').hide();
            }
            else {
                item.find('.btn-start').attr('href', item.attr('room'));
                item.find('.timeLive').hide();
                item.find('.timeCont').show();

                // if (item.attr('detail-url')) {
                //     item.find('.btn-start').attr('href', item.attr('detail-url'));
                // }
                // else {
                //     item.find('.btn-start').attr('href', '');
                // }
             }
        })
    }
})