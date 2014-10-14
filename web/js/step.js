define(['layer', 'validate', 'registerLogin'], function(require) {
    //step1
    var registerLogin = require('registerLogin');

    $('#step1Next').click(function() {
        $.ajax({
            url : '/recruitment/postStep/step/1',
            type : 'post',
            dataType : 'json',
            success : function(resp) {
                if (resp.errno) {
                    if (resp.errno == -100) {
                        return registerLogin.showLoginPanel();
                    };
                    layer.alert(resp.msg);
                }
                else {
                    location.href = 'step2';
                }
            }
        })
    })

    //step2
    $('#step2Form').validate({
        errorClass : 'validate-error',
        rules : {
            name : 'required',
            age : 'required',
            weight : 'required',
            height : 'required',
            id_card : {
                required : true,
                rangelength : [18,18],
                number : true
            },
            qq : {
                required : true,
                minlength : 5,
                number : true,
            },
            email : {
                required : true,
                email : true
            },
            mobile : {
                required : true,
                rangelength : [11,11],
                number : true
            }
        },
        messages : {
            name : '姓名不能为空',
            age : '年龄不能为空',
            weight : '体重不能为空',
            height : '身高不能为空',
            id_card : {
                required : '身份证号码不能为空',
                rangelength : '身份证号码必须为18位',
                number : '身份证号码不正确'
            },
            qq : {
                required : 'QQ号码不能为空',
                minlength : 'QQ号码至少5位',
                number : 'QQ号码格式不正确'
            },
            email : {
                required : '邮箱不能为空',
                email : '邮箱格式不正确'
            },
            mobile : {
                required : '手机号不能为空',
                rangelength : '手机号必须为11位',
                number : '手机号格式不正确'
            }
        },
        submitHandler : function() {
            var data = {};
            $('.recruitment-content input[type=text][name]').each(function() {
                data[this.name] = $.trim(this.value);
            })
            $('.recruitment-content select[name]').each(function() {
                data[this.name] = $.trim(this.value)
            })
            $.ajax({
                url : '/recruitment/postStep/step/2',
                data : data,
                type : 'post',
                dataType : 'json',
                success : function(resp) {
                    if (resp.errno) {
                        if (resp.errno == -100) {
                            return registerLogin.showLoginPanel();
                        };
                        layer.alert(resp.msg);
                    }
                    else {
                        location.href = 'step3';
                    }
                }
            })        
        }
    })

    //step3
    var loadingId = 0;
    var uploader = new plupload.Uploader({
        runtimes : 'html5,flash,silverlight,html4',
        browse_button : 'addRecPic', // you can pass in id...
        // container: document.getElementById('addPic'), // ... or DOM Element itself
        url : '/user/uploadPic',
        flash_swf_url : '/js/plupload/Moxie.swf',
        silverlight_xap_url : '/js/plupload/Moxie.xap',
        
        filters : {
            max_file_size : '3mb',
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

                var li = $('<li class="list-item"><span class="closeImg">x</span><a><img src="' + url + '"></a></li>');
                li.find('.closeImg').click(function() {
                    li.remove();
                    layoutImageList();
                })
                $('#addRecPic').before(li);
                layoutImageList(); 
            },

            Error: function(up, err) {
                layer.close(loadingId);
                layer.alert('上传文件出错', 8);

            }
        }
    });
    uploader.init(); 

    $('.upList .list-item').each(function() {
        var me = this;
        $(this).find('.closeImg').click(function() {
            $(me).remove();
            layoutImageList();
        })
    })

    function layoutImageList() {
        $('.upList .list-item').css("margin-right", "40px");
        $('.upList .list-item:nth-child(4n)').css("margin-right", "0px");    
    }

    $('#step3Next').click(function() {
        var images = [];
        $('.upList .list-item img').each(function() {
            images.push($(this).attr('src'));
        })
        if (images.length == 0) {
            return layer.alert("请上传照片");
        };
        $.ajax({
            url : '/recruitment/postStep/step/3',
            data : {images : images},
            type : 'post',
            dataType : 'json',
            success : function(resp) {
                if (resp.errno) {
                    if (resp.errno == -100) {
                        return registerLogin.showLoginPanel();
                    };
                    layer.alert(resp.msg);
                }
                else {
                    location.href = 'step4';
                }
            }
        })        
    }) 

    //step4
    $('#step4Next').click(function() {
         $.ajax({
            url : '/recruitment/postStep/step/4',
            type : 'post',
            dataType : 'json',
            success : function(resp) {
                if (resp.errno) {
                    if (resp.errno == -100) {
                        return registerLogin.showLoginPanel();
                    };
                    layer.alert(resp.msg);
                }
                else {
                    location.href = '/';
                }
            }
        })       
    })

})