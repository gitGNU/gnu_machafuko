<?php
$this->breadcrumbs=array(
    Yii::t('bm','Documents')=>array('index'),
    $model->id,
);

if ($this->isOwner($model->id)) {
    $this->menu=array(
        array('label'=>Yii::t('bm','Create Document'), 'url'=>array('create')),
        array('label'=>Yii::t('bm','Update Document'), 'url'=>array('update', 'id'=>$model->id)),
        array('label'=>Yii::t('bm','Delete Document'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('bm', 'Are you sure you want to delete this item?'))),
    );
} else {
    $this->menu=array(
            array('label'=>Yii::t('bm','Create Document'), 'url'=>array('create')));
}
?>

<h1><?php echo Yii::t('bm','View Document'); ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
	'htmlOptions'=>array('class'=>'my-detail-view'),
    'attributes'=>array(
        array(
            'label'=>Yii::t('bm','Name'),
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($model->resource->name),array('download','doc'=>$model->resource->uri,'name'=>$model->resource->name.'.'.$model->extension)),
        ),
        'resource.description',
        'resource.created',
        'mimeType',
    ),
));
