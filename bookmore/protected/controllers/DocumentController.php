<?php

class DocumentController extends ResourceController
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
		$model=new Document();
		$resModel=new Resource();
		$usrModel=new UserResource();
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		if(isset($_POST['Document']) && isset($_POST['Resource']))
		{
			$trx=$model->getDbConnection()->beginTransaction();
			try
			{
				// Get resource model attributes.
				$resModel->attributes=$_POST['Resource'];
				$resModel->created=date('Y-m-d');
				$resModel->tag=$_POST['Resource']['tag'];
				
				// Tries to upload file.
				$file=Yii::app()->file;
				$file->saveAs($model,'mimeType',Yii::getPathOfAlias('webroot').'/protected/upload/documents/'.$resModel->created);
				
				// Get document model attributes.
				$model->attributes=$_POST['Document'];
				$model->mimeType=$file->mimeType;
				
				// Complet resource model attributes.
				$resModel->uri=$file->dirname.'/'.$file->basename;
				$usrModel->user=Yii::app()->user->id;
				
				// Realizes the saves.
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
					
					$usrModel->res=$resModel->id;
					if($usrModel->save())
					{
						$model->resource=$resModel;
						if($model->save())
						{
							$trx->commit();
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

		$this->render('create',array(
			'model'=>$model,'resModel'=>$resModel,
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
		//foreach($resModel->tagResources as $tr)
			//$resModel->tag.=$tr->tagModel->name;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Document']) && isset($_POST['Resource']))
		{
			$trx=$model->getDbConnection()->beginTransaction();
			try
			{
				// Get resource attributes.
				$resModel->attributes=$_POST['Resource'];
				$resModel->tag=$_POST['Resource']['tag'];
								
				// Tries to upload file.
				$file=Yii::app()->file;
				$file->moveAs($model,'mimeType',Yii::getPathOfAlias('webroot').'/protected/upload/documents/'.$resModel->created);
				
				// Get document model attributes.
				$model->attributes=$_POST['Document'];
				$model->mimeType=$file->mimeType;
				
				// Complet resource model attributes.
				$resModel->uri=$file->dirname.'/'.$file->basename;
				$usrModel->user=Yii::app()->user->id;
				
				// Realizes the saves.				
				if($resModel->save())
				{
					// It updates Tag and TagResource.
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
					
					$model->resource=$resModel;
					if($model->save())
					{
						$trx->commit();
						$this->redirect(array('view','id'=>$model->id));
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
			'model'=>$model,'resModel'=>$resModel,
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
			Yii::app()->file->deleteFile($model->resource->uri);
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
			$dataProvider=new CActiveDataProvider('Document',
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
			$dataProvider=new CActiveDataProvider('Document',
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
		$model=new Document('search');
		$resModel=new Resource();
		
		// clear any default values
		$model->unsetAttributes();
		$resModel->unsetAttributes();
		
		if(isset($_GET['Document']))
			$model->attributes=$_GET['Document'];
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
		$model=Document::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='document-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
