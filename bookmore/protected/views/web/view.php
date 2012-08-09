<?php
$this->breadcrumbs=array(
	'Webs'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('bm','List Web'), 'url'=>array('index')),
	array('label'=>Yii::t('bm','Create Web'), 'url'=>array('create')),
	array('label'=>Yii::t('bm','Update Web'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('bm','Delete Web'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('bm','Manage Web'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm','View Web'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'resource.uri',
		'resource.name',
		'resource.description',
		'resource.created',
		'resource.privacy',
		'logo',
		'account',
	),
)); ?>
