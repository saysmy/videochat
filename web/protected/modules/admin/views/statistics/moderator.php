<form id="ff">
<br/>
<label>主播姓名：</label><input id="true_name" class="easyui-textbox" type="text" name="true_name" data-options="required:true"></input>
&nbsp;&nbsp;<a href="javascript:void(0)" class="easyui-linkbutton" onclick="query()">查询</a>
<br/>
</form>

<table class="easyui-datagrid" title="主播发布列表" style="width:700px;"
            data-options="singleSelect:true,url:'getModeratorPublishList',method:'get'" id="publistListTable">
    <thead>
        <tr>
            <th data-options="field:'mid',width:80">主播ID</th>
            <th data-options="field:'rid',width:80">房间号</th>
            <th data-options="field:'startTime',width:200">开始时间</th>
            <th data-options="field:'endTime',width:200">结束时间</th>
        </tr>
    </thead>
</table>

<br/>

<table class="easyui-datagrid" title="主播收到的礼物" style="width:700px;"
            data-options="singleSelect:true,url:'getModeratorGiftList',method:'get'" id="giftListTable">
    <thead>
        <tr>
            <th data-options="field:'mid',width:80">主播ID</th>
            <th data-options="field:'senderNickname',width:120">赠送人</th>
            <th data-options="field:'giftName',width:100">礼物名称</th>
            <th data-options="field:'giftNum',width:80">礼物个数</th>
            <th data-options="field:'giftCost',width:80">价值</th>
            <th data-options="field:'sendTime',width:150">赠送时间</th>
        </tr>
    </thead>
</table>

<script>
function query() {
    if (!$("#ff").form('validate')) {
        return;
    }
    $('#publistListTable').datagrid('load', {
        moderatorTrueName : $('#true_name').val()
    })

    $('#giftListTable').datagrid('load', {
        moderatorTrueName : $('#true_name').val()
    })
}
</script>
