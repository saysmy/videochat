<?php
class CRoom {
    static public function getSendMaxPricePropInfo($rid) {
        return json_decode(Yii::app()->cache->get(self::getSendMaxPricePropInfoKey($rid)), true);
    }

    static public function setSendMaxPricePropInfo($rid, $info) {
        return Yii::app()->cache->set(self::getSendMaxPricePropInfoKey($rid), json_encode($info));
    }

    static public function dirtyFilter($msg) {

        $dirtyWords = require(CONFIG_DIR . 'dirtyWords.php');

        return str_replace(array_keys($dirtyWords), array_values($dirtyWords), $msg);
    }

    static private function getSendMaxPricePropInfoKey($rid) {
        return 'room_' + $rid + '_prop_max';
    }

}