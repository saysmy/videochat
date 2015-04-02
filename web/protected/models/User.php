<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $nickname
 * @property integer $sex
 * @property string $height
 * @property string $weight
 * @property string $age
 * @property string $head_pic_1
 * @property string $email
 * @property integer $email_validated
 * @property string $mobile
 * @property integer $mobile_validated
 * @property string $qq_openid
 * @property string $qq_accesstoken
 * @property string $qq_accessexpire
 * @property double $coin
 * @property integer $type
 * @property integer $source
 * @property string $register_time
 * @property string $last_login_time
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, nickname, sex, head_pic_1, qq_openid, qq_accesstoken, qq_accessexpire', 'required', 'on' => 'qqLogin'),
			array('username, password, height, weight, age', 'required', 'on' => 'register'),
			array('username, mobile, nickname', 'required', 'on' => 'mobileRegister'),
            array('username, nickname', 'unique', 'message' => '{attribute}已存在'),
            array('mobile', 'unique', 'message' => '手机号已存在', 'on' => 'mobileRegister'),

            array('nickname, sex, birthday', 'required', 'on' => 'appUpdate', 'message' => '{attribute}不能为空'),

			array('sex, email_validated, mobile_validated, type, dead_user_status, source, height, weight, age, qq_accessexpire', 'numerical', 'integerOnly'=>true),
			array('coin', 'numerical'),
			array('username, password, nickname, head_pic_1, email, qq_openid, qq_accesstoken', 'length', 'max'=>255),
			array('mobile', 'length', 'max'=>11),
			array('register_time, last_login_time', 'date', 'format' => 'yyyy-MM-dd hh:mm:ss', 'message' => '{attribute}格式不合法'),
			array('birthday', 'date', 'format' => 'yyyy-MM-dd', 'message' => '{attribute}格式不合法'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => '用户名',
			'password' => '密码',
			'nickname' => '昵称',
			'true_name' => '真实姓名',
			'sex' => '性别',
			'height' => '身高',
			'weight' => '体重',
			'age' => '年龄',
			'birthday' => '生日',
			'head_pic_1' => 'Head Pic 1',
			'email' => 'Email',
			'email_validated' => 'Email Validated',
			'mobile' => 'Mobile',
			'mobile_validated' => 'Mobile Validated',
			'qq_openid' => 'Qq Openid',
			'qq_accesstoken' => 'Qq Accesstoken',
			'qq_accessexpire' => 'Qq Accessexpire',
			'coin' => 'Coin',
			'type' => 'Type',
			'source' => 'Source',
			'register_time' => 'Register Time',
			'last_login_time' => 'Last Login Time',
		);
	}
}