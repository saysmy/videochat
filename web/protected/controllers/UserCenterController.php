<?php
class UserCenterController extends MyController {

    public $layout = '//layouts/ucenter';

    public function filters() {
        return array(
            array(
                'application.filters.LoginFilter + buyVip',
            ),
        );  
    }


    public function actionIndex($page = 1) {
        $this->actionGiftEarn($page);
    }

    public function actionGiftConsume($page = 1) {
        $limit = 10;
        $receivers = array();
        if (!CUser::checkLogin()) {
            $userInfo = null;
        }
        else {
            $userInfo = CUser::getInfoByUid($_SESSION['uid']);
            $userInfo['consume'] = Consume::model()->recently(($page - 1)*$limit, $limit)->findAll('uid=:uid', array(':uid' => $_SESSION['uid']));
            $userInfo['consume_total'] = Consume::model()->count('uid=:uid', array(':uid' => $_SESSION['uid']));
            foreach($userInfo['consume'] as $record) {
                if (isset($receivers[$record->mid])) {
                    continue;
                }
                $user = CUser::getInfoByUid($record->mid);
                if ($user) {
                    $receivers[$record->mid] = $user['nickname'];
                }
                else {
                    $receivers[$record->mid] = '--';
                }
            }

        }

        $this->userInfo = $userInfo;
        $this->currentTab = 'gift';
        
        $this->render('giftConsume', array('userInfo' => $userInfo, 'receivers' => $receivers));
    }

    public function actionGiftEarn($page = 1) {
        $limit = 10;
        $senders = array();
        if (!CUser::checkLogin()) {
            $userInfo = null;
        }
        else {
            $userInfo = CUser::getInfoByUid($_SESSION['uid']);
            $userInfo['earn'] = Consume::model()->recently(($page - 1)*$limit, $limit)->findAll('mid=:uid', array(':uid' => $_SESSION['uid']));
            $userInfo['earn_total'] = Consume::model()->count('mid=:uid', array(':uid' => $_SESSION['uid']));
            foreach($userInfo['earn'] as $record) {
                if (isset($senders[$record->uid])) {
                    continue;
                }
                $user = CUser::getInfoByUid($record->uid);
                if ($user) {
                    $senders[$record->uid] = $user['nickname'];
                }
                else {
                    $senders[$record->uid] = '--';
                }
            }
        }

        $this->userInfo = $userInfo;
        $this->currentTab = 'gift';
        
        $this->render('giftEarn', array('userInfo' => $userInfo, 'senders' => $senders));
    }

    public function actionPublishHistory($page = 1) {
        $limit = 10;
        $senders = array();
        if (!($uid = CUser::checkLogin())) {
            $userInfo = null;
        }
        else {
            $userInfo = CUser::getInfoByUid($uid);
            $records = PublishHistory::model()->findAll(array('condition' => 'mid=' . $uid, 'order' => 'start_time desc', 'offset' => ($page - 1)*$limit, 'limit' => $limit));
            $total = PublishHistory::model()->count('mid=' . $uid);
            $userInfo['publishHistory'] = $records;
            $userInfo['total'] = $total;
        }

        $this->userInfo = $userInfo;
        $this->currentTab = 'publishHistory';
        
        $this->render('publishHistory', array('userInfo' => $userInfo));

    }

    public function actionMyVip() {
        if (!($uid = CUser::checkLogin())) {
            $userInfo = null;
        }
        else {
            $userInfo = CUser::getInfoByUid($uid);
        }
        $this->userInfo = $userInfo;
        $this->currentTab = 'myVip';

        $this->render('myVip');
    }


    public function actionBuyVip($type, $num) {
        $uid = CUser::checkLogin();

        if (!is_numeric($num) || $num == 0) {
            return ToolUtils::ajaxOut(100);
        }

        if ($type == 'month') {
            $month = $num;
        }
        else if ($type == 'year') {
            $month = $num * 12;
        }
        else {
            return ToolUtils::ajaxOut(101);
        }

        Yii::app()->db->createCommand("begin")->execute(); 

        $user = User::model()->findByPk($uid);
        if (!$user) {
            return ToolUtils::ajaxOut(103, 'get user error');
        }

        if ($user->coin < $month * VIP_MONTH_PRICE) {
            return ToolUtils::ajaxOut(105, 'miss coin', array('myCoin' => $user->coin, 'needCoin' => $month * VIP_MONTH_PRICE));
        }
        
        if (strtotime($user->vip_start) < time()) {
            $user->vip_start = date('Y-m-d H:i:s');
            $user->vip_end = date('Y-m-d H:i:s');
        }
        $vipEndTime = strtotime($user->vip_end);
        $vipEndMonth = date('m', $vipEndTime);
        $vipEndYear = date('Y', $vipEndTime);
        $vipEndMonth += $month;
        if ($vipEndMonth > 12) {
            $vipEndMonth -= 12;
            $vipEndYear ++;
        }
        $user->vip_end = $vipEndYear . '-' . $vipEndMonth . '-' . date('d', $vipEndTime) . ' ' . date('H:i:s', $vipEndTime);
        $user->coin -= $month * VIP_MONTH_PRICE;
        if (!$user->save(true, array('coin', 'vip_start', 'vip_end'))) {
            return ToolUtils::ajaxOut(104, 'update user error', $user->getErrors());
        }

        $vip = new VipHistory;
        $vip->uid = $uid;
        $vip->month = $month; 
        $vip->cost = $month * VIP_MONTH_PRICE;
        $vip->time = date('Y-m-d H:i:s');
        if (!$vip->save()) {
            return ToolUtils::ajaxOut(102, 'insert db error', $vip->getErrors());
        }

        Yii::app()->db->createCommand("commit")->execute();

        ToolUtils::ajaxOut(0);
    }





}