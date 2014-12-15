<?php
Class ToolUtils {
    
    static public function ajaxOut($errno, $msg = '', $data = array()) {
        if (isset($_GET['jQueryCallback'])) {
            echo $_GET['jQueryCallback'] . '(' . json_encode(array('errno' => $errno, 'msg' => $msg, 'data' => $data)) . ')';
        }
        else {
            echo json_encode(array('errno' => $errno, 'msg' => $msg, 'data' => $data));
        }
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

    static public function appendArgv($url, $argv) {
        if (!is_array($argv) || count($argv) == 0) {
            return $url;
        }
        if (strpos($url, '?') !== false) {
            foreach($argv as $k => $v) {
                $url .= '&' . $k . '=' . urlencode($v);
            }
        }
        else {
            $url .= '?';
            foreach($argv as $k => $v) {
                $url .= $k . '=' . urlencode($v) . '&';
            }
            substr($url, 0, -1);
        }
        return $url;
    }

    static public function frequencyCheck($id, $second) {
        $value = Yii::app()->cache->get($id);
        if (!$value || microtime(true) - $value > $second) {
            Yii::app()->cache->set($id, microtime(true));
            return true;
        }
        else {
            return false;
        }
    }
}