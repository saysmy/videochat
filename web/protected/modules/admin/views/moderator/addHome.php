
<form id="ff" method="post" enctype="multipart/form-data" style="font-size:14px">
    <table style="font-size:14px" cellspacing="12">
        <tr>
            <td width=80>主播ID:</td>
            <td><input class="easyui-textbox" type="text" name="mid" data-options="required:true" id="mid"/></td>
        </tr>
        <tr>
            <td colspan=2>
                <span style="margin-right:30px;">身高:</span>
                <span style="margin-right:50px">
                    <select class="easyui-combobox" name="height" style="width:80px" data-options="required:true">
                        <?php
                            for ($i = 158; $i <= 198; $i ++) {
                                echo "<option value='$i' " . ($i == 173 ? 'selected' : '') . ">$i</option>";
                            }
                        ?>
                    </select>
                </span>

                <span style="margin-right:30px;">年龄:</span>
                <span style="margin-right:50px">
                    <select class="easyui-combobox" name="age" style="width:80px" data-options="required:true">
                         <?php
                            for ($i = 16; $i <= 50; $i ++) {
                                echo "<option value='$i' " . ($i == 20 ? 'selected' : '') . ">$i</option>";
                            }
                        ?>                       
                    </select>
                </span>

                <span style="margin-right:30px;">体重:</span>
                <span style="margin-right:50px">
                    <select class="easyui-combobox" name="weight" style="width:80px" data-options="required:true">
                         <?php
                            for ($i = 45; $i <= 95; $i ++) {
                                echo "<option value='$i' " . ($i == 60 ? 'selected' : '') . ">$i</option>";
                            }
                        ?>                       
                    </select>
                </span>
            </td>
        </tr>
        <tr>
            <td>主播照片:</td>
            <td>
                <input class="easyui-filebox" name="logo" data-options="prompt:'选择图片',required:true" style="width:200px">
                <span>（尺寸：236×130）</span>
            </td>
        </tr>
        <tr>
            <td>主播介绍:</td>
            <td><input class="easyui-textbox" type="text" name="moderator_desc" data-options="multiline:true,required:true" style="height:60px;width:200px"/></td>
        </tr>
        <tr>
            <td>房间公告:</td>
            <td><input class="easyui-textbox" type="text" name="announcement" data-options="multiline:true,required:true" style="height:60px;width:200px"/></td>
        </tr>
         <tr>
            <td>房间描述:</td>
            <td><input class="easyui-textbox" type="text" name="description" data-options="multiline:true,required:true" style="height:60px;width:200px" value="【千万情意，唯独为你】肥皂—中国最大的华裔美少年の社区"/></td>
        </tr>
        <tr>
            <td>房间排序值:</td>
            <td><input class="easyui-textbox" type="text" name="rank" data-options="required:true"/></td>
        </tr>
        <tr>
            <td>真实姓名:</td>
            <td><input class="easyui-textbox" type="text" name="true_name" data-options="required:true"/></td>
        </tr>
        <tr>
            <td>每小时工资:</td>
            <td><input class="easyui-textbox" type="text" name="salary_per_hour" data-options="required:true"/></td>
        </tr>
        <tr>
            <td colspan=2>
                <div style="float:left;width:94px">支付宝:</div>
                <div style="float:left"><input class="easyui-textbox" type="text" name="alipay_account" data-options="required:true"/></div>
                <span style="float:left;width:80px;margin-left:50px">所属公会:</span>
                <span style="float:left">
                    <select class="easyui-combobox" type="text" name="sociaty_id" style="width:135px" data-options="required:true">
                        <option value="0">无</option>
                        <?php
                            foreach($sociaties as $sociaty) {
                                echo "<option value='{$sociaty->id}'>{$sociaty->name}</option>";
                            }
                        ?>
                    </select>
                </span>
            </td>
        </tr>
        <tr>
            <td colspan=2>
                <div style="float:left;width:94px">手机:</div>
                <div style="float:left"><input class="easyui-textbox" type="text" name="mobile"/></div>
                <span style="float:left;width:80px;margin-left:50px">QQ:</span>
                <span style="float:left"><input class="easyui-textbox" type="text" name="qq"/></span>
            </td>
        </tr>
    </table>
</form>

<a href="javascript:void(0)" class="easyui-linkbutton" data-options="iconCls:'icon-save'" onclick="add();" style="margin-left:12px">提交</a>

<script>

function add() {
    if ($("#ff").form('validate')) {
        $.get('/moderator/getInfo', { mid : $('#mid').val() }, function(resp) {
            var ret = eval('(' + resp + ')');
            if (ret.errno) {
                alert(ret.msg);
                return;
            }
            if (confirm("确定添加主播：" + ret.data.nickname)) {
                $("#ff").form('submit', {
                    url : '/moderator/add',
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
        })
    }
}

</script>


