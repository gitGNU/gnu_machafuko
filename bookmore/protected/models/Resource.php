<?php

/**
 * This is the model class for table "Resource".
 *
 * The followings are the available columns in table 'Resource':
 * @property integer $id
 * @property string $uri
 * @property string $name
 * @property string $description
 * @property string $created
 * @property integer $privacy
 *
 * The followings are the available model relations:
 * @property Document $document
 * @property ResourceValoration[] $resourceValorations
 * @property TagResource[] $tagResources
 * @property UserResource[] $userResources
 * @property Web $web
 */
class Resource extends CActiveRecord
{
    /**
     * Auxiliary attribute to get tags.
     *
     * @var string list of tags separated by ','.
     */
    public $tag;

    /**
     * Returns the static model of the specified AR class.
     * @param  string   $className active record class name.
     * @return Resource the static model class
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
        return 'Resource';
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
            array('privacy', 'numerical', 'integerOnly'=>true),
            array('uri', 'required'),
            array('uri', 'url', 'validSchemes'=>array('http', 'https', 'ftp'),'on'=>'web'),
            array('uri, description', 'length', 'max'=>200),
            array('name', 'length', 'max'=>100),
            array('created', 'date', 'format'=>array('d-M-yyyy', 'yyyy-M-d')),
            array('uri', 'checkMyUnique'),
            //array('uri', 'uniqueValidator'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, uri, name, description, created, privacy', 'safe', 'on'=>'search'),
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
            'document' => array(self::HAS_ONE, 'Document', 'id'),
            'resourceValorations' => array(self::HAS_MANY, 'ResourceValoration', 'res'),
            'tagResources' => array(self::HAS_MANY, 'TagResource', 'res'),
            'userResources' => array(self::HAS_MANY, 'UserResource', 'res'),
            'web' => array(self::HAS_ONE, 'Web', 'id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'uri' => 'Uri',
            'name' => Yii::t('bm', 'Name'),
            'description' => Yii::t('bm', 'Description'),
            'created' => Yii::t('bm', 'Date created'),
            'privacy' => Yii::t('bm', 'Privacy'),
            'logo' => Yii::t('bm', 'Logo'),
            'mimeType' => Yii::t('bm', 'Mime type'),
            'tag' => Yii::t('bm', 'Tags'),
        );
    }

    /**
     * It checks if the URI exist into Resource table to the user id.
     */
    public function checkMyUnique($attribute, $params)
    {
      $criteria = new CDbCriteria;
      $criteria->join = 'join UserResource ur on (t.id = ur.res and ur.user = :userId and t.uri = :uri)';
      $criteria->params = array(':userId'=>Yii::app()->user->id, ':uri'=>$this->uri);
      if ($this->find($criteria))
        $this->addError($attribute, $attribute . ' ' . 
                        Yii::t('bm', 'must be unique to the user'));
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
        $criteria->compare('uri',$this->uri,true);
        $criteria->compare('name',$this->name,true);
        $criteria->compare('description',$this->description,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('privacy',$this->privacy);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }

    /**
     * This function check unique restrictions. This works with update and insert.
     *
     * @param string $attribute Attribute.
     * @param string $params    Params.
     */
    public function uniqueValidator($attribute, $params)
    {
        // If is update and the attribute is the same return.
        if (!empty($this->id)) {
            $current=$this->findByPk($this->id);
            if($current->$attribute==$this->$attribute)

                return;
        }
        if($this->findByAttributes(array($attribute=>$this->$attribute)))
            $this->addError($attribute, "The attribute '".$attribute."' must to be unique.");
    }
}
