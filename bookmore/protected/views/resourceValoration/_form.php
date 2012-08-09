<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'resource-valoration-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'res'); ?>
		<?php echo $form->textField($model,'res'); ?>
		<?php echo $form->error($model,'res'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'val'); ?>
		<?php echo $form->textField($model,'val'); ?>
		<?php echo $form->error($model,'val'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->