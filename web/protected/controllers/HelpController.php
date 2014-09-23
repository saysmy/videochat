<?php
class HelpController extends CController {
    public $layout='//layouts/common';

    public function actionAbout() {
        $this->render('about');
    }

    public function actionEmploy() {
        $this->render('employ');
    }

    public function actionMap() {
        $this->render('map');
    }

    public function actionLink() {
        $this->render('link');
    }
}