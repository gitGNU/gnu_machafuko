<?php
$this->breadcrumbs=array(
	'Queues',
);

$this->menu=array(
	array('label'=>'Create Queue', 'url'=>array('create')),
	array('label'=>'Manage Queue', 'url'=>array('admin')),
);
?>

<h1>Queues</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
