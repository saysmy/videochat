<?php

include(dirname(__FILE__) . '/config/define.php');

class AppModule extends CWebModule {

    private $_assetsUrl;

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

    public function getAssetsUrl() {
        if($this->_assetsUrl===null)
            $this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('app.assets'));
        return $this->_assetsUrl;
    }

}