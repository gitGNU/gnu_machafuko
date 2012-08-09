<?php
$this->breadcrumbs=array(
	'Tag Resources',
);

$this->menu=array(
	array('label'=>'Create TagResource', 'url'=>array('create')),
	array('label'=>'Manage TagResource', 'url'=>array('admin')),
);
?>

<h1>Tag Resources</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
