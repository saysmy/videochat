<?php
class UserController extends CController {

    public $layout = 'common';

    public $subTitle = '';

    public function actionLogin() {

        $this->subTitle = '登陆';

        $this->render('login');
    }

    public function actionCheckPassword() {
        
        $password = trim(Yii::app()->request->getParam('password'));

        if (Yii::app()->getController()->getModule()->password != $password) {
            return ToolUtils::ajaxOut(-200, '密码错误');
        }

        $userIdentity = new CUserIdentity('admin', $password);
        Yii::app()->user->login($userIdentity);

        ToolUtils::ajaxOut(0, '', array('redirect' => Yii::app()->user->getReturnUrl()));
    }
}