<div class="view grid-2 form">

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'resource-form',
		'enableAjaxValidation'=>false,
		//'action'=>'/machafuko/bookmore/index.php/web/importsave',
));
?>
	
	<div class="row">
		<?php echo $form->labelEx($data,'uri'); ?>
		<?php echo $form->textField($data,'uri',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($data,'uri'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($data,'name'); ?>
		<?php echo $form->textField($data,'name',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($data,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($data,'description'); ?>
		<?php echo $form->textArea($data,'description',array('size'=>40,'maxlength'=>200, 'cols'=>'40', 'rows'=>'2')); ?>
		<?php echo $form->error($data,'description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($data,'tag'); ?>
		<?php echo $form->textField($data,'tag',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($data,'tag'); ?>
	</div>
	
	<div class="row buttons">
		<?php 
		//echo CHtml::submitButton(Yii::t('bm','Save')); 
		echo CHtml::ajaxSubmitButton(Yii::t('bm','Save'),CHtml::normalizeUrl(array('importsave')));
		?>
	</div>

<?php $this->endWidget(); ?>

</div>