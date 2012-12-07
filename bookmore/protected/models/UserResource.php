<?php

/**
 * This is the model class for table "UserResource".
 *
 * The followings are the available columns in table 'UserResource':
 * @property integer $id
 * @property integer $res
 * @property integer $user
 *
 * The followings are the available model relations:
 * @property Resource $res0
 * @property User $user0
 */
class UserResource extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UserResource the static model class
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
		return 'UserResource';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('res, user', 'required'),
			array('res, user', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, res, user', 'safe', 'on'=>'search'),
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
			'res0' => array(self::BELONGS_TO, 'Resource', 'res'),
			'user0' => array(self::BELONGS_TO, 'User', 'user'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'res' => 'Resource ID',
			'user' => 'User ID',
		);
	}
	
	/**
	 * Before save a user resource it needs to test if exists or not this user resource.
	 *
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
		$model=$this->findByAttributes(array('res'=>$this->res,'user'=>$this->user));
		if($model)
		{
			$this->id=$model->id;
			return false;
		}
		else
		{
			return parent::beforeSave();
		}
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
		$criteria->compare('res',$this->res);
		$criteria->compare('user',$this->user);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}