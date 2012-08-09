<?php
$this->breadcrumbs=array(
	Yii::t('bm','Documents'),
);

$this->menu=array(
	array('label'=>Yii::t('bm','Create Document'), 'url'=>array('create')),
	array('label'=>Yii::t('bm','Manage Document'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm','Documents'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
