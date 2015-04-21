<?php
class StatisticsController extends CController {

    public $layout = 'common';

    public function actionModerator() {
        $this->render('moderator');
    }

    public function actionGetModeratorPublishList($moderatorTrueName = '') {
        $trueName = trim($moderatorTrueName);
        $publishList = array();
        if ($trueName) {
            $user = User::model()->find('true_name=:true_name', array(':true_name' => $trueName));
            if ($user) {
                $publishList = PublishHistory::model()->findAll('mid=' . $user->id);
            }
        }

        $out = array();
        foreach($publishList as $publish) {
            $out[] = array('mid' => $publish->mid, 'rid' => $publish->rid, 'startTime' => $publish->start_time, 'endTime' => $publish->end_time);
        }

        echo json_encode($out);
    }

    public function actionGetModeratorGiftList($moderatorTrueName = '') {
        $trueName = trim($moderatorTrueName);
        $consumeList = array();
        if ($trueName) {
            $user = User::model()->find('true_name=:true_name', array(':true_name' => $trueName));
            if ($user) {
                $consumeList = Consume::model()->findAll('mid=' . $user->id);
            }
        }
        $userList = array();

        $out = array();
        foreach($consumeList as $consume) {
            if (!isset($userList[$consume->uid])) {
                $userList[$consume->uid] = User::model()->findByPk($consume->uid);
            }
            $user = $userList[$consume->uid];
            $out[] = array(
                'mid' => $consume->mid,
                'senderNickname' => @$user->nickname,
                'giftName' => @$consume->property->name,
                'giftNum' => $consume->pnum,
                'giftCost' => $consume->cost,
                'sendTime' => $consume->time,
            );
        }
        echo json_encode($out);

    }

}