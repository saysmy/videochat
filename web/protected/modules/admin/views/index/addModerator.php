
<!--
<a href="javascript:void(0)" class="easyui-linkbutton" onclick="$('#w').window('open')">新增主播</a>
-->

<div id="w" class="easyui-window" title="新增主播" data-options="iconCls:'icon-save',minimizable:false,modal:true,closed:false,collapsible:false,resizable:false" style="width:400px;height:520px;padding:5px;">
<div class="easyui-layout" data-options="fit:true">
    <div data-options="region:'center'">
    <form id="ff" method="post" enctype="multipart/form-data">
        <table style="font-size:14px">
            <tr>
                <td>主播昵称:</td>
                <td><input class="easyui-textbox" type="text" name="nickname" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>真实姓名:</td>
                <td><input class="easyui-textbox" type="text" name="true_name" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>身高:</td>
                <td><input class="easyui-textbox" type="text" name="height" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>体重:</td>
                <td><input class="easyui-textbox" type="text" name="weight" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>年龄:</td>
                <td><input class="easyui-textbox" type="text" name="age" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>主播介绍:</td>
                <td><input class="easyui-textbox" type="text" name="moderator_desc" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>房间图片:</td>
                <td><input class="easyui-filebox" name="logo" data-options="prompt:'选择图片',required:true" style="width:100%"></td>
            </tr>
             <tr>
                <td>房间公告:</td>
                <td><input class="easyui-textbox" type="text" name="announcement" data-options="multiline:true,required:true" style="height:60"/></td>
            </tr>
             <tr>
                <td>房间描述:</td>
                <td><input class="easyui-textbox" type="text" name="description" data-options="multiline:true,required:true" style="height:60"/></td>
            </tr>
             <tr>
                <td>房间排序值:</td>
                <td><input class="easyui-textbox" type="text" name="rank" data-options="required:true"/></td>
            </tr>
            <tr>
                <td>每小时工资:</td>
                <td><input class="easyui-textbox" type="text" name="salary_per_hour" data-options="required:true"/></td>
            </tr>
             <tr>
                <td>手机:</td>
                <td><input class="easyui-textbox" type="text" name="mobile"/></td>
            </tr>
            <tr>
                <td>qq:</td>
                <td><input class="easyui-textbox" type="text" name="qq"/></td>
            </tr>
        </table>
    </form>
    </div>
    <div data-options="region:'south',border:false" style="text-align:right;padding:5px 0px 0px">
                <a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" href="javascript:void(0)" onclick="add();" style="width:80px">新增</a>
    </div>
</div>

<script>

function add() {
    $("#ff").form('submit', {
        url : '/admin/moderator/add',
        success:function(data) {
            data = eval('(' + data + ')');
            if (data.errno != 0) {
                alert(data.msg);
            }
            else {
                alert('新增成功');
                $("#ff").form('reset');
            }
        }
    })

}

</script>


