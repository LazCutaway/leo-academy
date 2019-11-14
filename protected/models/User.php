<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property string $surname
 *
 * The followings are the available model relations:
 * @property AuditLog[] $auditLogs
 * @property Track[] $tracks
 * @property UserGenre[] $userGenres
 * @property UserTrackBookmark[] $userTrackBookmarks
 */
class User extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, password, name, surname', 'required'),
			array('username, password, name, surname', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, name, surname', 'safe', 'on'=>'search'),
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
			'auditLogs' => array(self::HAS_MANY, 'AuditLog', 'user_id'),
			'tracks' => array(self::HAS_MANY, 'Track', 'owner_id'),
			'userGenres' => array(self::HAS_MANY, 'UserGenre', 'user_id'),
			'userTrackBookmarks' => array(self::HAS_MANY, 'UserTrackBookmark', 'user_id'),
		);
	}
	
	public function behaviors() {
            return array(
                'LoggableBehavior'=> array(
                    'class' => 'application.modules.audittrail.behaviors.LoggableBehavior',
                )
            );
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'password' => 'Password',
			'name' => 'Name',
			'surname' => 'Surname',
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
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('surname',$this->surname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public function isAdmin(){
		$ruolo = Yii::app()->db->createCommand()
    		->select('itemname, userid')
    		->from('srbac_assignments')
                ->where('userid=:id and itemname=:ruolo', array(':id'=>$this->id, ':ruolo'=>'Admin'))
    		->queryRow();

		return($ruolo ? true : false);
	}
}
