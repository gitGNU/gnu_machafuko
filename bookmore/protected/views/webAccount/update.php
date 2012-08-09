<?php
$this->breadcrumbs=array(
	'Web Accounts'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List WebAccount', 'url'=>array('index')),
	array('label'=>'Create WebAccount', 'url'=>array('create')),
	array('label'=>'View WebAccount', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage WebAccount', 'url'=>array('admin')),
);
?>

<h1>Update WebAccount <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>