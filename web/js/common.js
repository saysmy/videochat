define('common', ['layer'], function(require, exports) {
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

    exports.showContentWin = function(content, width, height) {
        return $.layer({
            type: 1,
            shadeClose: false,
            title: false,
            border: [0],
            area: [width + 'px', height + 'px'],
            page : {
                html : content
            }
        });
    }

    exports.createSWF = function(swf, placehoder, flashvars, attributes){
        var swfVersionStr = "11.1.0";
        var xiSwfUrlStr = "playerProductInstall.swf";
        var params = {};
        params.wmode = "transparent";
        params.quality = "high";
        params.bd = "2000000";
        params.allowscriptaccess = "sameDomain";
        attributes.id = placehoder;
        attributes.name = placehoder;
        attributes.align = "middle";
        swfobject.embedSWF('/swf/' + swf+".swf?v=0.23", placehoder, attributes.width, attributes.height, swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
    }

    exports.include = function(file) {
        var files = typeof file == "string" ? [file]:file;
        for (var i = 0; i < files.length; i++) {
            var name = files[i].replace(/^\s+|\s+$/g, "");
            var att = name.split('.');
            var ext = att[att.length - 1].toLowerCase();
            var isCSS = ext == "css";
            var tag = isCSS ? "link" : "script";
            var attr = isCSS ? " type='text/css' rel='stylesheet' " : " language='javascript' type='text/javascript' ";
            var link = (isCSS ? "href" : "src") + "='" + name + "'";
            if ($(tag + "[" + link + "]").length == 0) $(document.head).append("<" + tag + attr + link + "></" + tag + ">");
        }

    }    
    // exports.domain = 'www.efeizao.com';
})