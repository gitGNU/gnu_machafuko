<?php
$this->breadcrumbs=array(
	Yii::t('bm','Documents')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('bm','List Document'), 'url'=>array('index')),
	array('label'=>Yii::t('bm','Create Document'), 'url'=>array('create')),
	array('label'=>Yii::t('bm','Update Document'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('bm','Delete Document'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>Yii::t('bm','Manage Document'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm','View Document'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array(
			'label'=>Yii::t('bm','Name'),
			'type'=>'raw',
			'value'=>CHtml::link(CHtml::encode($model->resource->name),$model->resource->uri,array('target'=>'_blank')),
		),
		'resource.description',
		'resource.created',
		'mimeType',
	),
)); ?>