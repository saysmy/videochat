<?php
$e = array(
    'errno' => isset($error['errorCode']) && $error['errorCode'] ? $error['errorCode'] : SYSTEM_ERR,
    'msg' => $error['message'],
);
echo json_encode($e);