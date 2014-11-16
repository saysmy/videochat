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
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, password, nickname, true_name, sex, height, weight, age, head_pic_1, email, email_validated, mobile, mobile_validated, qq_openid, qq_accesstoken, qq_accessexpire, coin, type, dead_user_status, source, register_time, last_login_time', 'safe', 'on'=>'search'),
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

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('nickname',$this->nickname,true);
		$criteria->compare('true_name',$this->nickname,true);
		$criteria->compare('sex',$this->sex);
		$criteria->compare('height',$this->height,true);
		$criteria->compare('weight',$this->weight,true);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('head_pic_1',$this->head_pic_1,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('email_validated',$this->email_validated);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('mobile_validated',$this->mobile_validated);
		$criteria->compare('qq_openid',$this->qq_openid,true);
		$criteria->compare('qq_accesstoken',$this->qq_accesstoken,true);
		$criteria->compare('qq_accessexpire',$this->qq_accessexpire,true);
		$criteria->compare('coin',$this->coin,true);
		$criteria->compare('type',$this->type);
		$criteria->compare('source',$this->source);
		$criteria->compare('register_time',$this->register_time,true);
		$criteria->compare('last_login_time',$this->last_login_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}