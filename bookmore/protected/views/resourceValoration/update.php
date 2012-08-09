<?php
$this->breadcrumbs=array(
	'Resource Valorations'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ResourceValoration', 'url'=>array('index')),
	array('label'=>'Create ResourceValoration', 'url'=>array('create')),
	array('label'=>'View ResourceValoration', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ResourceValoration', 'url'=>array('admin')),
);
?>

<h1>Update ResourceValoration <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>