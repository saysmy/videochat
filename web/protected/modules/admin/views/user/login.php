<div style="width:400px;margin:auto">
<div class="easyui-panel" title="登陆" style="width:400px;">
<form method="post" action="checkPassword" id="ff" style="text-align:center">
    <br/>
    <label for="password">密码：</label><input class="easyui-textbox" type="password" name="password" data-options="required:true"></input>
    <br/>
    <br/>
    <a href="javascript:void(0)" class="easyui-linkbutton" onclick="submitForm()">登陆</a>
</form>
</div>
</div>
<script>

function submitForm() {
    $('#ff').form('submit', {
        success : function(ret) {
            var ret = eval('(' + ret + ')');
            if (ret.errno == 0) {
                location.href = ret.data.redirect;
            }
            else {
                alert(ret.msg);
            }
        }
    });
}
</script>