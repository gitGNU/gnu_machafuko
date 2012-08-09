<?php
$this->breadcrumbs=array(
	'User Comments'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List UserComment', 'url'=>array('index')),
	array('label'=>'Create UserComment', 'url'=>array('create')),
	array('label'=>'View UserComment', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage UserComment', 'url'=>array('admin')),
);
?>

<h1>Update UserComment <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>