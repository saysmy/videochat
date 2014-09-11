<?php

/**
 * This is the model class for table "recharge".
 *
 * The followings are the available columns in table 'recharge':
 * @property string $id
 * @property string $uid
 * @property double $money
 * @property double $coin
 * @property integer $pay_type
 * @property string $time
 * @property string $ali_trade_no
 * @property integer $status
 */
class Recharge extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Recharge the static model class
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
		return 'recharge';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, money, coin, pay_type, time, ali_trade_no, status', 'required'),
			array('pay_type, status', 'numerical', 'integerOnly'=>true),
			array('money, coin', 'numerical', 'min' => 0.01),
			array('uid', 'length', 'max'=>10),
			array('ali_trade_no', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, money, coin, pay_type, time, ali_trade_no, status', 'safe', 'on'=>'search'),
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
			'money' => 'Money',
			'coin' => 'Coin',
			'pay_type' => 'Pay Type',
			'time' => 'Time',
			'ali_trade_no' => 'Ali Trade No',
			'status' => 'Status',
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
		$criteria->compare('uid',$this->uid,true);
		$criteria->compare('money',$this->money);
		$criteria->compare('coin',$this->coin);
		$criteria->compare('pay_type',$this->pay_type);
		$criteria->compare('time',$this->time,true);
		$criteria->compare('ali_trade_no',$this->ali_trade_no,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}