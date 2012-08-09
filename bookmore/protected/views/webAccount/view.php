<?php
$this->breadcrumbs=array(
	'Web Accounts'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List WebAccount', 'url'=>array('index')),
	array('label'=>'Create WebAccount', 'url'=>array('create')),
	array('label'=>'Update WebAccount', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete WebAccount', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage WebAccount', 'url'=>array('admin')),
);
?>

<h1>View WebAccount #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'username',
		'email',
		'password',
	),
)); ?>
