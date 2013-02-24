<?php

class MyHowToController extends ResourceController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform...
				'actions'=>array('index', 'view', 'searchbytag'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform...
				'actions'=>array('admin', 'create'),
				'users'=>array('@'),
			),
            array('allow', // allow own user to perform...
                'actions'=>array('delete', 'update'),
                'expression'=>'ResourceController::isOwner()',
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MyHowTo;
		$resModel=new Resource;
		$usrModel=new UserResource();
		$tagModel=new Tag();
		$this->layout='//layouts/column1';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		if(isset($_POST['MyHowTo']) && isset($_POST['Resource']))
		{
			$model->attributes=$_POST['MyHowTo'];
			$resModel->attributes=$_POST['Resource'];
			$resModel->uri=$resModel->name;
			$resModel->tag=$_POST['Resource']['tag'];
			$resModel->created=date('Y-m-d'); 		// Created date: today.
			$usrModel->user=Yii::app()->user->id;   // Who have created this 
			                                        // resource?
			
			// Start transaction.
			$trx=$model->getDbConnection()->beginTransaction();
			try {
    			// Insert the Resource model.
    			if($resModel->save()) {
    			    //Insert the UserResource.
    			    $usrModel->res=$resModel->id;
    			    if($usrModel->save()) {
    			        // Insert the list of Tag's.
    			        if($tagModel->saveTags($resModel->tag, $resModel->id)) {
    			            // Insert the HowTo.
    			            $model->resource=$resModel;
    			            $model->id=$resModel->id;
    			            if($model->save()){
    			                $trx->commit();
    			                $this->redirect(array('view','id'=>$model->id));
    			            }
    			        }
    			    }
    			}
    			
    			$trx->rollback();
			} catch(CException $e) {
			    $trx->rollback();
			    throw $e;
			}
		}

		$this->render('create',array(
			'model'=>$model, 'resModel'=>$resModel,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$resModel=$model->resource;
		$resModel->uri=$resModel->name;
		$tagModel=new Tag();
		$this->layout='//layouts/column1';
		
		// Prepare tags. It needs if there are not post data to show they into
		// tag form input.
		$tags=array();
		foreach ($resModel->tagResources as $tr) {
			$tags[]=$tr->tagModel->name;
		}
		$resModel->tag=implode(", ",$tags);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MyHowTo']) && isset($_POST['Resource']))
		{
		    // Get new data from the post.
		    $model->attributes=$_POST['MyHowTo'];
		    $resModel->attributes=$_POST['Resource'];
		    $resModel->uri=$resModel->name;
		    $resModel->tag=$_POST['Resource']['tag'];
		    
		    // Start transaction.
		    $trx=$model->getDbConnection()->beginTransaction();
		    try {
		    	// Update the Resource model.
		    	if($resModel->save()) {
	    			if($tagModel->saveTags($resModel->tag, $resModel->id,
	    			                       true)) {
	    				// Update the HowTo.
	    				if($model->save()){
	    					$trx->commit();
	    					$this->redirect(array('view','id'=>$model->id));
	    				}
	    			}
		    	}
		    	 
		    	$trx->rollback();
		    } catch(CException $e) {
		    	$trx->rollback();
		    	throw $e;
		    }
		}

		$this->render('update',array('model'=>$model, 'resModel'=>$resModel,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			parent::loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id=null)
	{
	    $this->layout="//layouts/column2menu2";
	    
	    // It creates the tags right menu.
	    $this->setTags('myHowTo/index');
	    
	    // The guest users only can view public resources.
	    if (Yii::app()->user->isGuest) {
	    	$join='join Resource r on (t.id=r.id) join UserResource ur on (t.id=ur.res and r.privacy=0)';
	    	$params=array();
	    	if ($id) {
	    		$join.=' join TagResource tr on (t.id=tr.res and tr.tag=:tagId)';
	    		$params=array(':tagId'=>$id);
	    	}
	    	$dataProvider=new CActiveDataProvider('MyHowTo',
	    			array(
	    					'criteria'=>array(
	    							'join'=>$join,
	    							'params'=>$params,
	    					),
	    			));
	    }
	    // The registered users can view his/her resources and public resources.
	    else {
	    	$join='join Resource r on (t.id=r.id) join UserResource ur on (t.id=ur.res and (r.privacy=0 or ur.user=:userId))';
	    	$params=array(':userId'=>Yii::app()->user->id);
	    	if ($id) {
	    		$join.=' join TagResource tr on (t.id=tr.res and tr.tag=:tagId)';
	    		$params=array_merge($params, array(':tagId'=>$id));
	    	}
	    	$dataProvider=new CActiveDataProvider('MyHowTo',
	    			array(
	    					'criteria'=>array(
	    							'join'=>$join,
	    							'params'=>$params,
	    					),
	    			));
	    }
	    
		//$dataProvider=new CActiveDataProvider('MyHowTo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MyHowTo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MyHowTo']))
			$model->attributes=$_GET['MyHowTo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MyHowTo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='my-how-to-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
