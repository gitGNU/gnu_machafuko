<?php

class WebController extends ResourceController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	/**
	 * 
	 * @var CActiveDataProvider menu tag items. This property will be assigned to {@link CListView::items}.
	 */
	public $tags=array();

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('admin','delete','create','update'),
				'users'=>array('@'),
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
		$model=$this->loadModel($id);
		$waModel=null;
		
		// If the user is the resource owner it shows the account information.
		if($this->isOwner($model->id))
		{
			$waModel=$model->webAccount;
		}
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),'waModel'=>$waModel,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Web();
		$resModel=new Resource('web'); // Scenario web where the URI must be an URL.
		$usrModel=new UserResource();
		$waModel=new WebAccount();
		$continue=true;
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Web']) && isset($_POST['Resource']) && isset($_POST['WebAccount']))
		{
			$model->attributes=$_POST['Web'];
			$resModel->attributes=$_POST['Resource'];
			$resModel->tag=$_POST['Resource']['tag'];
			$waModel->attributes=$_POST['WebAccount'];
			
			$trx=$model->getDbConnection()->beginTransaction();
			try
			{	
				$resModel->created=date('Y-m-d'); 		// Created date: today.
				$usrModel->user=Yii::app()->user->id;	// Who have created this resource?
				
				// If come some web account attributes it changes scenario, it saves web account and it changes
				// the relations with web.
				if(!empty($waModel->id) || !empty($waModel->username) || !empty($waModel->email) || !empty($waModel->password))
				{
					$waModel->scenario='webAccount';
					if(!empty($waModel->password))
					{
						$waModel->password=md5($waModel->password);
						$waModel->passwordRepeat=md5($waModel->passwordRepeat);
					}
					if($waModel->save())
						$model->webAccount=$waModel;
					else
						$continue=false; // It comes values and there are some errors...
				}
				
				// If it can continues...
				if($continue)
				{
					// It resource, web, tags and tag resources.
					if($resModel->save())
					{
						// It saves Tag and TagResource.
						$tags=preg_split ("/[\s]*[,][\s]*/", $resModel->tag);
						foreach($tags as $t)
						{
							$tm=new Tag();
							$tm->name=strtolower($t);
							$tm->save();
							$trm=new TagResource();
							$trm->res=$resModel->id;
							$trm->tag=$tm->id;
							$trm->save();
						}

						// It saves resource model and web model.
						$usrModel->res=$resModel->id;
						if($usrModel->save())
						{
							// Tries to upload file.
							$file=Yii::app()->file;
							$file->saveAs($model,'logo',Yii::getPathOfAlias('webroot').Yii::app()->params['logodir'].'/'.$resModel->id);
							$model->logo=Yii::app()->params['logodir'].'/'.$resModel->id.'/'.$file->basename;
							$model->resource=$resModel;
							if($model->save())
							{
								$trx->commit(); // Before redirect.
								$this->redirect(array('view','id'=>$model->id));
							}
						}
					}
				}
				$trx->rollback();
			}
			catch(CException $e)
			{
				$trx->rollback();
				throw $e;
			}
		}
		
		$this->render('create',array(
				'model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel,
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
		$waModel=$model->webAccount ? $model->webAccount : new WebAccount();
		$continue=true;
		//foreach($resModel->tagResources as $tr)
			//$resModel->tag.=$tr->tagModel->name;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Web']) && isset($_POST['Resource']) && isset($_POST['WebAccount']))
		{
			$trx=$model->getDbConnection()->beginTransaction();
			try
			{
				// If come some web account attributes it changes scenario, it saves web account and it changes
				// the relations with web.
				$waModel->attributes=$_POST['WebAccount'];
				if(!empty($waModel->id) || !empty($waModel->username) || !empty($waModel->email) || !empty($waModel->password))
				{
					$waModel->scenario='webAccount';
					if(!empty($waModel->password))
					{
						$waModel->password=md5($waModel->password);
						$waModel->passwordRepeat=md5($waModel->passwordRepeat);
					}
					if($waModel->save())
						$model->webAccount=$waModel;
					else
						$continue=false; // It comes values and there are some errors...
				}
				
				if($continue)
				{
					$model->attributes=$_POST['Web'];
					$model->logo=CUploadedFile::getInstance($model, 'logo');
					$resModel->attributes=$_POST['Resource'];
					$resModel->tag=$_POST['Resource']['tag'];
					if($resModel->save())
					{
						// It saves Tag and TagResource.
						$tags=preg_split ("/[\s]*[,][\s]*/", $resModel->tag);
						$trm=new TagResource();
						$trm->deleteAllByAttributes(array('res'=>$resModel->id));
						foreach($tags as $t)
						{
							$tm=new Tag();
							$tm->name=strtolower($t);
							$tm->save();
							$trm=new TagResource();
							$trm->res=$resModel->id;
							$trm->tag=$tm->id;
							$trm->save();
						}
						
						// Tries to upload file.
						$file=Yii::app()->file;
						$file->moveAs($model,'logo',Yii::getPathOfAlias('webroot').Yii::app()->params['logodir'].'/'.$resModel->id);
						$model->logo=Yii::app()->params['logodir'].'/'.$resModel->id.'/'.$file->basename;
						$model->resource=$resModel;
						if($model->save())
						{
							$trx->commit(); // Before redirect.
							$this->redirect(array('view','id'=>$model->id));
						}
					}
				}
				$trx->rollback();
			}
			catch(CException $e)
			{
				$trx->rollback();
				throw $e;
			}
		}
		else
		{
			$tags=array();
			foreach($resModel->tagResources as $tr)
			{
				$tags[]=$tr->tagModel->name;
			}
			$resModel->tag=implode(", ",$tags);
		}

		$this->render('update',array(
			'model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel,
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
			$model=$this->loadModel($id);
			// Delete the logo (if exists).
			if(!empty($model->logo))
			{
				Yii::app()->file->deleteFile($model->logo);
			}
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * List all models. If come ID it filters by the ID tag.
	 *
	 * @param string $id is the tag ID.
	 */
	public function actionIndex($id=null)
	{
		$this->layout="//layouts/column2menu2";
	
		// It creates the tags right menu.
		$this->tags=new CActiveDataProvider('Tag',
				array(
						'criteria'=>array(
								'join'=>'join TagResource tr on (tr.tag=t.id)',
								'distinct'=>true,
						),
				)
		);
		
		// The guest users only can view public resources.
		if(Yii::app()->user->isGuest)
		{
			$join='join Resource r on (t.id=r.id) join UserResource ur on (t.id=ur.res and r.privacy=0)';
			$params=array();
			if($id)
			{
				$join.=' join TagResource tr on (t.id=tr.res and tr.tag=:tagId)';
				$params=array(':tagId'=>$id);
			}
			$dataProvider=new CActiveDataProvider('Web',
				array(
						'criteria'=>array(
								'join'=>$join,
								'params'=>$params,
						),
				));
		}
		// The registered users can view his/her resources and public resources.
		else
		{
			$join='join Resource r on (t.id=r.id) join UserResource ur on (t.id=ur.res and (r.privacy=0 or ur.user=:userId))';
			$params=array(':userId'=>Yii::app()->user->id);
			if($id)
			{
				$join.=' join TagResource tr on (t.id=tr.res and tr.tag=:tagId)';
				$params=array_merge($params, array(':tagId'=>$id));
			}
			$dataProvider=new CActiveDataProvider('Web',
					array(
							'criteria'=>array(
									'join'=>$join,
									'params'=>$params,
							),
					));
		}
		
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Web('search');
		$resModel=new Resource();
		
		// clear any default values
		$model->unsetAttributes();
		$resModel->unsetAttributes();
		
		if(isset($_GET['Web']))
			$model->attributes=$_GET['Web'];
		if(isset($_GET['Resource']))
			$resModel->attributes=$_GET['Resource'];

		$this->render('admin',array(
			'model'=>$model,'resModel'=>$resModel,
		));
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Web::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='web-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
