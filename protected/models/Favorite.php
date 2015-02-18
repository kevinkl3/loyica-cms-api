<?php

/**
 * This is the model class for table "favorite".
 *
 * The followings are the available columns in table 'favorite':
 * @property integer $FAVORITE_ID
 * @property integer $SUSCRIPCION_ID
 * @property string $TYPE
 * @property string $ELEMENT_ID
 *
 * The followings are the available model relations:
 * @property Suscription $sUSCRIPCION
 */
class Favorite extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Favorite the static model class
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
		return 'favorite';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('SUSCRIPCION_ID, TYPE, ELEMENT_ID', 'required'),
			array('SUSCRIPCION_ID', 'numerical', 'integerOnly'=>true),
			array('TYPE, ELEMENT_ID', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('FAVORITE_ID, SUSCRIPCION_ID, TYPE, ELEMENT_ID', 'safe', 'on'=>'search'),
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
			'suscription' => array(self::BELONGS_TO, 'Suscription', 'SUSCRIPCION_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
     TODO: localizacion yii::t()...
	 */
	public function attributeLabels()
	{
		return array(
			'FAVORITE_ID' => 'Favorite',
			'SUSCRIPCION_ID' => 'Suscripcion',
			'TYPE' => 'Type',
			'ELEMENT_ID' => 'Element',
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

		$criteria->compare('FAVORITE_ID',$this->FAVORITE_ID);
		$criteria->compare('SUSCRIPCION_ID',$this->SUSCRIPCION_ID);
		$criteria->compare('TYPE',$this->TYPE,true);
		$criteria->compare('ELEMENT_ID',$this->ELEMENT_ID,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}