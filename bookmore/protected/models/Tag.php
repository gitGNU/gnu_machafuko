<?php

/**
 * This is the model class for table "Tag".
 *
 * The followings are the available columns in table 'Tag':
 * @property integer $id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property TagResource[] $tagResources
 */
class Tag extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
     * @return Tag    the static model class
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
        return 'Tag';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name', 'required'),
            array('name', 'length', 'max'=>50),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name', 'safe', 'on'=>'search'),
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
            'tagResources' => array(self::HAS_MANY, 'TagResource', 'tag'),
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
        );
    }

    /**
     * Before save a tag it needs to test if exists or not this tag.
     *
     * @see CActiveRecord::beforeSave()
     */
    public function beforeSave()
    {
        $model=$this->findByAttributes(array('name'=>$this->name));
        if ($model) {
            $this->id=$model->id;

            return false;
        } else {
            return parent::beforeSave();
        }
    }
    
    /**
     * Split $tags by ',' character and save all tags.
     * 
     * @param string $tags a string with a list of tags split by ',' character.
     * @param integer $resId the identifier of the resource.
     * @param boolean $update this attribute specify if it is an update.
     */
    public function saveTags($tags, $resId, $update=false) {       
		$tags=preg_split ("/[\s]*[,][\s]*/", $tags);
		if ($update) {
		    $trm=new TagResource();
		    $trm->deleteAllByAttributes(array('res'=>$resId));
		}
		foreach ($tags as $t) {
			$tm=new Tag();
			$tm->name=strtolower($t);
			$tm->save();
			$trm=new TagResource();
			$trm->res=$resId;
			$trm->tag=$tm->id;
			$trm->save();
		}

    	return true;
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
        $criteria->compare('name',$this->name,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
