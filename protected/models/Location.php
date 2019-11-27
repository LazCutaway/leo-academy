<?php

/**
 * This is the model class for table "location".
 *
 * The followings are the available columns in table 'location':
 * @property integer $id
 * @property string $nome
 * @property string $indirizzo
 * @property string $cap
 * @property string $citta
 *
 * The followings are the available model relations:
 * @property Course[] $courses
 */
class Location extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'location';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nome, indirizzo, cap, citta', 'required'),
			array('nome, indirizzo, cap, citta', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nome, indirizzo, cap, citta', 'safe', 'on'=>'search'),
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
			'courses' => array(self::HAS_MANY, 'Course', 'location_id'),
                         
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nome' => 'Nome',
			'indirizzo' => 'Indirizzo',
			'cap' => 'Cap',
			'citta' => 'Citta',
                        'listacorsi' => 'Lista corsi',
		);
	}
        
        public function getListacorsi(){
            
            $courses=$this->courses;
            
            $html= '<ul>';
            
            foreach($courses as $course){
                
               $nomecorso=$course->name;
               $datacorso=$course->date;
               
               $html.= '<li>'.$nomecorso.' | '.$datacorso.'</li>';
               
            }
            $html.= '</ul>';
            
            return $html;
            
            
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
		$criteria->compare('nome',$this->nome,true);
		$criteria->compare('indirizzo',$this->indirizzo,true);
		$criteria->compare('cap',$this->cap,true);
		$criteria->compare('citta',$this->citta,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Location the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
