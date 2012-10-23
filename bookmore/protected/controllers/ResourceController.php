<?php

class ResourceController extends Controller
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
				'actions'=>array('index','view','searchbytag'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create', 'update' and 'delete' actions
				'actions'=>array('admin', 'create','update','delete','searchbytag'),
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
		$model=new Resource;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Resource']))
		{
			$model->attributes=$_POST['Resource'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Resource']))
		{
			$model->attributes=$_POST['Resource'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
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
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	/**
	 * Set tags var.
	 */
	public function setTags($url='resource/index')
	{
		$tagDataProvider=new CActiveDataProvider('Tag',
				array(
						'criteria'=>array(
								'join'=>'join TagResource tr on (tr.tag=t.id)',
								'distinct'=>true,
						),
				)
		);
		$tagList=$tagDataProvider->getData();
		foreach($tagList as $tag)
			$this->tags[]=array('label'=>$tag->name,'url'=>array($url.'/'.$tag->id));
	}
	
	/**
	 * It gets the resources through a tag name.
	 */
	public function actionSearchByTag()
	{
		$this->layout="//layouts/column2menu2";
		$dataProvider=null;
		
		// It creates the tags right menu.
		$this->setTags();
		
		if(isset($_POST['tag']))
		{
			$name=$_POST['tag'];
			
			// The guest users only can view public resources.
			if(Yii::app()->user->isGuest)
			{
				$join='join UserResource ur on (t.id=ur.res and t.privacy=0)' .
					 ' join TagResource tr on (t.id=tr.res)' .
				     ' join Tag ta on (ta.id=tr.tag)';
				$criteria=new CDbCriteria();
				$criteria->compare('ta.name',$name,true);
				$criteria->join=$join;
				$dataProvider=new CActiveDataProvider('Resource',
						array(
								'criteria'=>$criteria
						));
			}
			// The registered users can view his/her resources and public resources.
			else
			{
				$join='join UserResource ur on (t.id=ur.res)' .
					 ' join TagResource tr on (t.id=tr.res)' .
					 ' join Tag ta on (ta.id=tr.tag)';
				$criteria=new CDbCriteria();
				$criteria->compare('t.privacy','0',false);
				$criteria->compare('ur.user',Yii::app()->user->id,false,'OR');
				$criteria->compare('ta.name',$name,true);
				$criteria->join=$join;
				$dataProvider=new CActiveDataProvider('Resource',
						array(
								'criteria'=>$criteria
						));
			}
		}
		
		$this->render('index',array(
				'dataProvider'=>$dataProvider,
		));
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
		$this->setTags();
		
		// The guest users only can view public resources.
		if(Yii::app()->user->isGuest)
		{
			$join='join UserResource ur on (t.id=ur.res and t.privacy=0)';
			$params=array();
			if($id)
			{
				$join.=' join TagResource tr on (t.id=tr.res and tr.tag=:tagId)';
				$params=array(':tagId'=>$id);
			}
			$dataProvider=new CActiveDataProvider('Resource',
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
			$join='join UserResource ur on (t.id=ur.res and (t.privacy=0 or ur.user=:userId))';
			$params=array(':userId'=>Yii::app()->user->id);
			if($id)
			{
				$join.=' join TagResource tr on (t.id=tr.res and tr.tag=:tagId)';
				$params=array_merge($params, array(':tagId'=>$id));
			}
			$dataProvider=new CActiveDataProvider('Resource',
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
		$model=new Resource('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Resource']))
			$model->attributes=$_GET['Resource'];

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
		$model=Resource::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * This function checks if the user is the resource owner.
	 * 
	 * @param string $id the resource id.
	 * @return boolean this function returns true if this user is the resource $id owner.
	 */
	protected function isOwner($id = null)
	{
		if (!$id)
		{
			if (isset($_GET['id']))
			{
				$id = $_GET['id'];
			}	
		}
		
		if(Yii::app()->user->isGuest)
			return false;
		else
		{
			//$model=$this->loadModel($id);
			$model=UserResource::model()->findByAttributes(
				array('res'=>$id,
				      'user'=>Yii::app()->user->id));
			if($model)
				return true;
			else
				return false;
		}
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='resource-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
