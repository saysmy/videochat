<?php
Class ToolUtils {
    
    static public function ajaxOut($errno, $msg = '', $data = array()) {
        echo json_encode(array('errno' => $errno, 'msg' => $msg, 'data' => $data));
    }

    static public function getFileExt($file) {
        $extend =explode("." , $file);
        return array_pop($extend);
    }

    static public function getUrlFromPath($path) {
        $path = realpath($path);
        return 'http://' . DOMAIN . '/' . str_replace(WEB_ROOT, '', $path);
    }

    static public function getPathFromUrl($url) {
        $path = str_replace('http://' . DOMAIN . '/', '', $url);
        return realpath($path);
    }

    static public function getCurrentUrl() {
        return 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
}