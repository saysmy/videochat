<?php

/**
 * This is the model class for table "msg_backup".
 *
 * The followings are the available columns in table 'msg_backup':
 * @property string $id
 * @property string $fromUid
 * @property string $toUid
 * @property string $rid
 * @property string $msg
 * @property integer $private
 * @property string $add_time
 */
class MsgBackup extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'msg_backup';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fromUid, toUid, rid, msg, private, add_time', 'required'),
			array('private', 'numerical', 'integerOnly'=>true),
			array('fromUid, toUid, rid', 'length', 'max'=>10),
			array('msg', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fromUid, toUid, rid, msg, private, add_time', 'safe', 'on'=>'search'),
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
			'fromUid' => 'From Uid',
			'toUid' => 'To Uid',
			'rid' => 'Rid',
			'msg' => 'Msg',
			'private' => 'Private',
			'add_time' => 'Add Time',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('fromUid',$this->fromUid,true);
		$criteria->compare('toUid',$this->toUid,true);
		$criteria->compare('rid',$this->rid,true);
		$criteria->compare('msg',$this->msg,true);
		$criteria->compare('private',$this->private);
		$criteria->compare('add_time',$this->add_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return MsgBackup the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
