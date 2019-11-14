<?php

/**
 * This is the model class for table "yiischedules".
 *
 * The followings are the available columns in table 'yiischedules':
 * @property integer $id
 * @property string $name
 * @property string $frequency
 * @property string $scheduled
 * @property integer $executed
 * @property integer $deleted
 * @property string $url
 * @property string $command
 */
class Yiischedules extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'yiischedules';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, scheduled', 'required'),
			array('executed, deleted', 'numerical', 'integerOnly'=>true),
			array('name, frequency', 'length', 'max'=>100),
			array('url, command', 'length', 'max'=>500),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, frequency, scheduled, executed, deleted, url, command', 'safe', 'on'=>'search'),
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
			'name' => 'Name',
			'frequency' => 'Frequency',
			'scheduled' => 'Scheduled',
			'executed' => 'Executed',
			'deleted' => 'Deleted',
			'url' => 'Url',
			'command' => 'Command',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('frequency',$this->frequency,true);
		$criteria->compare('scheduled',$this->scheduled,true);
		$criteria->compare('executed',$this->executed);
		$criteria->compare('deleted',$this->deleted);
		$criteria->compare('url',$this->url,true);
		$criteria->compare('command',$this->command,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Yiischedules the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
