<?php

include(dirname(__FILE__) . '/config/define.php');

class AppModule extends CWebModule {
    public function init() {
        parent::init();
        Yii::setPathOfAlias('app',dirname(__FILE__));
        Yii::app()->setComponents(array(
            'errorHandler'=>array(
                'class'=>'CErrorHandler',
                'errorAction'=>$this->getId().'/error/error',
            ),
        ), false);

    }

}