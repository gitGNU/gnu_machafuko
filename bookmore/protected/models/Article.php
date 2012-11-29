<?php

/**
 * This is the model class for table "Article".
 *
 * The followings are the available columns in table 'Article':
 * @property integer $id
 * @property integer $res
 * @property integer $priority
 * @property integer $readed
 *
 * The followings are the available model relations:
 * @property Priority $priorityobj
 * @property Resource $res0
 */
class Article extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Article the static model class
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
		return 'Article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('res', 'required'),
			array('res, priority, readed', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, res, priority, readed', 'safe', 'on'=>'search'),
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
			'priorityobj' => array(self::BELONGS_TO, 'Priority', 'priority'),
			'res0' => array(self::BELONGS_TO, 'Resource', 'res'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'res' => 'Resource',
			'priority' => 'Priority',
			'readed' => 'Readed',
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
		$criteria->compare('res',$this->res);
		$criteria->compare('priority',$this->priority);
		$criteria->compare('readed',$this->readed);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}