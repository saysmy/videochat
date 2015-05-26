<?php

/**
 * This is the model class for table "moderator_addition".
 *
 * The followings are the available columns in table 'moderator_addition':
 * @property string $id
 * @property string $mid
 * @property string $qq
 * @property string $mobile
 * @property double $salary_per_hour
 * @property string $add_time
 */
class ModeratorAddition extends MyCActiveRecord
{

	protected $defaultColumnValues = array(
		'qq' => '',
		'mobile' => '',
	);
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'moderator_addition';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mid, salary_per_hour, add_time', 'required'),
			array('salary_per_hour', 'numerical'),
			array('mid', 'length', 'max'=>10),
			array('qq, mobile', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, mid, qq, mobile, salary_per_hour, add_time', 'safe', 'on'=>'search'),
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
			'mid' => 'Mid',
			'qq' => 'Qq',
			'mobile' => 'Mobile',
			'salary_per_hour' => 'Salary Per Hour',
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
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('qq',$this->qq,true);
		$criteria->compare('mobile',$this->mobile,true);
		$criteria->compare('salary_per_hour',$this->salary_per_hour);
		$criteria->compare('add_time',$this->add_time,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModeratorAddition the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
