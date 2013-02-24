<?php
$this->breadcrumbs=array(
	Yii::t('bm', 'My How Tos')=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	Yii::t('bm', 'Update'),
);
?>

<h1><?php echo Yii::t('bm', 'Update MyHowTo').' '.$model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'resModel'=>$resModel)); ?>