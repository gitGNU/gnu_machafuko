<?php
$this->breadcrumbs=array(
	Yii::t('bm', 'My How To\'s')=>array('index'),
	Yii::t('bm', 'Create'),
);
?>

<h1><?php echo Yii::t('bm', 'Create HowTo'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'resModel'=>$resModel)); ?>