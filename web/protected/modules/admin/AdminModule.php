<?php

class AdminModule extends CWebModule {

    public $password = 'letmego';

    private $_assetsUrl;

    public function init() {
        parent::init();
        Yii::setPathOfAlias('admin',dirname(__FILE__));
        Yii::app()->setComponents(array(
            'errorHandler'=>array(
                'class'=>'CErrorHandler',
                'errorAction'=>$this->getId().'/error/error',
            ),
            'user'=>array(
                'class' => 'CWebUser',
                'stateKeyPrefix' => 'admin',
                'loginUrl' => Yii::app()->createUrl($this->getId().'/user/login'),
            ),
        ), false);

    }

    public function beforeControllerAction($controller, $action) {

        $route=$controller->id.'/'.$action->id;

        $publicPages=array(
                'user/login',
                'user/checkPassword',
                'error/error',
            );

        if(parent::beforeControllerAction($controller, $action)) {
            if($this->password !== false && Yii::app()->user->isGuest && !in_array($route, $publicPages)) {
                Yii::app()->user->loginRequired(); 
            }
            else {
                return true;
            }
        }
        return false;
    }

    public function getAssetsUrl()
    {
        if($this->_assetsUrl===null)
            $this->_assetsUrl=Yii::app()->getAssetManager()->publish(Yii::getPathOfAlias('admin.assets'));
        return $this->_assetsUrl;
    }

    public function setAssetsUrl($value)
    {
        $this->_assetsUrl=$value;
    }


}