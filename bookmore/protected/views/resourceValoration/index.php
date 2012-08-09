<?php
$this->breadcrumbs=array(
	'Resource Valorations',
);

$this->menu=array(
	array('label'=>'Create ResourceValoration', 'url'=>array('create')),
	array('label'=>'Manage ResourceValoration', 'url'=>array('admin')),
);
?>

<h1>Resource Valorations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
