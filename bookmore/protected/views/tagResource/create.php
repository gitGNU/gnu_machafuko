<?php
$this->breadcrumbs=array(
	'Tag Resources'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List TagResource', 'url'=>array('index')),
	array('label'=>'Manage TagResource', 'url'=>array('admin')),
);
?>

<h1>Create TagResource</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>