<?php

/**
 * This is the model class for table "PAIS".
 *
 * The followings are the available columns in table 'PAIS':
 * @property integer $ID
 * @property string $NOMBRE
 *
 * The followings are the available model relations:
 * @property ESTABLECIMIENTO[] $eSTABLECIMIENTOs
 * @property MENSAJE[] $mENSAJEs
 * @property PRODUCTO[] $pRODUCTOs
 */
class Zone extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'PAIS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOMBRE', 'required'),
			array('NOMBRE', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, NOMBRE', 'safe', 'on'=>'search'),
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
			'eSTABLECIMIENTOs' => array(self::HAS_MANY, 'ESTABLECIMIENTO', 'PAIS_ID'),
			'mENSAJEs' => array(self::MANY_MANY, 'MENSAJE', 'MENSAJE_PAIS(PAIS_ID, MENSAJE_ID)'),
			'pRODUCTOs' => array(self::MANY_MANY, 'PRODUCTO', 'PRODUCTO_PAIS(PAIS_ID, PRODUCTO_ID)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'NOMBRE' => 'Nombre',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('NOMBRE',$this->NOMBRE,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Zone the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
