<?php

/**
 * This is the model class for table "suscription".
 *
 * The followings are the available columns in table 'suscription':
 * @property integer $SUSCRIPTION_ID
 * @property string $PHONE
 * @property string $EMAIL
 * @property string $FIRST_NAME
 * @property string $LAST_NAME
 * @property string $FACEBOOK
 * @property string $TWITTER
 * @property string $GOOGLE
 *
 * The followings are the available model relations:
 * @property Favorite[] $favorites
 */
class Suscription extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Suscription the static model class
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
		return 'suscription';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('PHONE', 'required'),
			array('PHONE, FACEBOOK, TWITTER, GOOGLE', 'length', 'max'=>100),
			array('EMAIL', 'length', 'max'=>150),
			array('FIRST_NAME, LAST_NAME', 'length', 'max'=>250),
            array('SUSCRIPTION_ID, PHONE, FIRST_NAME, LAST_NAME, FACEBOOK, TWITTER, GOOGLE', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('SUSCRIPTION_ID, PHONE, EMAIL, FIRST_NAME, LAST_NAME, FACEBOOK, TWITTER, GOOGLE', 'safe', 'on'=>'search'),
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
			'favorites' => array(self::HAS_MANY, 'Favorite', 'SUSCRIPCION_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'SUSCRIPTION_ID' => 'Suscription',
			'PHONE' => 'Phone',
			'EMAIL' => 'Email',
			'FIRST_NAME' => 'First Name',
			'LAST_NAME' => 'Last Name',
			'FACEBOOK' => 'Facebook',
			'TWITTER' => 'Twitter',
			'GOOGLE' => 'Google',
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

		$criteria->compare('SUSCRIPTION_ID',$this->SUSCRIPTION_ID);
		$criteria->compare('PHONE',$this->PHONE,true);
		$criteria->compare('EMAIL',$this->EMAIL,true);
		$criteria->compare('FIRST_NAME',$this->FIRST_NAME,true);
		$criteria->compare('LAST_NAME',$this->LAST_NAME,true);
		$criteria->compare('FACEBOOK',$this->FACEBOOK,true);
		$criteria->compare('TWITTER',$this->TWITTER,true);
		$criteria->compare('GOOGLE',$this->GOOGLE,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}