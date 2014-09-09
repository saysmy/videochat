<?php
class CRoom {
    static public function getSendMaxPricePropInfo($rid) {
        return json_decode(Yii::app()->cache->get(self::getSendMaxPricePropInfoKey($rid)), true);
    }

    static public function setSendMaxPricePropInfo($rid, $info) {
        return Yii::app()->cache->set(self::getSendMaxPricePropInfoKey($rid), json_encode($info));
    }

    static private function getSendMaxPricePropInfoKey($rid) {
        return 'room_' + $rid + '_prop_max';
    }

}