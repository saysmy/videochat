define(function(require, exports) {
    //获取公钥
    exports.getPublicKey = function(callback) {
        $.ajax({
            url : '/user/getPublicKey?r=' + Math.random(),
            dataType : 'json',
            success : function(resp) {
                if (resp.errno) {
                    return;
                }
                callback && callback(resp.data);
                
            }
        })
    }

    exports.buttonTextLoading = function(input, text) {
        $(input).css('cursor', 'default');
        input.value = text
        var t = 1;
        var fd = setInterval(function() {
            input.value = text;
            for (var i = 0; i < t; i++) {
                input.value += ".";
            };
            if (t == 3) {
                t = 1;
            }
            else {
                t ++;
            }
        }, 500)
        input.fd = fd;  
    }
    exports.stopButtonTextLoading = function(input, text) {
        $(input).css('cursor', 'pointer');
        clearInterval(input.fd);
        input.value = text;
    }
})