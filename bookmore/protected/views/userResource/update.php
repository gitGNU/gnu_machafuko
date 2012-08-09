<?php
$this->breadcrumbs=array(
	'User Resources'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserResource', 'url'=>array('index')),
	array('label'=>'Create UserResource', 'url'=>array('create')),
	array('label'=>'View UserResource', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserResource', 'url'=>array('admin')),
);
?>

<h1>Update UserResource <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>