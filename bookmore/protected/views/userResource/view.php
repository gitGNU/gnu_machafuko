<?php
$this->breadcrumbs=array(
    'User Resources'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List UserResource', 'url'=>array('index')),
    array('label'=>'Create UserResource', 'url'=>array('create')),
    array('label'=>'Update UserResource', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete UserResource', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage UserResource', 'url'=>array('admin')),
);
?>

<h1>View UserResource #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'res',
        'user',
    ),
));
