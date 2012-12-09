<?php
$this->breadcrumbs=array(
    'Tag Resources'=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>'List TagResource', 'url'=>array('index')),
    array('label'=>'Create TagResource', 'url'=>array('create')),
    array('label'=>'Update TagResource', 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>'Delete TagResource', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    array('label'=>'Manage TagResource', 'url'=>array('admin')),
);
?>

<h1>View TagResource #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'res',
        'tag',
    ),
));
