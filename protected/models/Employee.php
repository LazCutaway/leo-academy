<?php

/**
 * This is the model class for table "employee".
 *
 * The followings are the available columns in table 'employee':
 * @property integer $id
 * @property string $identification
 * @property string $surname
 * @property string $name
 * @property string $email
 * @property integer $is_deleted
 * @property string $last_edit_time
 * @property string $supervisor_email
 * @property integer $employeeType_id
 * @property integer $source_id
 *
 * The followings are the available model relations:
 * @property Attendance[] $attendances
 * @property Employeetype $employeeType
 * @property Source $source
 * @property Teacher[] $teachers
 */
class Employee extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'employee';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('identification, surname, name, email, employeeType_id, source_id', 'required'),
			array('is_deleted, employeeType_id, source_id', 'numerical', 'integerOnly'=>true),
			array('identification, surname, name, email, supervisor_email', 'length', 'max'=>45),
			array('last_edit_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, identification, surname, name, email, is_deleted, last_edit_time, supervisor_email, employeeType_id, source_id', 'safe', 'on'=>'search'),
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
			'attendances' => array(self::HAS_MANY, 'Attendance', 'employee_id'),
			'employeeType' => array(self::BELONGS_TO, 'Employeetype', 'employeeType_id'),
			'source' => array(self::BELONGS_TO, 'Source', 'source_id'),
			'teachers' => array(self::HAS_MANY, 'Teacher', 'employee_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'identification' => 'Identification',
			'surname' => 'Surname',
			'name' => 'Name',
			'email' => 'Email',
			'is_deleted' => 'Is Deleted',
			'last_edit_time' => 'Last Edit Time',
			'supervisor_email' => 'Supervisor Email',
			'employeeType_id' => 'Employee Type',
			'source_id' => 'Source',
            'employeeType.description'=>'Tipo dipendente'
		);
	}

	public function getEmployeetype(){
	    if($this->employeeType) {
            return $this->employeeType->description;
        }
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
		$criteria->compare('identification',$this->identification,true);
		$criteria->compare('surname',$this->surname,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('is_deleted',$this->is_deleted);
		$criteria->compare('last_edit_time',$this->last_edit_time,true);
		$criteria->compare('supervisor_email',$this->supervisor_email,true);
		$criteria->compare('employeeType_id',$this->employeeType_id);
		$criteria->compare('source_id',$this->source_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Employee the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
