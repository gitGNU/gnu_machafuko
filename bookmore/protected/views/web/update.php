<?php
$this->breadcrumbs=array(
	'Webs'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Web', 'url'=>array('index')),
	array('label'=>'Create Web', 'url'=>array('create')),
	array('label'=>'View Web', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Web', 'url'=>array('admin')),
);
?>

<h1>Update Web <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel,'waModel'=>$waModel)); ?>