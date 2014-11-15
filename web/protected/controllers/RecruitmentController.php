<?php
class RecruitmentController extends Controller {

    public $layout='//layouts/common';

    public function filters() {
        return array(
            array(
                'application.filters.LoginFilter - step1,cCheckStep',
            ),
        );
    }

    public function actionStep1() {
        $this->render('step1');
    }

    public function actionStep2() {
        $uid = CUser::checkLogin();
        $rec = $this->checkStep(2);
        $user = CUser::getInfoByUid($uid);
        $this->render('step2', array('rec' => $rec, 'user' => $user));
    }

    public function actionStep3() {
        $uid = CUser::checkLogin();
        $rec = $this->checkStep(3);
        $this->render('step3', array('rec' => $rec));
    }

    public function actionStep4() {
        $uid = CUser::checkLogin();
        $rec = $this->checkStep(4);
        $user = CUser::getInfoByUid($uid);
        $this->render('step4', array('rec' => $rec, 'user' => $user));
    }

    public function actionPostStep($step) {
        $uid = CUser::checkLogin();
        if ($step == 1) {
            $rec = Recruitment::model()->find('uid=:uid', array(':uid' => $uid));
            if (!$rec) {
                $rec = new Recruitment;
                $rec->uid = $uid;
                $rec->create_time = date('Y-m-d H:i:s');
                $rec->step = 1;
                //default
                $rec->name = '';
                $rec->age = 0;
                $rec->height = 0;
                $rec->weight = 0;
                $rec->id_card = '';
                $rec->qq = '';
                $rec->email = '';
                $rec->mobile = '';
                $rec->images = '[]';
            }
            $rec->setScenario('step1');
            $rec->update_time = date('Y-m-d H:i:s');
            if (!$rec->save()) {
                ToolUtils::ajaxOut(101, '', $rec->getErrors());
            }
        }
        else if ($step == 2) {
            $rec = Recruitment::model()->find('uid=:uid', array(':uid' => $uid));
            $rec->setScenario('step2');
            $rec->attributes = $_REQUEST;
            $rec->step = max($rec->step, 2);
            $rec->update_time = date('Y-m-d H:i:s');
             if (!$rec->save()) {
                return ToolUtils::ajaxOut(102, current($rec->getErrors()), $rec->getErrors());
            }
        }
        else if ($step == 3) {
            $rec = Recruitment::model()->find('uid=:uid', array(':uid' => $uid));
            $rec->setScenario('step3');
            $images = $_REQUEST['images'];
            if (count($images) < 2) {
                return ToolUtils::ajaxOut(103, '至少上传两张照片');
            }
            foreach($images as $key => &$url) {
                $path = ToolUtils::getPathFromUrl($url);
                $newPath = str_replace('_tmp', '_recruit' . $key, $path);
                copy($path, $newPath);
                $url = ToolUtils::getUrlFromPath($newPath);
            }
            $rec->images = json_encode($images);
            $rec->step = max($rec->step ,3);
            $rec->update_time = date('Y-m-d H:i:s');
             if (!$rec->save()) {
                return ToolUtils::ajaxOut(104, current($rec->getErrors()), $rec->getErrors());
            }

        }
        else if ($step == 4) {
            $rec = Recruitment::model()->find('uid=:uid', array(':uid' => $uid));
            $rec->setScenario('step4');
            $rec->step = 4;
            $rec->update_time = date('Y-m-d H:i:s');
            $rec->save();
        }
        else {
            ToolUtils::ajaxOut(100, '参数错误');
        }

        ToolUtils::ajaxOut(0);
    }


    private function checkStep($step) {
        $uid = CUser::checkLogin();
        $rec = Recruitment::model()->find('uid=:uid', array(':uid' => $uid));
        if (!$rec) {
            $db_step = 0;
        }
        else {
            $db_step = $rec->step;
        }
        if ($db_step + 1 < $step) {
            header('Location:step' . ($db_step + 1));
            exit;
        }
        return $rec;
    }

    //remote http call
    public function actionCCheckStep($step, $uid, $session) {
        $uid = CUser::checkLogin($uid, $session);
        $rec = Recruitment::model()->find('uid=:uid', array(':uid' => $uid));
        if (!$rec) {
            $db_step = 0;
        }
        else {
            $db_step = $rec->step;
        }
        if ($db_step + 1 < $step) {
            return ToolUtils::ajaxOut(0, '', array('redirect' => $db_step + 1));
        }
        if ($rec) {
            $rec = $rec->toArray();
        }
        return ToolUtils::ajaxOut(0, '', array('rec' => $rec));
    }

}