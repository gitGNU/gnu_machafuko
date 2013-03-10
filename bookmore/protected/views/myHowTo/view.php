<?php
$this->breadcrumbs=array(
	Yii::t('bm', 'My How To\'s')=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>Yii::t('bm', 'Create MyHowTo'), 'url'=>array('create')),
	array('label'=>Yii::t('bm', 'Update MyHowTo'), 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>Yii::t('bm', 'Delete MyHowTo'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<h1><?php echo Yii::t('bm', 'View HowTo') ?> #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'my-detail-view'),
	'attributes'=>array(
        array(
        		'label'=>Yii::t('bm','Name'),
        		'type'=>'raw',
        		'value'=>CHtml::link(CHtml::encode($model->resource->name),$model->resource->uri,array('target'=>'_blank')),
        ),
        'resource.description',
        'resource.created',
        array(
        		'label'=>Yii::t('bm','Privacy'),
        		'value'=>($model->resource->privacy ? Yii::t('bm','Private') : Yii::t('bm','Public')),
        ),
		//'body',
	),
)); ?>

<p>
<?php echo $model->body; ?>
</p>