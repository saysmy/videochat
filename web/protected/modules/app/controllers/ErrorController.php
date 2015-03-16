<?php
class ErrorController extends CController {
    public function actionError() {
        $this->render('/system/error', array('error' => Yii::app()->errorHandler->getError()));
    }
}