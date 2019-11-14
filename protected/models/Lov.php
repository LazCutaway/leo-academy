<?php

/**
 * This is the model class for table "lov".
 *
 * The followings are the available columns in table 'lov':
 * @property integer $id
 * @property string $lista
 * @property string $codice
 * @property string $descrizione
 * @property integer $flag_attivo
 */
class Lov extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'lov';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('lista, codice, ordine, descrizione', 'required'),
			array('flag_attivo, ordine', 'numerical', 'integerOnly'=>true),
			array('lista, codice, descrizione', 'length', 'max'=>50),
                        array('ordine', 'length', 'max'=>2),
                        array('lista+codice', 'application.extensions.uniqueMultiColumnValidator'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, lista, codice, descrizione, flag_attivo, ordine', 'safe', 'on'=>'search'),
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

        public function behaviors() {
		return array(
			'LoggableBehavior' => array(
				'class' => 'application.modules.audittrail.behaviors.LoggableBehavior',
			),
		);
	}
        
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'lista' => 'Lista',
			'codice' => 'Codice',
			'descrizione' => 'Descrizione',
			'flag_attivo' => 'Flag Attivo',
                        'ordine' => 'Ordine'
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

		$criteria->compare('id',$this->id);
		$criteria->compare('lista',$this->lista,true);
		$criteria->compare('codice',$this->codice,true);
		$criteria->compare('descrizione',$this->descrizione,true);
		$criteria->compare('flag_attivo',$this->flag_attivo);
                $criteria->compare('ordine',$this->ordine);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lov the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
