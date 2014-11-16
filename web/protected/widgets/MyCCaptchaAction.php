<?php
class MyCCaptchaAction extends CCaptchaAction {
    public function __construct($controller, $id) {
        parent::__construct($controller,$id);
        if (isset($_GET['session_id'])) {
            session_id($_GET['session_id']);
        }
        @session_start();
    }

    /**
     * Runs the action.
     */
    public function run()
    {
        if(isset($_GET[self::REFRESH_GET_VAR]))  // AJAX request for regenerating code
        {
            $code=$this->getVerifyCode(true);
            echo CJSON::encode(array(
                'hash1'=>$this->generateValidationHash($code),
                'hash2'=>$this->generateValidationHash(strtolower($code)),
                // we add a random 'v' parameter so that FireFox can refresh the image
                // when src attribute of image tag is changed
                'url'=>$this->getController()->createUrl($this->getId(),array('v' => uniqid(), 'session_id' => session_id())),
            ));
        }
        else
            $this->renderImage($this->getVerifyCode());
        Yii::app()->end();
    }
}