<?php
class RegisterForm extends CFormModel
{
    public $username;
    public $password;
    public $passwordRepeat;
    public $age;
    public $height;
    public $weight;
    public $captcha;

 
    public function rules()
    {
        return array(
            array('username, password, passwordRepeat, age, height, weight, captcha', 'required', 'message' => '{attribute}不能为空'),
            array('password', 'length', 'min' => 6, 'message' => '密码至少6位'),
            array('passwordRepeat', 'compare', 'compareAttribute' => 'password', 'operator' => '==', 'message' => '两次密码不匹配'),
            array('age, height, weight', 'numerical', 'integerOnly' => true),
            array('captcha', 'captcha', 'message' => '验证码错误'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'username' => '用户名',
            'password' => '密码',
            'age' => '年龄',
            'weight' => '身高',
            'height' => '体重',
            'passwordRepeat' => '确认密码',
            'captcha' => '验证码'
        );
    }

 }