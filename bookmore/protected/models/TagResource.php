<?php

/**
 * This is the model class for table "TagResource".
 *
 * The followings are the available columns in table 'TagResource':
 * @property integer $id
 * @property integer $res
 * @property integer $tag
 *
 * The followings are the available model relations:
 * @property Resource $resModel
 * @property Tag $tagModel
 */
class TagResource extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param  string      $className active record class name.
     * @return TagResource the static model class
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
        return 'TagResource';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('res, tag', 'required'),
            array('res, tag', 'numerical', 'integerOnly'=>true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, res, tag', 'safe', 'on'=>'search'),
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
            'resModel' => array(self::BELONGS_TO, 'Resource', 'res'),
            'tagModel' => array(self::BELONGS_TO, 'Tag', 'tag'),
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
            'tag' => 'Tag ID',
        );
    }

    /**
     * Before save a tag resource it needs to test if exists or not this tag resource.
     *
     * @see CActiveRecord::beforeSave()
     */
    public function beforeSave()
    {
        $model=$this->findByAttributes(array('res'=>$this->res,'tag'=>$this->tag));
        if ($model) {
            $this->id=$model->id;

            return false;
        } else {
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
        $criteria->compare('tag',$this->tag);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
