define(function(require, exports) {
    //获取公钥
    exports.getPublicKey = function(callback) {
        var url = '/user/getPublicKey';
        if ($('body').data('session_id')) {
            url += '/session_id/' + $('body').data('session_id');
        }
        $.ajax({
            url : url + '?r=' + Math.random(),
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

    exports.addFavorite =function(sURL, sTitle)
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
                alert("加入收藏失败，请使用Ctrl+D进行添加");
            }
        }
    }

    exports.appendArgv = function(url, argvs) {
        if (url.indexOf('?') != -1) {
            for (var name in argvs) {
                url += '&' + name + '=' + encodeURIComponent(argvs[name]);
            }
        }
        else {
            url += '?';
            for (var name in argvs) {
                url += name + '=' + encodeURIComponent(argvs[name]) + '&';
            }
            url = url.substring(0, url.length -1);
        }
        return url;

    }
    
    exports.domain = 'www.efeizao.com';
})