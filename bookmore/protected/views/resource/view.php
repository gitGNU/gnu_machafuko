<?php
$this->breadcrumbs=array(
    Yii::t('bm','Bookmarks')=>array('index'),
    $model->name,
);

$this->menu=array(
    array('label'=>Yii::t('bm','List Bookmarks'), 'url'=>array('index')),
    array('label'=>Yii::t('bm','Update Bookmark'), 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>Yii::t('bm','Delete Bookmark'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('bm','Are you sure you want to delete this item?'))),
    array('label'=>Yii::t('bm','Manage Bookmark'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm','View Bookmark'); ?> #<?php echo $model->id; ?></h1>

<?php 
$dataView = array(
    'data'=>$model,
    'htmlOptions'=>array('class'=>'my-detail-view'),
    'attributes'=>array(
        array(
            'label'=>Yii::t('bm','Name'),
            'type'=>'raw',
            'value'=>CHtml::link(CHtml::encode($model->name),$model->uri,array('target'=>'_blank')),
        ),
        'description',
        'created',
        array(
            'label'=>Yii::t('bm','Privacy'),
            'value'=>($model->privacy ? Yii::t('bm','Private') : Yii::t('bm','Public')),
        ),
    ),
);
if (isset($model->web))
  $dataView['attributes'][] = 
        array(
            'label'=>Yii::t('bm','Logo'),
            'type'=>'raw',
            'value'=>"<div class='normal-size'>".
                        html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.CHtml::encode($model->web->logo),CHtml::encode($model->name))).
                     "</div>",
        );
$this->widget('zii.widgets.CDetailView', $dataView);
