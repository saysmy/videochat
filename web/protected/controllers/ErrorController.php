<?php
class ErrorController extends CController {
    public $layout = '//layouts/common';
    public function actionError() {
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('/system/ajaxError', array('error' => Yii::app()->errorHandler->getError()));
        }
        else {
            $this->render('/system/error');
        }
    }
}