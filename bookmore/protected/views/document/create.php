<?php
$this->breadcrumbs=array(
	Yii::t('bm','Documents')=>array('index'),
	Yii::t('bm','Create'),
);

Yii::app()->clientScript->registerScript('isarticle', "
$('#isarticle').change(function(){
	if($('#isarticle:checked').val()) {
		$('#Article_priority').removeAttr('disabled');
	}
	else {
		$('#Article_priority').attr('disabled','disabled');
	}
});
");
?>

<h1><?php echo Yii::t('bm','Create Document'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'resModel'=>$resModel,'articleModel'=>$articleModel)); ?>