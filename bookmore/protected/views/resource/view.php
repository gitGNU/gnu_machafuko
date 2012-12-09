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

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
    'attributes'=>array(
        'id',
        'uri',
        'name',
        'description',
        'created',
        'privacy',
        'web.logo',
        'document.mimeType',
    ),
));
