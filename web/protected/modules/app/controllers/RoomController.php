<?php
class RoomController extends CController {

    public function filters() {
        return array(
            array(
                'application.filters.LoginFilter + love',
            ),
        );  
    }

    public function actionLove($rid) {
        if (!ToolUtils::frequencyCheck('loveRoom', 0.5)) {
            return ToolUtils::ajaxOut(FREQUENCY_ERR, '操作过于频繁');
        }

        $uid = CUser::checkLogin();

        $room = Room::model()->findByPk($rid);
        if (!$room) {
            return ToolUtils::ajaxOut(100, '房间不存在');
        }

        $record = LoveRoom::model()->find('uid=' . $uid . ' and rid=' . $rid);

        if (!$record) {
            $record = new LoveRoom;
            $record->uid = $uid;
            $record->rid = $rid;
            $record->add_time = Date('Y-m-d H:i:s');
            if ($record->save()) {
                $room->love_num ++;
                $room->update();
                return ToolUtils::ajaxOut(0, '关注成功', array('action' => 'love'));
            }
            else {
                return ToolUtils::ajaxOut(101, '关注失败');
            }
        }
        else {
            $record->delete();
            $room->love_num --;
            $room->update();
            return ToolUtils::ajaxOut(0, '取消关注成功', array('action' => 'cancel'));
        }
    }

    public function actionGetInfo($rid) {
        $room = Room::model()->findByPk($rid);
        if (!$room) {
            return ToolUtils::ajaxOut(200, '房间不存在');
        }
        $gifts = Property::model()->findAll();
        $ret['id'] = (int)$room->id;
        $ret['love'] = (int)$room->love_num;
        $ret['gifts'] = array();
        foreach($gifts as $gift) {
            $giftArr = $gift->getAttributes();
            $giftArr['id'] = (int)$giftArr['id'];
            $giftArr['price'] = (float)$giftArr['price'];
            $giftArr['img'] = 'http://' . DOMAIN . $giftArr['img'];
            $giftArr['imgPreview'] = 'http://' . DOMAIN . $giftArr['imgPreview'];
            $ret['gifts'][] = $giftArr;
        }

        ToolUtils::ajaxOut(0, '', $ret);    
    }

}