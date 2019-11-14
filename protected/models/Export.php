<?php

/**
 * This is the model class for table "export".
 *
 * The followings are the available columns in table 'export':
 * @property integer $id
 * @property string $query
 * @property string $json_params
 * @property string $description
 * @property string $nome
 *
 * The followings are the available model relations:
 */
class Export extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Export the static model class
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
		return 'export';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('query, nome', 'required'),
			array('nome', 'length', 'max'=>255),
			array('json_params, description', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, query, json_params, description, nome', 'safe', 'on'=>'search'),
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
			'query' => 'Query',
			'json_params' => 'Json Params',
			'description' => 'Descrizione',
			'nome' => 'Nome',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('query',$this->query,true);
		$criteria->compare('json_params',$this->json_params,true);		
		$criteria->compare('description',$this->description,true);
		$criteria->compare('nome',$this->nome,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}