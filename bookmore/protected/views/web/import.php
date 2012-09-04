<?php
$this->breadcrumbs=array(
		'Webs'=>array('index'),
		Yii::t('bm','Import'),
);
?>

<h1><?php echo Yii::t('bm','Import'); ?></h1>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'import-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'bmFile'); ?>
		<?php echo $form->fileField($model,'bmFile'); ?>
		<?php echo $form->error($model,'bmFile'); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('bm','Load')); ?>
	</div>
	
<?php $this->endWidget(); ?>

</div>

<?php
if(!empty($dataProvider))
{
	echo '<h2>'.Yii::t('bm','Bookmarks').'</h2>';
	
	$this->widget('zii.widgets.CListView', array(
			'dataProvider'=>$dataProvider,
			'itemView'=>'_import',
			'itemsCssClass'=>'grid-container',
	));
}
?>