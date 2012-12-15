<?php

class SiteController extends Controller
{
    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
        );
    }

    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        // renders the view file 'protected/views/site/index.php'
        // using the default layout 'protected/views/layouts/main.php'
        $dpArticle=null;
        $dpQueue=null;
        
    	// The guest users only can view public resources.
        if (!Yii::app()->user->isGuest) {
            // Articles.
            $join='join Resource r on (t.id=r.id) '.
                'join UserResource ur on (t.id=ur.res and ur.user=:userId)'.
                'join Article a on (t.id=a.res and a.readed=0)';
            $params=array(':userId'=>Yii::app()->user->id);
            $dpArticle=new CActiveDataProvider('Web',
                    array(
                            'pagination'=>array('pageSize'=>4),
                            'criteria'=>array(
                                    'join'=>$join,
                                    'params'=>$params,
                                    ),
                            ));
            
            // Queue resources.
            $join='join Resource r on (t.id=r.id) '.
            		'join UserResource ur on (t.id=ur.res and ur.user=:userId)'.
            		'join Queue q on (t.id=q.res)';
            $params=array(':userId'=>Yii::app()->user->id);
            $dpQueue=new CActiveDataProvider('Web',
            		array(
                            'pagination'=>array('pageSize'=>4),
            				'criteria'=>array(
            						'join'=>$join,
            						'params'=>$params,
            				),
            		));
        }
        
        $this->render('index', array('dpArticle'=>$dpArticle, 'dpQueue'=>$dpQueue));
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError()
    {
        if ($error=Yii::app()->errorHandler->error) {
            if(Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

    /**
     * Displays the contact page
     */
    public function actionContact()
    {
        $model=new ContactForm;
        if (isset($_POST['ContactForm'])) {
            $model->attributes=$_POST['ContactForm'];
            if ($model->validate()) {
                $headers="From: {$model->email}\r\nReply-To: {$model->email}";
                mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
                Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
                $this->refresh();
            }
        }
        $this->render('contact',array('model'=>$model));
    }

    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $model=new LoginForm;

        // if it is ajax validation request
        if (isset($_POST['ajax']) && $_POST['ajax']==='login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if($model->validate() && $model->login())
                $this->redirect(Yii::app()->user->returnUrl);
        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }
}
