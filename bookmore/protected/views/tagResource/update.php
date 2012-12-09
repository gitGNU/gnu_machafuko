<?php
$this->breadcrumbs=array(
    'Tag Resources'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    'Update',
);

$this->menu=array(
    array('label'=>'List TagResource', 'url'=>array('index')),
    array('label'=>'Create TagResource', 'url'=>array('create')),
    array('label'=>'View TagResource', 'url'=>array('view', 'id'=>$model->id)),
    array('label'=>'Manage TagResource', 'url'=>array('admin')),
);
?>

<h1>Update TagResource <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
