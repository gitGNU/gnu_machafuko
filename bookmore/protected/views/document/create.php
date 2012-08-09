<?php
$this->breadcrumbs=array(
	Yii::t('bm','Documents')=>array('index'),
	Yii::t('bm','Create'),
);

$this->menu=array(
	array('label'=>Yii::t('bm','List Document'), 'url'=>array('index')),
	array('label'=>Yii::t('bm','Manage Document'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm','Create Document'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel)); ?>