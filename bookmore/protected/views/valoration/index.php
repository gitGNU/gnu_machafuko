<?php
$this->breadcrumbs=array(
	'Valorations',
);

$this->menu=array(
	array('label'=>'Create Valoration', 'url'=>array('create')),
	array('label'=>'Manage Valoration', 'url'=>array('admin')),
);
?>

<h1>Valorations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
