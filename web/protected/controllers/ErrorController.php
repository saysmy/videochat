<?php
class ErrorController extends CController {
    public $layout = '//layouts/common';
    public function actionError() {
        $this->render('/system/error');
    }
}