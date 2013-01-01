<?php
$this->breadcrumbs=array(
    Yii::t('bm', 'Users')=>array('index'),
    Yii::t('bm', 'Create'),
);
?>

<h1><?php echo Yii::t('bm', 'New user account'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
