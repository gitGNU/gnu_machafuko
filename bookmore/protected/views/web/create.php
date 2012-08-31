<?php
$this->breadcrumbs=array(
	'Webs'=>array('index'),
	Yii::t('bm', 'Create'),
);
?>

<h1><?php echo Yii::t('bm', 'Create Web Bookmark'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel)); ?>