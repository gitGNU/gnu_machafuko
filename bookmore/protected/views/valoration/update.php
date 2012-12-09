<?php
$this->breadcrumbs=array(
    'Valorations'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

$this->menu=array(
    array('label'=>'List Valoration', 'url'=>array('index')),
    array('label'=>'Create Valoration', 'url'=>array('create')),
    array('label'=>'View Valoration', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Manage Valoration', 'url'=>array('admin')),
);
?>

<h1>Update Valoration <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
