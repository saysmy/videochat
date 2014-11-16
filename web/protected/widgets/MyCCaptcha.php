<?php
class MyCCaptcha extends CCaptcha {
    protected function renderImage() {
        if(!isset($this->imageOptions['id']))
            $this->imageOptions['id']=$this->getId();
        @session_start();
        $url=$this->getController()->createUrl($this->captchaAction,array('v'=>uniqid(), 'session_id' => session_id()));
        $alt=isset($this->imageOptions['alt'])?$this->imageOptions['alt']:'';
        echo CHtml::image($url,$alt,$this->imageOptions);
    }

}