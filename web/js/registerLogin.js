define('registerLogin',['user', 'rsa', 'layer', 'common', 'validate'], function(require, exports, module) {
    var register_tips_ids = {};
    var login_tips_ids = {};
    var user = require('user');
    var rsa = new (require('rsa').RSA);
    var layer = require('layer');
    var common = require('common');
    // common.getPublicKey(function(key){rsa.setPublicKey});

    $('.goQQLogin').click(function() {
        user.qqLogin(registerLogin.qqLoginUrl);
        return false;
    })

    var isRegistering = false;
    $('#register-form').validate({
        rules : {
            username : 'required',
            password : {
                required : true,
                minlength : 6
            },
            passwordRepeat : {
                required : true,
                equalTo  : '#register-form input[name=password]'
            },
            age : 'required',
            height : 'required',
            weight : 'required',
            captcha : 'required',
            agree : 'required'
        },
        messages : {
            username : '用户名不能为空',
            password : {
                required : '密码不能为空',
                minlength : '密码至少为6字符'
            },
            passwordRepeat : {
                required : '确认密码不能为空',
                equalTo : '两次输入的密码不同'
            },
            age : '年龄不能为空',
            height : '身高不能为空',
            weight : '体重不能为空',
            captcha : '验证码不能为空',
            agree : '请勾选协议'
        },
        showErrors: function(map, list) {
            if (this.currentElements.length == 1) {
                if (list.length) {
                    _show_error_tips(list[0].message, list[0].element, register_tips_ids);
                }
                else {
                    _close_error_tips(this.currentElements[0], register_tips_ids);
                }
            }
            else {
                for (var i in list) {
                    _show_error_tips(list[i].message, list[i].element, register_tips_ids);
                }
            }
        },
        submitHandler : function() {
            if (isRegistering) {
                return;
            };

            common.buttonTextLoading(this.submitButton, '注册中');
            isRegistering = true;
            var me = this;

            common.getPublicKey(function(key) {
                rsa.setPublicKey(key);
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
                $.ajax({
                    url : '/user/register',
                    data : data, 
                    type : 'post',
                    dataType : 'json',
                    success : function(ret) {
                        common.stopButtonTextLoading(me.submitButton, '立即注册');
                        isRegistering = false;

                        if (ret.errno == 0) {
                            layer.msg('注册成功,自动登录中...', 2 ,{type : 9});
                            setTimeout(function(){location.reload()}, 2000);
                        }
                        else {
                            $('#register-captcha').click();
                            for (var name in ret.data) {
                                var dom = $("#register-area input[name=" + name + "]").length ? $("#register-area input[name=" + name + "]") : $("#register-area select[name=" + name + "]")
                                _show_error_tips(ret.data[name], dom[0], register_tips_ids);
                            }
                        };
                    }
                })           
            })
            return false;
        }
    })

    var isLogining = false;
    $('#login-form').validate({
        rules : {
            username : 'required',
            password : 'required'
        },
        messages : {
            username : '用户名不能为空',
            password : '密码不能为空'
        },
        showErrors: function(map, list) {
            if (this.currentElements.length == 1) {
                if (list.length) {
                    _show_error_tips(list[0].message, list[0].element, login_tips_ids);
                }
                else {
                    _close_error_tips(this.currentElements[0], login_tips_ids);
                }
            }
            else {
                for (var i in list) {
                    _show_error_tips(list[i].message, list[i].element, login_tips_ids);
                }
            }
        },
        submitHandler : function() {
            if (isLogining) {
                return;
            };

            common.buttonTextLoading(this.submitButton, '登录中');
            isLogining = true;
            var me = this;

            common.getPublicKey(function(key) {
                rsa.setPublicKey(key);
                var data = {username : $('#login-area input[name=username]').val(), 'password' : rsa.encrypt($('#login-area input[name=password]').val()), remember : $('#login-remember')[0].checked};
                $.ajax({
                    url : '/user/login',
                    type : 'post',
                    data : data,
                    dataType : 'json',
                    success : function(ret) {
                        common.stopButtonTextLoading(me.submitButton, '立即登录');
                        isLogining = false;

                        if (ret.errno == 0) {
                            layer.msg('登录成功', 2 ,{type : 9});
                            setTimeout(function(){location.reload()}, 2000);
                        }
                        else if (ret.errno == 400){
                            for (var name in ret.data) {
                                var dom = $("#login-area input[name=" + name + "]");
                                _show_error_tips(ret.data[name], dom[0], login_tips_ids);
                            }
                        }
                        else {
                            layer.msg(ret.msg, 2 ,{type : 9});
                        }
                    }
                })
            })
        }
       
    })

    //注册弹窗
    exports.showRegisterPanel = function() {
        var layer_id = $.layer({
                type : 1,
                title : false,
                closeBtn: [0],
                area : ['675px','465px'],
                page : {dom : '#overlay-cont'},
                border: [0]
        });
        $('#overlay-cont').attr('layer_id', layer_id);

        $("#overlay-reg").css({"display":"block"});
        $("#overlay-login").css({"display":"none"});
 
        return false;
    }
    exports.showLoginPanel = function(){
        var layer_id = $.layer({
                type : 1,
                title : false,
                closeBtn: [0],
                area : ['675px','465px'],
                page : {dom : '#overlay-cont'},
                border: [0]
        });

        $('#overlay-cont').attr('layer_id', layer_id);

        $("#overlay-login").css({"display":"block"});
        $("#overlay-reg").css({"display":"none"});
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
        for (var i in register_tips_ids) {
            layer.close(register_tips_ids[i]);
            delete register_tips_ids[i];
        }
        for (var i in login_tips_ids) {
            layer.close(login_tips_ids[i]);
            delete login_tips_ids[i];
        }
        layer.close($('#overlay-cont').attr('layer_id'))
    })

    function _show_error_tips(message, dom, tips_ids) {
        var name = dom.getAttribute('name');
        if (tips_ids[name]) {
            return;
        }
        var layer_id = layer.tips(message, name == 'agree' ? $('#agree-td') : dom, {
            style: ['background-color:RGB(0, 191, 245); color:white', 'RGB(0, 191, 245)'],
            guide : 3,
            more : true,
            fix : true
        });
        tips_ids[name] = layer_id;
    }

    function _close_error_tips(dom, tips_ids) {
        var name = dom.getAttribute('name');
        if (!tips_ids[name]) {
            return;
        }
        layer.close(tips_ids[name]);
        delete tips_ids[name];
    }

})

