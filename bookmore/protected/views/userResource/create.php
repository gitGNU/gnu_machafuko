<?php
$this->breadcrumbs=array(
    'User Resources'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List UserResource', 'url'=>array('index')),
    array('label'=>'Manage UserResource', 'url'=>array('admin')),
);
?>

<h1>Create UserResource</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
