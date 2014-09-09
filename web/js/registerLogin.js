define('registerLogin',['user', 'rsa'], function(require, exports, module) {
    var tips_ids = [];
    var user = require('user');
    var rsa = new (require('rsa').RSA);
    var me = this;
    getPublicKey();

    $('.goQQLogin').click(function() {
        user.qqLogin(me.qqLoginUrl);
        return false;
    })
    var isRegistering = false;
    $("#register-area input[type=submit]").click(function() {
        if (isRegistering) {
            return;
        };
        this.value = '注册中';
        isRegistering = true;
        $(this).css('cursor', 'default');

        for (var i in tips_ids) {
            $("#xubox_layer" + tips_ids[i]).hide();
        }
        tips_ids = [];
        var agree = $("#register-agree")[0].checked;
        if (!agree) {
            tips_ids.push(layer.tips('请确认协议', $("#agree-td"), {
              style: ['background-color:RGB(0, 191, 245); color:white', 'RGB(0, 191, 245)'],
              time : 10,
              guide : 3,
              more : true
            }));
            return;
        };
        var me = this;
        getPublicKey(function() {
            var data = {};
            $("#register-area input[name]").each(function() {
                if (this.name == 'password' || this.name == 'passwordRepeat') {
                    data[this.name] = rsa.encrypt(this.value);
                }
                else {
                    data[this.name] = this.value;
                }
            })
            $("#register-area select[name]").each(function() {
                data[this.name] = this.value;
            })
            data.agree = agree;
            $.ajax({
                url : '/user/register',
                data : data, 
                type : 'post',
                dataType : 'json',
                success : function(ret) {
                    me.value = '同意注册';
                    isRegistering = false;
                    $(me).css('cursor', 'pointer');

                    if (ret.errno == 0) {
                        layer.msg('注册成功,自动登录中...', 2 ,{type : 9});
                        setTimeout(function(){location.reload()}, 2000);
                    }
                    else {
                        $('#register-captcha').click();
                        for (var name in ret.data) {
                            var dom = $("#register-area input[name=" + name + "]").length ? $("#register-area input[name=" + name + "]") : $("#register-area select[name=" + name + "]")
                            tips_ids.push(layer.tips(ret.data[name], dom, {
                                style: ['background-color:RGB(0, 191, 245); color:white', 'RGB(0, 191, 245)'],
                                time : 10,
                                guide : 3,
                                more : true
                            }));
                        }
                    };
                }
            })           
        })
        return false;
    })
    var isLogining = false;
    $("#login-area input[type=submit]").click(function() {
        if (isLogining) {
            return;
        };
        this.value = '登录中';
        isLogining = true;
        $(this).css('cursor', 'default');
        var me = this;

        for (var i in tips_ids) {
            $("#xubox_layer" + tips_ids[i]).hide();
        }
        tips_ids = [];
        getPublicKey(function() {
            var data = {username : $('#login-area input[name=username]').val(), 'password' : rsa.encrypt($('#login-area input[name=password]').val()), remember : $('#login-remember')[0].checked};
            $.ajax({
                url : '/user/login',
                type : 'post',
                data : data,
                dataType : 'json',
                success : function(ret) {
                    me.value = '立即登录';
                    isLogining = false;
                    $(me).css('cursor', 'pointer');

                    if (ret.errno == 0) {
                        layer.msg('登录成功', 2 ,{type : 9});
                        setTimeout(function(){location.reload()}, 2000);
                    }
                    else if (ret.errno == 400){
                        for (var name in ret.data) {
                            var dom = $("#login-area input[name=" + name + "]");
                            tips_ids.push(layer.tips(ret.data[name], dom, {
                                style: ['background-color:RGB(0, 191, 245); color:white', 'RGB(0, 191, 245)'],
                                time : 10,
                                guide : 3,
                                more : true
                            }));
                        }
                    }
                    else {
                        layer.msg(ret.msg, 2 ,{type : 9});
                    }
                }
            })
        })
        return false;
    })    
    //注册弹窗
    exports.showRegisterPanel = function(){
        var docHeight = $(document).height();
        var docWidth = $(document).width();
        var winHeight = $(window).height();
        $("#overlay-mask").height(docHeight);
        $("#overlay-cont").css({
            'left':((docWidth)-675)/2,
            'top':((winHeight)-465)/2
        });
        $("#overlay-reg").css({"display":"block"});
        $("#overlay-login").css({"display":"none"});
        $("#overlay-mask").fadeIn();
        $("#overlay-cont").fadeIn();  
        return false;
    }
    exports.showLoginPanel = function(){
        var docHeight = $(document).height();
        var docWidth = $(document).width();
        var winHeight = $(window).height();
        $("#overlay-mask").height(docHeight);
        $("#overlay-cont").css({
            'left':((docWidth)-675)/2,
            'top':((winHeight)-465)/2
        });

        $("#overlay-login").css({"display":"block"});
        $("#overlay-reg").css({"display":"none"});
        $("#overlay-mask").fadeIn();
        $("#overlay-cont").fadeIn();
        return false; 
    }
    $(".overlay-loginBtn").click(function(){
        $("#overlay-login").css({"display":"block"});
        $("#overlay-reg").css({"display":"none"});
        return false; 
    });
    $(".overlay-regBtn").click(function(){
        $("#overlay-reg").css({"display":"block"});
        $("#overlay-login").css({"display":"none"});  
        return false;
    });

    $(".close").click(function(){
        $("#overlay-mask").fadeOut();
        $("#overlay-cont").fadeOut(); 
    })

    //获取公钥
    function getPublicKey(callback) {
        $.ajax({
            url : '/user/getPublicKey?r=' + Math.random(),
            dataType : 'json',
            success : function(resp) {
                if (resp.errno) {
                    return;
                }
                rsa.setPublicKey(resp.data);
                callback && callback();
                
            }
        })
    }

})

