<?php

/**
 * This is the model class for table "room".
 *
 * The followings are the available columns in table 'room':
 * @property string $id
 * @property string $announcement
 * @property string $logo
 * @property string $banner
 * @property string $description
 * @property string $max_user
 * @property string $mid
 * @property string $moderator_desc
 * @property string $love_num
 * @property string $detail_url
 * @property string $video_url
 * @property integer $status
 * @property string $play_start_time
 * @property string $play_end_time
 * @property integer $rank
 */
class Room extends MyCActiveRecord
{

	protected $defaultColumnValues = array(
		'name' => '',
		'banner' => '',
		'max_user' => 0,
		'mids' => '',
		'love_num' => 0,
		'detail_url' => '',
		'video_url' => '',
		'status' => 0,
		'play_start_time' => '0000-00-00 00:00:00',
		'play_end_time' => '0000-00-00 00:00:00',
		'admin' => '',
		'type' => 0,
		'flower_number' => 0,
	);

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'room';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('announcement,logo,description,mid,moderator_desc,rank', 'required' ,'on' => 'adminAdd'),
			array('announcement,logo,moderator_desc,rank', 'required', 'on' => 'adminUpdate'),

			// array('announcement, logo, banner, description, max_user, mid, moderator_desc, love_num, detail_url, video_url, status, play_start_time, play_end_time, rank', 'required'),
			array('status, rank', 'numerical', 'integerOnly'=>true),
			array('announcement, logo, banner, description, moderator_desc, detail_url, video_url, admin', 'length', 'max'=>255),
			array('max_user, mid, love_num', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, announcement, logo, banner, description, max_user, mid, moderator_desc, love_num, detail_url, video_url, status, play_start_time, play_end_time, rank', 'safe', 'on'=>'search'),
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
			'moderator' => array(self::BELONGS_TO, 'User', 'mid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'announcement' => 'Announcement',
			'name' => 'Name',
			'logo' => 'Logo',
			'banner' => 'Banner',
			'description' => 'Description',
			'max_user' => 'Max User',
			'mid' => 'Mid',
			'mids' => 'Mids',
			'moderator_desc' => 'Moderator Desc',
			'love_num' => 'Love Num',
			'detail_url' => 'Detail Url',
			'video_url' => 'Video Url',
			'status' => 'Status',
			'play_start_time' => 'Play Start Time',
			'play_end_time' => 'Play End Time',
			'rank' => 'Rank',
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
		$criteria->compare('announcement',$this->announcement,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('banner',$this->banner,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('max_user',$this->max_user,true);
		$criteria->compare('mid',$this->mid,true);
		$criteria->compare('moderator_desc',$this->moderator_desc,true);
		$criteria->compare('love_num',$this->love_num,true);
		$criteria->compare('detail_url',$this->detail_url,true);
		$criteria->compare('video_url',$this->video_url,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('play_start_time',$this->play_start_time,true);
		$criteria->compare('play_end_time',$this->play_end_time,true);
		$criteria->compare('rank',$this->rank);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Room the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getModeratorAddition() {
		return ModeratorAddition::model()->find('mid=' . $this->mid);
	}
}
