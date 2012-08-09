<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'document-form',
	'enableAjaxValidation'=>false,
	'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<p class="note"><?php echo Yii::t('bm','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('bm','are required') ?>.</p>

	<?php echo $form->errorSummary($model); ?>
	
	<div class="row">
		<?php echo $form->labelEx($model,'mimeType'); ?>
		<?php echo $form->fileField($model,'mimeType'); ?>
		<?php echo $form->error($model,'mimeType'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($resModel,'name'); ?>
		<?php echo $form->textField($resModel,'name',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($resModel,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($resModel,'description'); ?>
		<?php echo $form->textArea($resModel,'description',array('size'=>60,'maxlength'=>200, 'cols'=>'50', 'rows'=>'2')); ?>
		<?php echo $form->error($resModel,'description'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($resModel,'tag'); ?>
		<?php echo $form->textField($resModel,'tag',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($resModel,'tag'); ?>
	</div>

	<div class="row">
		<?php 
		$selected='1';
		if($resModel->privacy=='0')
			$selected='0';
		?>
		<?php echo $form->labelEx($resModel,'privacy'); ?>
		<?php echo $form->dropDownList($resModel,'privacy',array('0'=>Yii::t('bm','Public'),'1'=>Yii::t('bm','Private')),
				array('prompt'=>'(Select...)', 'options'=>array($selected=>array('selected'=>'selected')))); ?>
		<?php echo $form->error($resModel,'privacy'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('bm','Create') : Yii::t('bm','Save')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->