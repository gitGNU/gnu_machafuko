<?php
$this->breadcrumbs=array(
	Yii::t('bm', 'My How To\'s')=>array('index'),
	Yii::t('bm', 'Create'),
);

Yii::app()->clientScript->registerScript('body', "
$('#MyHowTo_body').ready(function(){
	var j = jQuery.noConflict();
        j(function() {
            j('#MyHowTo_body').htmlarea({
                toolbar: ['html', '|',
                        'forecolor',  
                        '|', 'bold', 'italic', 'underline', '|', 'p', 'h1', 'h2', 'h3', '|', 'link', 'unlink'] // Overrides/Specifies the Toolbar buttons to show
                });
        });
});
");
?>

<h1><?php echo Yii::t('bm', 'Create HowTo'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'resModel'=>$resModel)); ?>