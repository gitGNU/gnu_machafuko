<?php
$this->breadcrumbs=array(
	'Webs'=>array('index'),
	Yii::t('bm', 'Create'),
);

$this->menu=array(
	array('label'=>Yii::t('bm','List Web'), 'url'=>array('index')),
	array('label'=>Yii::t('bm','Manage Web'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm', 'Create Web Bookmark'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel)); ?>