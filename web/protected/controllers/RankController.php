<?php
class RankController extends CController {

    public $layout = '//layouts/common';
    
    public function actionIndex() {
        $this->render('rank');
    }
}