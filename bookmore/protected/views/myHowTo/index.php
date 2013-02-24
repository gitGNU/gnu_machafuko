<?php
$this->breadcrumbs=array(
	Yii::t('bm', 'My How To\'s'),
);

$this->menu=array(
	array('label'=>Yii::t('bm', 'Create MyHowTo'), 'url'=>array('create')),
	array('label'=>Yii::t('bm', 'Manage MyHowTo'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm', 'My How To\'s'); ?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
