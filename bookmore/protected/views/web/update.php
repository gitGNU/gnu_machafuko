<?php
$this->breadcrumbs=array(
	'Webs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('bm','Update'),
);
?>

<h1><?php echo Yii::t('bm','Update Web').' '.$model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel)); ?>