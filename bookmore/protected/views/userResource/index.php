<?php
$this->breadcrumbs=array(
    'User Resources',
);

$this->menu=array(
    array('label'=>'Create UserResource', 'url'=>array('create')),
    array('label'=>'Manage UserResource', 'url'=>array('admin')),
);
?>

<h1>User Resources</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
));
