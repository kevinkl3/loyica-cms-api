<?php

/**
 * This is the model class for table "MENSAJE".
 *
 * The followings are the available columns in table 'MENSAJE':
 * @property integer $ID
 * @property string $TITULO
 * @property string $IMAGEN
 * @property string $DESCRIPCION
 * @property string $VIGENCIA_DESDE
 * @property string $VIGENCIA_HASTA
 * @property string $ACCION
 * @property integer $TIPO_MENSAJE_ID
 *
 * The followings are the available model relations:
 * @property TIPOMENSAJE $tIPOMENSAJE
 * @property PAIS[] $pAISes
 */
class Notification extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'MENSAJE';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TITULO, TIPO_MENSAJE_ID', 'required'),
			array('TIPO_MENSAJE_ID', 'numerical', 'integerOnly'=>true),
			array('TITULO, ACCION', 'length', 'max'=>45),
			array('IMAGEN', 'length', 'max'=>120),
			array('DESCRIPCION, VIGENCIA_DESDE, VIGENCIA_HASTA', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, TITULO, IMAGEN, DESCRIPCION, VIGENCIA_DESDE, VIGENCIA_HASTA, ACCION, TIPO_MENSAJE_ID', 'safe', 'on'=>'search'),
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
			'tIPOMENSAJE' => array(self::BELONGS_TO, 'TIPOMENSAJE', 'TIPO_MENSAJE_ID'),
			'pAISes' => array(self::MANY_MANY, 'PAIS', 'MENSAJE_PAIS(MENSAJE_ID, PAIS_ID)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'TITULO' => 'Titulo',
			'IMAGEN' => 'Imagen',
			'DESCRIPCION' => 'Descripcion',
			'VIGENCIA_DESDE' => 'Vigencia Desde',
			'VIGENCIA_HASTA' => 'Vigencia Hasta',
			'ACCION' => 'Accion',
			'TIPO_MENSAJE_ID' => 'Tipo Mensaje',
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
		$criteria->compare('TITULO',$this->TITULO,true);
		$criteria->compare('IMAGEN',$this->IMAGEN,true);
		$criteria->compare('DESCRIPCION',$this->DESCRIPCION,true);
		$criteria->compare('VIGENCIA_DESDE',$this->VIGENCIA_DESDE,true);
		$criteria->compare('VIGENCIA_HASTA',$this->VIGENCIA_HASTA,true);
		$criteria->compare('ACCION',$this->ACCION,true);
		$criteria->compare('TIPO_MENSAJE_ID',$this->TIPO_MENSAJE_ID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Notification the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
