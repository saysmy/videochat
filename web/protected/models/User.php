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
			array('nickname, sex, head_pic_1, qq_openid, qq_accesstoken, qq_accessexpire', 'required', 'on' => 'qqLogin'),
			array('username, password, height, weight, age', 'required', 'on' => 'register'),
            array('username', 'unique', 'message' => '用户名已存在'),
			array('sex, email_validated, mobile_validated, type, dead_user_status, source, height, weight, age, qq_accessexpire', 'numerical', 'integerOnly'=>true),
			array('coin', 'numerical'),
			array('username, password, nickname, head_pic_1, email, qq_openid, qq_accesstoken', 'length', 'max'=>255),
			array('mobile', 'length', 'max'=>11),
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
			'username' => 'Username',
			'password' => 'Password',
			'nickname' => 'Nickname',
			'true_name' => 'Truename',
			'sex' => 'Sex',
			'height' => 'Height',
			'weight' => 'Weight',
			'age' => 'Age',
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