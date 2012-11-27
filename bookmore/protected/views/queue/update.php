<?php
$this->breadcrumbs=array(
	'Queues'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Queue', 'url'=>array('index')),
	array('label'=>'Create Queue', 'url'=>array('create')),
	array('label'=>'View Queue', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Queue', 'url'=>array('admin')),
);
?>

<h1>Update Queue <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>