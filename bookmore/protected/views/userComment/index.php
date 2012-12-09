<?php
$this->breadcrumbs=array(
    'User Comments',
);

$this->menu=array(
    array('label'=>'Create UserComment', 'url'=>array('create')),
    array('label'=>'Manage UserComment', 'url'=>array('admin')),
);
?>

<h1>User Comments</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'dataProvider'=>$dataProvider,
    'itemView'=>'_view',
));
