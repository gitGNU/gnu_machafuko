<?php

class WebController extends ResourceController
{
	/**
	 * @var integer it specify how many items per page it will show into import web form. 
	 */
	const PAGESIZE=2;
	
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
			array('allow',  // all users can...
				'actions'=>array('index','view','searchbytag'),
				'users'=>array('*'),
			),
			array('allow', // all users with accounts can...
				'actions'=>array('admin', 'create','update','import','importsave','searchbytag'),
				'users'=>array('@'),
			),
			array('allow', // the own user can...
				'actions'=>array('delete','update'),
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
		$model=$this->loadModel($id);
		$waModel=null;
		$isOwner=$this->isOwner($model->id);
		
		// If the resource is private and this user is not the owner...
		if($model->resource->privacy)
		{
			if(!$isOwner)
			{
				throw new CHttpException(400,Yii::t('bm','You can not access to that resource'));
			}
		}
		
		// If the user is the resource owner it shows the account information.
		if($isOwner)
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
		$articleModel=new Article();
		$articleModel->priorityobj=Priority::model()->findAll();
		$continue=true;
		$this->layout='//layouts/column1';
		
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
							if($file->saveAs($model,'logo',Yii::getPathOfAlias('webroot').Yii::app()->params['logodir'].'/'.$resModel->id))
								$model->logo=Yii::app()->params['logodir'].'/'.$resModel->id.'/'.$file->basename;
							else
								$model->logo='';
							$model->resource=$resModel;
							if($model->save())
							{
								// If there is Article data...
								if(isset($_POST['Article']) && isset($_POST['isarticle']))
								{
									$articleModel->res=$resModel->id;
									$articleModel->priority=$_POST['Article']['priority'];
									if($articleModel->save())
									{
										$trx->commit();
										$this->redirect(array('view','id'=>$model->id));
									}									
								}
								else
								{
									$trx->commit(); // Before redirect.
									$this->redirect(array('view','id'=>$model->id));
								}
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
				'model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel,'articleModel'=>$articleModel,
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
		$aux=Article::model()->findByAttributes(array('res'=>$id));
		$articleModel=$aux?$aux:new Article();
		$articleModel->priorityobj=Priority::model()->findAll();
		$continue=true;
		$this->layout='//layouts/column1';
		
		// Prepare tags.
		$tags=array();
		foreach($resModel->tagResources as $tr)
		{
			$tags[]=$tr->tagModel->name;
		}
		$resModel->tag=implode(", ",$tags);

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
						if($file->moveAs($model,'logo',Yii::getPathOfAlias('webroot').Yii::app()->params['logodir'].'/'.$resModel->id))
						{
							$model->logo=Yii::app()->params['logodir'].'/'.$resModel->id.'/'.$file->basename;
							$attr=array('id','logo','account');
						}
						else
							$attr=array('id','account');
							
						$model->resource=$resModel;
						if($model->save(true,$attr))
						{
							// If there is Article data...
							if(isset($_POST['Article']) && isset($_POST['isarticle']))
							{
								$articleModel->res=$resModel->id;
								$articleModel->priority=$_POST['Article']['priority'];
								if($articleModel->save())
								{
									$trx->commit();
									$this->redirect(array('view','id'=>$model->id));
								}
							}
							else if($articleModel->res)
							{
								if($articleModel->delete())
								{
									$trx->commit(); // Before redirect.
									$this->redirect(array('view','id'=>$model->id));
								}
							}
							else
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

		$this->render('update',array(
			'model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel,'articleModel'=>$articleModel,
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
			$model=parent::loadModel($id);
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
	 * It gets the webs through a tag name.
	 */
	public function actionSearchByTag()
	{
		$this->layout="//layouts/column2menu2";
		$dataProvider=null;
	
		// It creates the tags right menu.
		$this->setTags('web/index');
	
		if(isset($_POST['tag']))
		{
			$name=$_POST['tag'];
				
			// The guest users only can view public resources.
			if(Yii::app()->user->isGuest)
			{
				$join='join Resource r on (t.id=r.id) join UserResource ur on (t.id=ur.res and r.privacy=0)' .
						' join TagResource tr on (t.id=tr.res)' .
						' join Tag ta on (ta.id=tr.tag)';
				$criteria=new CDbCriteria();
				$criteria->compare('ta.name',$name,true);
				$criteria->join=$join;
				$dataProvider=new CActiveDataProvider('Web',
						array(
								'criteria'=>$criteria
						));
			}
			// The registered users can view his/her resources and public resources.
			else
			{
				$join='join Resource r on (t.id=r.id) join UserResource ur on (t.id=ur.res)' .
						' join TagResource tr on (t.id=tr.res)' .
						' join Tag ta on (ta.id=tr.tag)';
				$criteria=new CDbCriteria();
				$criteria->compare('r.privacy','0',false);
				$criteria->compare('ur.user',Yii::app()->user->id,false,'OR');
				$criteria->compare('ta.name',$name,true);
				$criteria->join=$join;
				$dataProvider=new CActiveDataProvider('Web',
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
		$this->setTags('web/index');
		
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
		$this->layout='//layouts/column1';
		
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
	 * Import a netscape bookmark format file.
	 */
	public function actionImport()
	{
		$this->layout='//layouts/column1';
		$model=new ImportForm();
		$dataProvider=null;
				
		if(isset($_POST['ImportForm']))
		{
			$model->attributes=$_POST['ImportForm'];
			if($model->validate())
			{
				// It gets the file uploaded.
				$file=Yii::app()->file;
				$file->saveAs($model,'bmFile',Yii::getPathOfAlias('webroot').Yii::app()->params['tmpdir']);
		
				// It gets the array with bookmarks throught CNetscapeBookmarkFormatParser class.
				$parser=Yii::app()->bmparser;
				$parser->loadFile($file->filepath);
				$bmArray=$parser->getBookmarks();
		
				// It prepares and creates the data provider.
				$resArray=array();
				$i=0;
				foreach($bmArray as $bm)
				{
					$resource=new Resource();
					$resource->uri=$bm['url'];
					$resource->name=$bm['name'];
					$resource->description=$bm['desc'];
					$resource->tag=$bm['tags'];
					$resArray[$i++]=$resource;
				}
				
				// It caches the data and it creates the data provider.
				Yii::app()->cache->flush(); // if there are datas, it flushes...
				Yii::app()->cache->set('bmfile',$resArray); // caching contents...
				$dataProvider=new CArrayDataProvider($resArray,array('pagination'=>array('pageSize'=>WebController::PAGESIZE)));
			}
		}
		else
		{
			$resArray=Yii::app()->cache->get('bmfile'); // get caching data...
			if($resArray)
				$dataProvider=new CArrayDataProvider($resArray,array('pagination'=>array('pageSize'=>WebController::PAGESIZE)));
		}
		
		$this->render('import',array('dataProvider'=>$dataProvider,'model'=>$model));
	}
	
	/**
	 * This action create a web throught a resource data.
	 * @throws CException
	 */
	public function actionImportsave()
	{
		if(isset($_POST['Resource']))
		{
			$res=new Resource('web');
			$web=new Web();
			$user=new UserResource();
			
			$res->attributes=$_POST['Resource'];
			$res->tag=$_POST['Resource']['tag'];
			$res->privacy=0;
			$res->created=date('Y-m-d');
			$web->resource=$res;
			$user->user=Yii::app()->user->id; // Who have created this resource?
			
			// Ajax validation...
			$errors = CActiveForm::validate($res);
			if ($errors !== '[]') {
				echo $errors;
				Yii::app()->end();
			}

			// If Ajax validation is ok...
			$trx=$web->getDbConnection()->beginTransaction();
			try
			{
				if($res->save())
				{
					// It saves Tag and TagResource.
					$tags=preg_split ("/[\s]*[,][\s]*/", $res->tag);
					foreach($tags as $t)
					{
						$tm=new Tag();
						$tm->name=strtolower($t);
						$tm->save();
						$trm=new TagResource();
						$trm->res=$res->id;
						$trm->tag=$tm->id;
						$trm->save();
					}
					if($web->save())
					{
						$user->res=$res->id;
						if($user->save())
						{
							// It must change the cache with new datas.
							$page=$_POST['page'];
							$index=$_POST['index'];
							$resArray=Yii::app()->cache->get('bmfile'); // get caching data...
							if($resArray)
							{
								Yii::app()->cache->flush(); // if there are datas, it flushes...
								$resArray[($page-1)*WebController::PAGESIZE+$index]=$res; // update the item changed...
								Yii::app()->cache->set('bmfile',$resArray); // caching contents...
							}
							$trx->commit();
							Yii::app()->end();
						}
					}
				}
				Yii::app()->end();
			}
			catch(CException $e)
			{
				$trx->rollback();
				throw $e;
			}
		}
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
