<br/>
<div style="font-size:14px;">
主播昵称/ID:&nbsp;&nbsp;&nbsp;<input class="easyui-textbox" name="idOrNickname" style="margin-left:10px" id="idOrNickname"/>
<a class="easyui-linkbutton" data-options="iconCls:'icon-search'" style="margin-left:10px" onclick="searchM();">搜索</a>
</div>
<br/>
<br/>
<table class="easyui-datagrid" style="width:840px;"
            data-options="singleSelect:true,url:'/moderator/getModerators',method:'get',pagination:true,
                pageSize:20" id="dg">
    <thead>
    <tr>
        <th data-options="field:'id',width:60">房间号</th>
        <th data-options="field:'mid',width:60">主播ID</th>
        <th data-options="field:'nicknameLink',width:120">昵称</th>
        <th data-options="field:'mobile',width:80">手机</th>
        <th data-options="field:'height_weight_age',width:120">身高/体重/年龄</th>
        <th data-options="field:'logoImage',width:80">照片</th>
        <th data-options="field:'moderator_desc',width:300">主播介绍</th>
    </tr>
    </thead>
</table>

<div id="win" class="easyui-window" title="查看照片" style="width:370px;height:225px"
        data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,draggable:false,resizable:false,">
    <center><img src="" width=345 height=184/></center>
</div>

<div id="detailWin" class="easyui-window" title="主播详情" style="width:800px;height:630px"
        data-options="modal:true,closed:true,collapsible:false,minimizable:false,maximizable:false,draggable:false,resizable:false,">

<form id="ff" method="post" enctype="multipart/form-data" style="font-size:14px">
    <input type="hidden" name="rid"/>
    <table style="font-size:14px" cellspacing="12">
        <tr>
            <td width=80>主播昵称:</td>
            <td><input class="easyui-textbox" type="text" name="nickname" data-options="required:true"/></td>
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
                <input class="easyui-filebox" name="logo" data-options="prompt:'选择图片'" style="width:200px" id="logo">
                <span>（尺寸：236×130）</span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><img height=80 width=150 src="" id="logoImage"/></td>
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

<a class="easyui-linkbutton" data-options="iconCls:'icon-ok'" href="javascript:void(0)" style="width:80px;margin-left:18px" onclick="modifyM()">确认修改</a>

</div>


<script>

$('#dg').datagrid({loadFilter:loadFilter});

function loadFilter(data) {
    rows = data.rows;
    for (var i in data.rows) {
        data.rows[i].height_weight_age = data.rows[i].height + '/' + data.rows[i].weight + '/' + data.rows[i].age;
        data.rows[i].nicknameLink = '<a href="javascript:void(0)" onclick="viewDetail(' + i + ')">' + data.rows[i].nickname+ '</a>';
        data.rows[i].logoImage = '<img src="' + data.rows[i].logo + '" width=30 height=16 onclick="viewImg(' + i + ');" style="cursor:pointer"/>';
    }
    return data;
}

function viewDetail(i) {
    row = rows[i];
    $("#detailWin").window('open');
    $("#ff").form('load', {
        rid : row.id,
        nickname : row.nickname,
        age : row.age,
        height : row.height,
        weight : row.weight,
        moderator_desc : row.moderator_desc,
        announcement : row.announcement,
        rank : row.rank,
        true_name : row.true_name,
        salary_per_hour : row.salary_per_hour,
        alipay_account : row.alipay_account,
        sociaty_id : row.sociaty_id,
        mobile : row.mobile,
        qq : row.qq
    });
    $("#logo").textbox('reset');
    $("#logoImage").attr('src', row.logo);
}

function viewImg(i) {
    $("#win img").attr('src', rows[i].logo);
    $("#win").window('open');
}

function searchM() {
    $("#dg").datagrid('load', {
        mid : $("#idOrNickname").val()
    });
}

function modifyM() {
    $("#ff").form('submit', {
        url : '/moderator/modify',
        success : function(resp) {
            var ret = eval('(' + resp + ')');
            if (ret.errno) {
                alert(ret.msg);
                return;
            }
            alert('修改成功')
        }
    })
}

</script>



