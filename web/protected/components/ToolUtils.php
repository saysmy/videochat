<?php
Class ToolUtils {
    static public $errCode;
    static public $errMsg;
    
    static public function ajaxOut($errno, $msg = '', $data = array()) {
        echo json_encode(array('errno' => $errno, 'msg' => $msg, 'data' => $data));
    }
}