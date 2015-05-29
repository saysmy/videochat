<div class="easyui-layout" style="width:100%;height:100%;">
        <div data-options="region:'north'" style="height:50px">
            <h2>肥皂网络管理后台</h2>
        </div>
        <div data-options="region:'west',split:true" title="菜单" style="width:150px">
            <ul id="tree" class="easyui-tree" url="/index/tree">
            </ul>
        </div>
        <div data-options="region:'center',iconCls:'icon-ok'">
            <div class="easyui-tabs" style="width:100%;height:auto" data-options="border:false" id="tabs">
                <div title="欢迎" style="padding:10px">
                </div>
            </div>
        </div>
</div>

<script>
$("#tree").tree({
    onClick : function(node) {
        if (!node.url) {
            return;
        }
        
        loadData(node.url, node.text);
    }
})

function loadData(url, text) {
    $.get(url, {}, function(data) {
        $('#tabs').tabs('update', {
            tab : $('#tabs').tabs('getTab', 0),
            options : {
                title : text,
                content : data
            }
        });
    })
}

</script>