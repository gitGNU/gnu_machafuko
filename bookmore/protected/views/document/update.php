<?php
$this->breadcrumbs=array(
    'Documents'=>array('index'),
    $model->id=>array('view','id'=>$model->id),
    Yii::t('bm','Update'),
);

Yii::app()->clientScript->registerScript('isarticle', "
$('#isarticle').ready(function(){
    if ($('#isarticle:checked').val()) {
        $('#Article_priority').removeAttr('disabled');
    } else {
        $('#Article_priority').attr('disabled','disabled');
    }
});
$('#isarticle').change(function(){
    if ($('#isarticle:checked').val()) {
        $('#Article_priority').removeAttr('disabled');
    } else {
        $('#Article_priority').attr('disabled','disabled');
    }
});
");
?>

<h1><?php echo Yii::t('bm','Update Document').' '.$model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel,'articleModel'=>$articleModel));
