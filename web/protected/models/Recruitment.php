<?php

/**
 * This is the model class for table "recruitment".
 *
 * The followings are the available columns in table 'recruitment':
 * @property integer $id
 * @property string $uid
 * @property string $name
 * @property string $age
 * @property double $height
 * @property double $weight
 * @property string $id_card
 * @property string $qq
 * @property string $email
 * @property string $mobile
 * @property string $images
 * @property integer $step
 * @property string $create_time
 * @property string $update_time
 */
class Recruitment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recruitment the static model class
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
		return 'recruitment';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid,step,update_time', 'required'),
			array('create_time', 'required', 'on' => 'step1'),
			array('name, age, height, weight, id_card, qq, email, mobile', 'required', 'on' => 'step2'),
			array('images', 'required', 'on' => 'step3'),

			array('step', 'numerical', 'integerOnly'=>true),
			array('height, weight, age, mobile, qq', 'numerical', 'message' => '{attribute}不合法'),
			array('uid, age', 'length', 'max'=>10, 'message' => '{attribute}超长'),
			array('name, qq, email', 'length', 'max'=>255, 'message' => '{attribute}超长'),
			array('id_card', 'length', 'is'=>18, 'message' => '{attribute}必须为18位'),
			array('mobile', 'length', 'is'=>11, 'message' => '{attribute}必须位11位'),
			array('email', 'email', 'message' => '邮箱格式不正确'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, name, age, height, weight, id_card, qq, email, mobile, images, step, create_time, update_time', 'safe', 'on'=>'search'),
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
			'uid' => 'Uid',
			'name' => '姓名',
			'age' => '年龄',
			'height' => '身高',
			'weight' => '体重',
			'id_card' => '身份证号',
			'qq' => 'QQ',
			'email' => '邮箱',
			'mobile' => '手机号',
			'images' => 'Images',
			'step' => 'Step',
			'create_time' => 'Create Time',
			'update_time' => 'Update Time',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('age',$this->age,true);
		$criteria->compare('height',$this->height);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('id_card',$this->id_card,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('images',$this->images,true);
		$criteria->compare('step',$this->step);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function toArray() {
		$ret = array();
		foreach($this->attributeLabels() as $name => $v) {
			$ret[$name] = $this->$name;
		}
		return $ret;
	}
}