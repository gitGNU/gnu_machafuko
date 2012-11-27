<?php
$this->breadcrumbs=array(
	'Queues'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Queue', 'url'=>array('index')),
	array('label'=>'Manage Queue', 'url'=>array('admin')),
);
?>

<h1>Create Queue</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>