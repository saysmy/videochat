define(['layer'], function(require, exports, module) {
    var layer = require('layer');
    exports.qqLogin = function(loginUrl) {
        var width = 700;
        var height = 500;
        var win = window.screen,left=(win.width- width)/2,top=(win.height - height - 60)/2;
        try{
            window.external.openLoginWindow('{"title":"QQ登录","from":"LoginUi","to":"Loginer","cmd":"openLoginWindow","ThirdUrl":"' + loginUrl + '","nWndWidth":'+width+',"nWndHeight":'+width+"}");
        }catch(s){
            window.open(loginUrl,"letv_coop_login","toolbar=0,status=0,resizable=1,width="+width+",height="+height+",left="+(left>0?left:0)+",top="+(top>0?top:0));
        }          
    }
    exports.getUserInfo = function(callback) {
        $.ajax({
            url : '/user/getUserInfo',
            dataType : 'json',
            success : function(resp) {
                callback(resp);
            }
        })
    }

    exports.showRegisterPanel = function() {
        var layer_id = $.layer({
            type: 2,
            shadeClose: true,
            title: false,
            closeBtn: [0, false],
            shade: [0.8, '#000'],
            border: [0],
            area: ['675px', '465px'],
            iframe: {src: '/user/showRegister'}
        });
        return false;
    }

    exports.showLoginPanel = function() {
        var layer_id = $.layer({
            type: 2,
            shadeClose: true,
            title: false,
            closeBtn: [0, false],
            shade: [0.6, '#000'],
            border: [0],
            area: ['675px', '465px'],
            iframe: {src: '/user/showLogin'}
        }); 
        return false;
    }
})