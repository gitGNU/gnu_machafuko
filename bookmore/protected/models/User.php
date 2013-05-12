<?php

/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 *
 * The followings are the available model relations:
 * @property UserComment[] $userComments
 * @property UserResource[] $userResources
 */
class User extends CActiveRecord
{
    public $emailRepeat;
    public $passwordRepeat;
    public $rawPassword;
    
    /**
     * Returns the static model of the specified AR class.
     * @param  string $className active record class name.
     * @return User   the static model class
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
        return 'User';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('username, email, emailRepeat, rawPassword, passwordRepeat', 'required'),
            array('username, email, emailRepeat, rawPassword, passwordRepeat', 'length', 'max'=>128),
            array('email', 'email'),
            array('emailRepeat', 'compare', 'compareAttribute'=>'email'),
            array('passwordRepeat', 'compare', 'compareAttribute'=>'rawPassword'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, username, email, password', 'safe', 'on'=>'search'),
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
            'userComments' => array(self::HAS_MANY, 'UserComment', 'user'),
            'userResources' => array(self::HAS_MANY, 'UserResource', 'user'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => Yii::t('bm', 'Username'),
            'email' => Yii::t('bm', 'E-mail'),
            'emailRepeat' => Yii::t('bm', 'Repeat e-mail'),
            'passwordRepeat' => Yii::t('bm', 'Repeat password'),
            'rawPassword' => Yii::t('bm', 'Password'),
        );
    }

    /**
     * Before save a user it needs to crypt password.
     *
     * @see CActiveRecord::beforeSave()
     */
    public function beforeSave()
    {
    	if (!empty($this->rawPassword)) {
          $bcrypt = new BCrypt();
          $this->password=$bcrypt->hash($this->rawPassword);
    	}
    
    	return parent::beforeSave();
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
        $criteria->compare('username',$this->username,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('password',$this->password,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
