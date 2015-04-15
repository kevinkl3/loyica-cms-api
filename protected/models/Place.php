<?php

/**
 * This is the model class for table "ESTABLECIMIENTO".
 *
 * The followings are the available columns in table 'ESTABLECIMIENTO':
 * @property integer $ID
 * @property string $NOMBRE
 * @property string $DIRECCION
 * @property string $IMAGEN
 * @property string $HORA_APERTURA
 * @property string $HORA_CIERRE
 * @property string $UBICACION_GPS
 * @property double $LATITUD
 * @property double $LONGITUD
 * @property string $TELEFONO
 * @property string $ABIERTO
 * @property integer $PAIS_ID
 * @property string $ID_REF
 *
 * The followings are the available model relations:
 * @property ATRIBUTOESTABLECIMIENTO[] $aTRIBUTOESTABLECIMIENTOs
 * @property COMODIDAD[] $cOMODIDADs
 * @property PAIS $pAIS
 * @property TIPOESTABLECIMIENTO[] $tIPOESTABLECIMIENTOs
 */
class Place extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ESTABLECIMIENTO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOMBRE, DIRECCION, PAIS_ID', 'required'),
			array('PAIS_ID', 'numerical', 'integerOnly'=>true),
			array('LATITUD, LONGITUD', 'numerical'),
			array('NOMBRE, IMAGEN', 'length', 'max'=>120),
			array('UBICACION_GPS, TELEFONO, ABIERTO', 'length', 'max'=>45),
			array('ID_REF', 'length', 'max'=>100),
			array('HORA_APERTURA, HORA_CIERRE', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, NOMBRE, DIRECCION, IMAGEN, HORA_APERTURA, HORA_CIERRE, UBICACION_GPS, LATITUD, LONGITUD, TELEFONO, ABIERTO, PAIS_ID, ID_REF', 'safe', 'on'=>'search'),
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
			'customAttributes' => array(self::HAS_MANY, 'ATRIBUTOESTABLECIMIENTO', 'ESTABLECIMIENTO_ID'),
			'services' => array(self::MANY_MANY, 'Service', 'COMODIDAD_ESTABLECIMIENTO(ESTABLECIMIENTO_ID, COMODIDAD_ID)'),
			'zone' => array(self::BELONGS_TO, 'Zone', 'PAIS_ID'),
			'placetype' => array(self::MANY_MANY, 'TIPOESTABLECIMIENTO', 'ESTABLECIMIENTO_TIPO_ESTABLECIMIENTO(ESTABLECIMIENTO_ID, TIPO_ESTABLECIMIENTO_ID)'),
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
			'DIRECCION' => 'Direccion',
			'IMAGEN' => 'Imagen',
			'HORA_APERTURA' => 'Hora Apertura',
			'HORA_CIERRE' => 'Hora Cierre',
			'UBICACION_GPS' => 'Ubicacion Gps',
			'LATITUD' => 'Latitud',
			'LONGITUD' => 'Longitud',
			'TELEFONO' => 'Telefono',
			'ABIERTO' => 'Abierto',
			'PAIS_ID' => 'Pais',
			'ID_REF' => 'Id Ref',
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
		$criteria->compare('DIRECCION',$this->DIRECCION,true);
		$criteria->compare('IMAGEN',$this->IMAGEN,true);
		$criteria->compare('HORA_APERTURA',$this->HORA_APERTURA,true);
		$criteria->compare('HORA_CIERRE',$this->HORA_CIERRE,true);
		$criteria->compare('UBICACION_GPS',$this->UBICACION_GPS,true);
		$criteria->compare('LATITUD',$this->LATITUD);
		$criteria->compare('LONGITUD',$this->LONGITUD);
		$criteria->compare('TELEFONO',$this->TELEFONO,true);
		$criteria->compare('ABIERTO',$this->ABIERTO,true);
		$criteria->compare('PAIS_ID',$this->PAIS_ID);
		$criteria->compare('ID_REF',$this->ID_REF,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Place the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
