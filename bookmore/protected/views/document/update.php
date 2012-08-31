<?php
$this->breadcrumbs=array(
	'Documents'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('bm','Update'),
);
?>

<h1><?php echo Yii::t('bm','Update Document').' '.$model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel)); ?>