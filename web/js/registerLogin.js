define('registerLogin', ['user', 'rsa', 'layer', 'common', 'validate'], function(require, exports, module) {
    var register_tips_ids = {};
    var login_tips_ids = {};
    var user = require('user');
    var rsa = new (require('rsa').RSA);
    var common = require('common');
    var layer = require('layer');
    // common.getPublicKey(function(key){rsa.setPublicKey});

    $('.goQQLogin').click(function() {
        user.qqLogin(registerLogin.qqLoginUrl);
        return false;
    })

    var isRegistering = false;
    $('#register-form').validate({
        errorClass : 'validate-error',
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
                minlength : '密码至少为6个字符'
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
        showErrors : function(map, list) {
            $('#register-error').text(list.length ? list[0].message : '');
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
                            setTimeout(function(){top.location.reload()}, 2000);
                        }
                        else {
                            $('#register-captcha').click();
                            for (var name in ret.data) {
                                layer.alert(ret.data[name]);break;
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
        errorClass : 'validate-error',
        rules : {
            username : 'required',
            password : 'required'
        },
        messages : {
            username : '用户名不能为空',
            password : '密码不能为空'
        },
        showErrors : function() {},
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
                            setTimeout(function(){top.location.reload()}, 2000);
                        }
                        else if (ret.errno == 400){
                            for (var name in ret.data) {
                                layer.alert(ret.data[name]);break;
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

    $(".overlay-loginBtn").click(function(){
        $("#overlay-login").css({"display":"block"});
        $("#overlay-reg").css({"display":"none"});

        return false; 
    });
    $(".overlay-regBtn").click(function(){

        _clear_auto_complete();

        $("#overlay-reg").css({"display":"block"});
        $("#overlay-login").css({"display":"none"});

        return false;
    });

    $(".close").click(function() {
        var index = parent.layer.getFrameIndex(window.name);
        parent.layer.close(index);
    })

    function _clear_auto_complete() {
        if (
            $('#register-form input[name=username]').val() == $('#login-form input[name=username]').val() &&
            $('#register-form input[name=password]').val() == $('#login-form input[name=password]').val()
        ) {
            $('#register-form input[name=username]').val('');
            $('#register-form input[name=password]').val('');
        }
    }
})

