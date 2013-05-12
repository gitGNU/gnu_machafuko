<?php
$this->breadcrumbs=array(
    Yii::t('bm', 'User')=>array('index'),
    $model->id,
);

$this->menu=array(
    array('label'=>Yii::t('bm', 'Update User'), 'url'=>array('update', 'id'=>$model->id)),
    array('label'=>Yii::t('bm', 'Delete User'), 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>Yii::t('bm', 'Are you sure you want to delete your account?'))),
);
?>

<h1><?php echo Yii::t('bm', 'View User') . ' "' . $model->username . '"' ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
    'data'=>$model,
	'htmlOptions'=>array('class'=>'my-detail-view'),
    'attributes'=>array(
        'username',
        'email',
    ),
));
