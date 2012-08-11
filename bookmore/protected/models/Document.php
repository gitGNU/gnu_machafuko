<?php

/**
 * This is the model class for table "Document".
 *
 * The followings are the available columns in table 'Document':
 * @property integer $id
 * @property string $mimeType
 *
 * The followings are the available model relations:
 * @property Resource $resource
 */
class Document extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Document the static model class
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
		return 'Document';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('mimeType','file','types'=>'jpg,gif,png,svg,txt,pdf,odt,odp,ods,odb,doc'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, mimeType, resource.name, resource.description','safe','on'=>'search'),
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
			'resource' => array(self::BELONGS_TO, 'Resource', 'id'),
		);
	}

	/**
	 * To add behaviours.
	 * @see CModel::behaviors()
	 */
	public function behaviors()
	{
		return array(
				'activerecord-relation'=>array('class'=>'ext.behaviors.activerecord-relation.EActiveRecordRelationBehavior'),
		);
	}
	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id'=>'ID',
			'mimeType'=>Yii::t('bm','Document type'),
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

		$criteria->compare('t.id',$this->id);
		$criteria->compare('mimeType',$this->mimeType,true);
		if(isset($_GET['Resource']))
		{
			$criteria->with[]='resource';
			$criteria->addSearchCondition('name',$_GET['Resource']['name'],true);
			$criteria->addSearchCondition('description',$_GET['Resource']['description'],true);
		}
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}