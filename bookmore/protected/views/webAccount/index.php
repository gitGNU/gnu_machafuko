<?php
$this->breadcrumbs=array(
	'Web Accounts',
);

$this->menu=array(
	array('label'=>'Create WebAccount', 'url'=>array('create')),
	array('label'=>'Manage WebAccount', 'url'=>array('admin')),
);
?>

<h1>Web Accounts</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
