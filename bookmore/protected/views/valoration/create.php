<?php
$this->breadcrumbs=array(
    'Valorations'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List Valoration', 'url'=>array('index')),
    array('label'=>'Manage Valoration', 'url'=>array('admin')),
);
?>

<h1>Create Valoration</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
