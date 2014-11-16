<?php if (isset($_GET['jQueryCallback'])):?>
<?=$_GET['jQueryCallback']?>({"errno" : <?=$error['errorCode']?>, "msg" : "", "data" : <?=json_encode($error)?>})
<?php else:?>
{"errno" : <?=$error['errorCode']?$error['errorCode']:$error['code']?>, "msg" : "系统错误", "data" : <?=json_encode($error)?>}
<?php endif?>