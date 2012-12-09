<?php
$this->breadcrumbs=array(
    'Resource Valorations'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List ResourceValoration', 'url'=>array('index')),
    array('label'=>'Create ResourceValoration', 'url'=>array('create')),
    array('label'=>'Update ResourceValoration', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete ResourceValoration', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage ResourceValoration', 'url'=>array('admin')),
);
?>

<h1>View ResourceValoration #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'res',
        'val',
    ),
));
