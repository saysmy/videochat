<?php
class HelpController extends CController {
    public $layout='//layouts/common';

    public function actionAbout() {
        $this->render('about');
    }
}