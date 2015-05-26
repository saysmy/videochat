<?php
class RoomController extends CController {

    public function filters() {
        return array(
            array(
                'application.filters.LoginFilter + love + userReport',
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
        $ret['loved'] = false;
        $ret['gifts'] = array();
        foreach($gifts as $gift) {
            $giftArr = $gift->getAttributes();
            $giftArr['id'] = (int)$giftArr['id'];
            $giftArr['price'] = (float)$giftArr['price'];
            $giftArr['img'] = 'http://' . DOMAIN . $giftArr['img'];
            $giftArr['imgPreview'] = 'http://' . DOMAIN . $giftArr['imgPreview'];
            $ret['gifts'][] = $giftArr;
        }

        $uid = CUser::checkLogin();
        if ($uid) {
            if (LoveRoom::model()->findAll('uid=' . $uid . ' and rid=' . $rid)) {
                $ret['loved'] = true;
            }

        }

        $ret['moderator_desc'] = $room->moderator_desc;
        $ret['logo'] = $room->logo;
        $ret['flowerNumber'] = (int)$room->flower_number;
        $ret['isPlaying'] = CRoom::isPlaying($room->id);
        $ret['moderator'] = array('weight' => (int)$room->moderator->weight, 'height' => (int)$room->moderator->height, 'age' => (int)$room->moderator->age, 'true_name' => $room->moderator->true_name, 'nickname' => $room->moderator->nickname, 'id' => (int)$room->moderator->id);
        
        //消费排行
        $ret['consumeRankList'] = Yii::app()->db->createCommand('select sum(cost) as acost, user.nickname, user.id, user.head_pic_1, user.vip_start, user.vip_end from consume inner join user on user.id = consume.uid  where consume.mid=' . $room->mid . ' group by consume.uid order by acost desc')->query()->readAll();
        foreach($ret['consumeRankList'] as &$item) {
            if (strtotime($item['vip_start']) <= time() && strtotime($item['vip_end']) >= time()) {
                $item['isVip'] = true;
            }
            else {
                $item['isVip'] = false;
            }
        }

        ToolUtils::ajaxOut(0, '', $ret);    
    }

    //举报
    public function actionUserReport($rid, $type) {
        $uid = CUser::checkLogin();

        if (!ToolUtils::frequencyCheck('room_user_report_' . $uid, 60)) {
            return ToolUtils::ajaxOut(301, '操作过于频繁');
        }

        $report = new RoomReport;
        $report->uid = $uid;
        $report->rid = $rid;
        $report->type = $type;
        $report->add_time = date("Y-m-d H:i:s");
        if (!$report->save()) {
            return ToolUtils::ajaxOut(300, current(current($report->getErrors())));
        }

        ToolUtils::ajaxOut(0);
    }

}