<?php

/**
 * This is the model class for table "PRODUCTO".
 *
 * The followings are the available columns in table 'PRODUCTO':
 * @property integer $ID
 * @property string $NOMBRE
 * @property string $IMAGEN
 * @property string $DESCRIPCION
 * @property integer $CATEGORIA_ID
 *
 * The followings are the available model relations:
 * @property ATRIBUTOPRODUCTO[] $aTRIBUTOPRODUCTOs
 * @property DETALLEPRODUCTO[] $dETALLEPRODUCTOs
 * @property CATEGORIA $cATEGORIA
 * @property PAIS[] $pAISes
 */
class Product extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'PRODUCTO';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('NOMBRE, DESCRIPCION, CATEGORIA_ID', 'required'),
			array('CATEGORIA_ID', 'numerical', 'integerOnly'=>true),
			array('NOMBRE', 'length', 'max'=>45),
			array('IMAGEN', 'length', 'max'=>120),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('ID, NOMBRE, IMAGEN, DESCRIPCION, CATEGORIA_ID', 'safe', 'on'=>'search'),
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
			'aTRIBUTOPRODUCTOs' => array(self::HAS_MANY, 'ATRIBUTOPRODUCTO', 'PRODUCTO_ID'),
			'dETALLEPRODUCTOs' => array(self::HAS_MANY, 'DETALLEPRODUCTO', 'PRODUCTO_ID'),
			'cATEGORIA' => array(self::BELONGS_TO, 'CATEGORIA', 'CATEGORIA_ID'),
			'pAISes' => array(self::MANY_MANY, 'PAIS', 'PRODUCTO_PAIS(PRODUCTO_ID, PAIS_ID)'),
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
			'IMAGEN' => 'Imagen',
			'DESCRIPCION' => 'Descripcion',
			'CATEGORIA_ID' => 'Categoria',
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
		$criteria->compare('IMAGEN',$this->IMAGEN,true);
		$criteria->compare('DESCRIPCION',$this->DESCRIPCION,true);
		$criteria->compare('CATEGORIA_ID',$this->CATEGORIA_ID);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Product the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
