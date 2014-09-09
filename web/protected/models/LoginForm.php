<?php
class LoginForm extends CFormModel {
    public $username;
    public $password;
    public $remember;

    public function rules()
    {
        return array(
            array('username, password, remember', 'required', 'message' => '{attribute}不能为空'),
        );
    }

    public function attributeLabels() {
        return array(
            'username' => '用户名',
            'password' => '密码'
        );
    }
}