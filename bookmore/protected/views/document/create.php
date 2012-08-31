<?php
$this->breadcrumbs=array(
	Yii::t('bm','Documents')=>array('index'),
	Yii::t('bm','Create'),
);
?>

<h1><?php echo Yii::t('bm','Create Document'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel)); ?>