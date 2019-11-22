<?php

/**
 * This is the model class for table "course".
 *
 * The followings are the available columns in table 'course':
 * @property integer $id
 * @property string $protocol
 * @property string $name
 * @property string $date
 * @property integer $slot
 * @property string $last_edit_time
 * @property integer $source_id
 * @property integer $courseType_id
 * @property integer $teacher_id
 *
 * The followings are the available model relations:
 * @property Attendance[] $attendances
 * @property Coursetype $courseType
 * @property Source $source
 * @property Teacher $teacher
 */
class Course extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'course';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('protocol, name, date, source_id, courseType_id, teacher_id', 'required'),
			array('slot, source_id, courseType_id, teacher_id', 'numerical', 'integerOnly'=>true),
			array('protocol, name', 'length', 'max'=>45),
			array('last_edit_time', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, protocol, name, date, slot, last_edit_time, source_id, courseType_id, teacher_id', 'safe', 'on'=>'search'),
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
			'attendances' => array(self::HAS_MANY, 'Attendance', 'course_id'),
			'courseType' => array(self::BELONGS_TO, 'Coursetype', 'courseType_id'),
			'source' => array(self::BELONGS_TO, 'Source', 'source_id'),
			'teacher' => array(self::BELONGS_TO, 'Teacher', 'teacher_id'),
                        'location' => array(self::BELONGS_TO, 'Location', 'location_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'protocol' => 'Protocol',
			'name' => 'Name',
			'date' => 'Date',
			'slot' => 'Slot',
			'last_edit_time' => 'Last Edit Time',
			'source_id' => 'Source',
			'courseType_id' => 'Course Type',
			'teacher_id' => 'Teacher',
                        'location.nome' => 'Sede',
		);
	}


	public function getTeacher(){

	    return $model->teacher->employee->surname;
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
		$criteria->compare('protocol',$this->protocol,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('date',$this->date,true);
		$criteria->compare('slot',$this->slot);
		$criteria->compare('last_edit_time',$this->last_edit_time,true);
		$criteria->compare('source_id',$this->source_id);
		$criteria->compare('courseType_id',$this->courseType_id);
		$criteria->compare('teacher_id',$this->teacher_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Course the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
