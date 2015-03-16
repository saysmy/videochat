<?php
$e = array(
    'error' => isset($error['errorCode']) && $error['errorCode'] ? $error['errorCode'] : SYSTEM_ERR,
    'msg' => $error['message'],
);
echo json_encode($e);