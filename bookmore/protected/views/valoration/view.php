<?php
$this->breadcrumbs=array(
	'Valorations'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Valoration', 'url'=>array('index')),
	array('label'=>'Create Valoration', 'url'=>array('create')),
	array('label'=>'Update Valoration', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Valoration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Valoration', 'url'=>array('admin')),
);
?>

<h1>View Valoration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'votes',
		'total',
	),
)); ?>
