<?php

/**
 * This is the model class for table "reward_log".
 *
 * The followings are the available columns in table 'reward_log':
 * @property integer $REWARD_LOG_ID
 * @property integer $SUBSCRIPTION_ID
 * @property string $DESCRIPTION
 * @property integer $POINTS
 * @property string $REWARD_DATE
 *
 * The followings are the available model relations:
 * @property Subscription $sUBSCRIPTION
 */
class RewardLog extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RewardLog the static model class
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
		return 'reward_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SUBSCRIPTION_ID, DESCRIPTION', 'required'),
			array('SUBSCRIPTION_ID, POINTS', 'numerical', 'integerOnly'=>true),
			array('DESCRIPTION', 'length', 'max'=>250),
			array('REWARD_DATE', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('REWARD_LOG_ID, SUBSCRIPTION_ID, DESCRIPTION, POINTS, REWARD_DATE', 'safe', 'on'=>'search'),
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
			'sUBSCRIPTION' => array(self::BELONGS_TO, 'Subscription', 'SUBSCRIPTION_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'REWARD_LOG_ID' => 'Reward Log',
			'SUBSCRIPTION_ID' => 'Subscription',
			'DESCRIPTION' => 'Description',
			'POINTS' => 'Points',
			'REWARD_DATE' => 'Reward Date',
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

		$criteria->compare('REWARD_LOG_ID',$this->REWARD_LOG_ID);
		$criteria->compare('SUBSCRIPTION_ID',$this->SUBSCRIPTION_ID);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('POINTS',$this->POINTS);
		$criteria->compare('REWARD_DATE',$this->REWARD_DATE,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}