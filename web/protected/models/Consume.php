<?php

/**
 * This is the model class for table "consume".
 *
 * The followings are the available columns in table 'consume':
 * @property string $id
 * @property string $uid
 * @property string $mid
 * @property string $pid
 * @property string $pnum
 * @property double $cost
 * @property string $time
 */
class Consume extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Consume the static model class
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
		return 'consume';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('uid, mid, pid, pnum, cost, time', 'required'),
			array('cost', 'numerical'),
			array('uid, mid, pid, pnum', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, uid, mid, pid, pnum, cost, time', 'safe', 'on'=>'search'),
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
			'property' => array(self::BELONGS_TO, 'Property', 'pid'),
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
			'mid' => 'Mid',
			'pid' => 'Pid',
			'pnum' => 'Pnum',
			'cost' => 'Cost',
			'time' => 'Time',
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
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('pid',$this->pid,true);
		$criteria->compare('pnum',$this->pnum,true);
		$criteria->compare('cost',$this->cost);
		$criteria->compare('time',$this->time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function recently($offset, $limit) {
		$this->getDbCriteria()->offset = $offset;
		$this->getDbCriteria()->limit = $limit;
		$this->getDbCriteria()->order = 'time desc';

	    return $this;		
	}

}