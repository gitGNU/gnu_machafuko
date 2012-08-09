<?php
$this->breadcrumbs=array(
	'User Comments'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List UserComment', 'url'=>array('index')),
	array('label'=>'Create UserComment', 'url'=>array('create')),
	array('label'=>'Update UserComment', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete UserComment', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage UserComment', 'url'=>array('admin')),
);
?>

<h1>View UserComment #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'comment',
		'user',
	),
)); ?>
