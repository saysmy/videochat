<?php
class AppController extends CController {

    public function actionGetLastestVersion($platform) {
        if ($platform == 'android') {
            return ToolUtils::ajaxOut(0, '', array(
                    'type' => 1,//1强制 2非强制
                    'version' => '1.0.0', 
                    'code' => 1, 
                    'url' => 'http://www.efeizao.com/down/feizao.apk', 
                    'new' => array('xxx', 'xxxx', 'xxx'),
                )
            );
        }
        else if ($platform == 'iphone') {

        }
    }

    public function actionFeedback() {

        // $uid = CUser::checkLogin();

        // if (!ToolUtils::frequencyCheck('app_feedback_' . $uid, 60)) {
        //     return ToolUtils::ajaxOut(100, '操作过于频繁');
        // }

        $content = trim(Yii::app()->request->getParam('content'));
        $contactWay = trim(Yii::app()->request->getParam('contactWay'));
        $feedback = new Feedback;
        $feedback->uid = 0;
        $feedback->content = $content;
        $feedback->contact_way = $contactWay;
        $feedback->add_time = date('Y-m-d H:i:s');
        if (!$feedback->save()) {
            return ToolUtils::ajaxOut(101, current(current($feedback->getErrors())));
        }

        ToolUtils::ajaxOut(0);
    }

}