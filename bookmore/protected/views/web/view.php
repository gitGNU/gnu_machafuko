<?php
$this->breadcrumbs=array(
    'Webs'=>array('index'),
    $model->id,
);

if ($this->isQueued($model->id)) {
    $this->menu=array(
    		array('label'=>Yii::t('bm','Update Web'),'url'=>array('update', 'id'=>$model->id, 'queue'=>true)),
    		array('label'=>Yii::t('bm','Delete Web'),'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
    );
}
else {
    if ($this->isOwner($model->id)) {
        $this->menu=array(
            array('label'=>Yii::t('bm','Create Web'),'url'=>array('create')),
            array('label'=>Yii::t('bm','Update Web'),'url'=>array('update', 'id'=>$model->id)),
            array('label'=>Yii::t('bm','Delete Web'),'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
        );
    }
    else {
        $this->menu=array(
        		array('label'=>Yii::t('bm','Create Web'),'url'=>array('create')));
    }
}
?>

<h1><?php echo Yii::t('bm','View Web'); ?> #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
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
        array(
            'label'=>Yii::t('bm','Logo'),
            'type'=>'raw',
            'value'=>"<div class='normal-size'>".
                        html_entity_decode(CHtml::image(Yii::app()->request->baseUrl.'/'.CHtml::encode($model->logo),CHtml::encode($model->resource->name))).
                     "</div>",
        ),
    ),
));

// If there is WebAccount model it shows the account.
if ($waModel) {
    echo '<h2>'.Yii::t('bm','Account information').'</h2>';
    $this->widget('zii.widgets.CDetailView', array(
            'data'=>$waModel,
            'htmlOptions'=>array('class'=>'my-detail-view'),
            'attributes'=>array(
                    'username',
                    'email',
                    'password',
            ),
    ));
}
