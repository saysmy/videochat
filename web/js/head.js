define(['user', 'registerLogin', 'plupload', 'jcrop'], function(require) {
    var user = require('user');
    var registerLogin = require('registerLogin');
    var headTmpUrl = null;
    var cropSize = null;
    user.getUserInfo(function(resp) {
        if (resp.errno) {return;};
        $('.coin b').text(resp.data.coin);
        $('.uinfo.logined img').attr('src', resp.data['head_pic_1']);
        $('.settingLeft dt img').attr('src', resp.data['head_pic_1']);
        $('.uinfo.logined a.nickname').text(resp.data['nickname']);
        $('.editInner b').text(resp.data['nickname']);
        $('.logined').show();
        $('.unlogined').hide();
        if (resp.data.rUrl) {
            $('.liveRoom').attr('href', resp.data.rUrl);
        }
    })
    $("#user-reg").click(registerLogin.showRegisterPanel);
    $("#user-login").click(registerLogin.showLoginPanel);
    //编辑昵称
    $("li.edit").hover(function(){
        $(".editBg").css({"display":"block"});
        $(".editCont").css({"display":"block"});
    },function(){
        $(".editBg").css({"display":"none"});
        $(".editCont").css({"display":"none"});
    });
    
    //设置
    $("li.setting").hover(function(){
        $(".settingBg").css({"display":"block"});
        $(".settingCont").css({"display":"block"});
    },function(){
        $(".settingBg").css({"display":"none"});
        $(".settingCont").css({"display":"none"});
    });

    //上传头像弹窗
    var loadingId = 0;
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'addPic', // you can pass in id...
        // container: document.getElementById('addPic'), // ... or DOM Element itself
        url : '/user/uploadPic',
        flash_swf_url : '/js/plupload/Moxie.swf',
        silverlight_xap_url : '/js/plupload/Moxie.xap',
        
        filters : {
            max_file_size : '2mb',
            mime_types: [
                {title : "Image files", extensions : "jpg,jpeg,png"},
            ]
        },

        init: {
            PostInit: function() {
            },

            FilesAdded: function(up, files) {
                loadingId = layer.load('上传中');
                uploader.start();
            },

            UploadProgress: function(up, file) {
                // console.log(file);
            },

            FileUploaded : function(up, file, resp) {
                layer.close(loadingId);
                resp = eval('(' + resp.response + ')');
                if (resp.errno) {
                    layer.alert('上传文件出错：' + errno.msg, 8);
                    return;
                };
                var url = resp.data.url;
                headTmpUrl = url;
                $('.addPic').hide();
                $('#item0Step2').show();
                $('#uploadImage').attr('src', url);
                $('#uploadImage').Jcrop({
                    setSelect : [0, 0, 200, 200],
                    allowResize : false,
                    onChange: updatePreview
                })
                $('#uploadImage').load(function() {
                    $('#headPreview').attr({
                        'src' : url,
                        'width' : $('#uploadImage').width() + 'px',
                        'height' : $('#uploadImage').height() + 'px'
                     });
                })
            },

            Error: function(up, err) {
                layer.close(loadingId);
                layer.alert('上传文件出错', 8);

            }
        }
    });
    uploader.init();

    $("#overlay-mask").height($(window.document).height())
    $("#overlay-upface").css({
        'left':($(window.document).width()-770)/2,
        'top':($(window).height()-450)/2
    });
    $(".upface").click(function() {
        $("#overlay-mask").fadeIn();
        $("#overlay-upface").fadeIn();
    })
    $(".close2").click(function(){
        $("#overlay-mask").fadeOut();
        $("#overlay-upface").fadeOut(); 
    })
    

    jq_tabs("upBox");

    $('#uploadHeadPic').click(function() {
        if (!(cropSize && headTmpUrl)) {
            return;
        }
        var data = {w : $('#uploadImage').width(), h : $('#uploadImage').height(), x : cropSize.x, y : cropSize.y, dw : cropSize.w, dh : cropSize.h, url : headTmpUrl};
        $.ajax({
            url : '/user/uploadCropHeadPic',
            data : data, 
            type : 'post',
            dataType : 'json',
            success : function(resp) {
                if (resp.errno == 0) {
                    layer.msg('头像设置成功', 3, 1);
                    setTimeout(function() {location.reload();}, 3000);
                }
                else {
                    layer.alert('头像设置失败');
                }
            }
        })
    })

    $('#pickAgain').click(function() {
        $('.addPic').show();
        $('#item0Step2').hide();
    })

    var reIndex = null;
    $('#reHeadPic img').click(function() {
        var index = $(this).index() + 1;
        reIndex = index;
        $('#reHeadPreview').attr('src', '/img/face' + index + '_s1.jpg');
    })

    $('#uploadReHeadPic').click(function() {
        if (!reIndex) {
            return;
        };
        $.ajax({
            url : '/user/uploadReHeadPic/index/' + reIndex,
            dataType : 'json',
            success : function(resp) {
                if (resp.errno == 0) {
                    layer.msg('头像设置成功', 3, 1);
                    setTimeout(function() {location.reload();}, 3000);
                }                    
                else {
                    layer.alert('头像设置失败');
                }
               
            }
        })
    })

    $('#doEditNickname').click(function() {
        var nickname = $.trim($('#newNickname').val());
        if (!nickname) {
            layer.alert('昵称不能为空');
            return;
        };
        $.ajax({
            url : '/user/updateUserInfo/scene/nickname',
            type : 'post',
            dataType : 'json',
            data : {nickname : nickname},
            success : function(resp) {
                if (resp.errno) {
                    layer.alert('更新昵称失败');
                    return;
                };
                layer.msg('昵称更新成功', 3, 1);
                setTimeout(function() {location.reload();}, 3000);
            }
        })
      
    })

    $('#cancelEditNickname').click(function() {
        $(".editBg").css({"display":"none"});
        $(".editCont").css({"display":"none"});         
    })

    function jq_tabs(str) {
        $("#"+str+"Tab a").mouseover(function(){
            $("#"+str+"Tab a").removeClass("on");
            $(this).addClass("on");
            var key = $("#"+str+"Tab a").index(this);
            $("[id^='"+str+"Item']").hide();
            $("#"+str+"Item"+key).show();
        });
        $("#"+str+"Tab a").eq(0).trigger("mouseover");
    }

    function updatePreview(c) {
        $('#headPreview').css({
            marginLeft: '-' + Math.round(c.x) + 'px',
            marginTop: '-' + Math.round(c.y) + 'px'
        });
        cropSize = c;
    };



    function addFavorite(sURL, sTitle)
    {
        try
        {
            window.external.addFavorite(sURL, sTitle);
        }
        catch (e)
        {
            try
            {
                window.sidebar.addPanel(sTitle, sURL, "");
            }
            catch (e)
            {
                alert("请使用Ctrl+D进行添加(mac用户使用Command+D)");
            }
        }
    }

})