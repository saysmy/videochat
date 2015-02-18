<?php
class CRoom {
    static public function getSendMaxPricePropInfo($rid) {
        return json_decode(Yii::app()->cache->get(self::getSendMaxPricePropInfoKey($rid)), true);
    }

    static public function setSendMaxPricePropInfo($rid, $info) {
        return Yii::app()->cache->set(self::getSendMaxPricePropInfoKey($rid), json_encode($info));
    }

    static public function getOnlineNum($rid) {
        $key = 'room_' . $rid . '_user';
        $num = Yii::app()->cache->get($key);
        if (!$num) {
            return 0;
        }
        return (int)$num;
    }

    static public function setOnlineNum($num, $rid) {
        $key = 'room_' . $rid . '_user';
        Yii::app()->cache->set($key, $num);
    }

    static public function setPublishMid($mid, $rid) {
        $key = 'room_' . $rid . '_pub';
        Yii::app()->cache->set($key, $mid);
    }

    static public function getPublishMid($rid) {
        $key = 'room_' . $rid . '_pub';
        $mid = Yii::app()->cache->get($key);
        if (!$mid) {
            return ROOM_PUB_NOBODY_UID;
        }
        return (int)$mid;
    }

    static public function dirtyFilter($msg) {

        $dirtyWords = require(CONFIG_DIR . 'dirtyWords.php');

        return str_replace(array_keys($dirtyWords), array_values($dirtyWords), $msg);
    }

    static public function addAdmin($rid, $auid) {
        $room = Room::model()->findByPk($rid);
        if (!$room) {
            return false;
        }
        $admin = json_decode($room->admin, true);
        $admin = $admin ? $admin : array();
        if (!in_array($auid, $admin)) {
            $admin[] = $auid;
            $room->admin = json_encode($admin);
            if ($room->update()) {
                return true;
            }
            else {
                return false;
            }
        }
        return true;
    }

    static private function getSendMaxPricePropInfoKey($rid) {
        return 'room_' + $rid + '_prop_max';
    }


}