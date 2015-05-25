<?php
class ActivityController extends CController {

    public function actionHome($last_come_time = 0) {
        if (time() < strtotime('2014-11-30') && $last_come_time == 0) {
            ToolUtils::ajaxOut(0, '', array(
                    'pic' => '/img/home_activity.jpg',
                    'url' => '/room/4',
                    'current_time' => time(),
                    'picWidth' => 630,
                    'picHeight' => 410
                )
            );
        }
        else {
            ToolUtils::ajaxOut(0, '', array(
                    'current_time' => time(),
                )
            );
        }
    }
}