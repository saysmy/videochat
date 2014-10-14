<?php
class UserUpdateForm extends CFormModel {
    public $nickname;
    public $password;
    public $newPassword;
    public $newPasswordRepeat;

    public function rules() {
        return array(
            array('nickname', 'required', 'message' => '{attribute}不能为空', 'on' => 'nickname'),
            array('password, newPassword, newPasswordRepeat', 'required', 'message' => '{attribute}不能为空', 'on' => 'password'),
            array('nickname', 'length', 'max' => 255, 'message' => '昵称超长'),
            array('newPasswordRepeat', 'compare', 'compareAttribute' => 'newPassword', 'operator' => '==', 'message' => '两次密码不匹配'),
        );
    }

    public function attributeLabels() {
        return array(
            'nickname' => '昵称',
            'password' => '旧密码',
            'newPassword' => '新密码',
            'newPasswordRepeat' => '确认密码',
        );
    }

}