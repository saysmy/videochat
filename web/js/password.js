define(['rsa', 'common'], function(require) {
    var rsa = new (require('rsa').RSA);
    var common = require('common');
    $(document.body).ready(function() {
        $('#passwordModify').click(function() {
            var password = $.trim($('#password').val());
            var newPassword = $.trim($('#newPassword').val());
            var newPasswordRepeat = $.trim($('#newPasswordRepeat').val());
            if (!password) {
                return layer.alert('密码不能为空');
            };
            if (!newPassword) {
                return layer.alert('新密码不能为空');
            };
            if (newPasswordRepeat != newPassword) {
                return layer.alert('两次密码不一致');
            };
            var button = this;
            common.buttonTextLoading(button, '修改中');
            common.getPublicKey(function(key) {
                rsa.setPublicKey(key);
                $.ajax({
                    url : '/user/updatePassword',
                    type : 'post',
                    data : {"password" : rsa.encrypt(password), "newPassword" : rsa.encrypt(newPassword), "newPasswordRepeat" : rsa.encrypt(newPasswordRepeat)},
                    dataType : 'json',
                    success : function(resp) {
                        common.stopButtonTextLoading(button, '确认修改');
                        if (resp.errno) {
                            return layer.alert(resp.msg);
                        };
                        layer.msg('密码修改成功', 3, 1);
                        setTimeout(function() {location.reload()}, 3000);
                    }
                })
            })
        })

    })
})