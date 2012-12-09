<?php
$this->breadcrumbs=array(
    'Queues'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List Queue', 'url'=>array('index')),
    array('label'=>'Create Queue', 'url'=>array('create')),
    array('label'=>'Update Queue', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete Queue', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage Queue', 'url'=>array('admin')),
);
?>

<h1>View Queue #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'res',
        'priority',
    ),
));
