<?php
class StatisticsController extends CController {

    public function actionModerator() {

        $rooms = Room::model()->findAll('mid > 0');
        $users = array();
        foreach($rooms as $room) {
            $users[$room->moderator->id] = $room->moderator->true_name;
        }

        $this->renderPartial('moderator', array('users' => $users));
    }

    public function actionGetModeratorPublishList($mid, $startTime, $endTime) {
        $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        $endTime = date('Y-m-d H:i:s', strtotime($endTime) + 86400 - 1);

        if ($mid) {
            $publishList = PublishHistory::model()->findAll('mid=:mid and start_time>=:start_time and start_time<=:end_time', array('mid' => $mid, 'start_time' => $startTime, 'end_time' => $endTime));
        }
        else {
            $publishList = PublishHistory::model()->findAll('start_time>=:start_time and start_time<=:end_time', array('start_time' => $startTime, 'end_time' => $endTime));
        }
        

        $out = array();
        foreach($publishList as $publish) {
            $out[] = array(
                'mid' => $publish->mid, 
                'trueName' => @$publish->moderator->true_name,
                'rid' => $publish->rid, 
                'startTime' => $publish->start_time, 
                'endTime' => $publish->end_time
            );
        }

        echo json_encode($out);
    }

    public function actionGetModeratorGiftList($mid, $startTime, $endTime) {
        $startTime = date('Y-m-d H:i:s', strtotime($startTime));
        $endTime = date('Y-m-d H:i:s', strtotime($endTime) + 86400 - 1);

        if ($mid) {
            $consumeList = Consume::model()->findAll('mid=:mid and time>=:start_time and time<=:end_time', array('mid' => $mid, 'start_time' => $startTime, 'end_time' => $endTime));
        }
        else {
            $consumeList = Consume::model()->findAll('time>=:start_time and time<=:end_time', array('start_time' => $startTime, 'end_time' => $endTime));

        }

        $userList = array();

        $out = array();
        $sum = 0;
        foreach($consumeList as $consume) {
            if (!isset($userList[$consume->uid])) {
                $userList[$consume->uid] = User::model()->findByPk($consume->uid);
            }
            $user = $userList[$consume->uid];
            $out[] = array(
                'mid' => $consume->mid,
                'trueName' => @$consume->moderator->true_name,
                'senderNickname' => @$user->nickname,
                'giftName' => @$consume->property->name,
                'giftNum' => $consume->pnum,
                'giftCost' => $consume->cost,
                'sendTime' => $consume->time,
            );
            $sum += $consume->cost;
        }
        $out[] = array('mid' => '总计', 'giftCost' => $sum);
        echo json_encode($out);

    }

}