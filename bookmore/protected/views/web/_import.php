<div class="view grid-2 form">

<?php $form=$this->beginWidget('CActiveForm', array(
		'id'=>'web-form-'.$index,
		'enableAjaxValidation'=>true,
		'clientOptions'=>array('validateOnSubmit'=>true),
		//'action'=>'/machafuko/bookmore/index.php/web/importsave',
));
?>
	
	<?php echo $form->errorSummary($data); ?>
	
	<div class="row">
		<?php echo $form->labelEx($data,'uri'); ?>
		<?php echo $form->textField($data,'uri',array('size'=>40,'maxlength'=>200)); ?>
		<?php echo $form->error($data,'uri',array('id'=>'Resource_uri_em_'.$index)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($data,'name'); ?>
		<?php echo $form->textField($data,'name',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($data,'name',array('id'=>'Resource_name_em_'.$index)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($data,'description'); ?>
		<?php echo $form->textArea($data,'description',array('size'=>40,'maxlength'=>200, 'cols'=>'40', 'rows'=>'2')); ?>
		<?php echo $form->error($data,'description',array('id'=>'Resource_description_em_'.$index)); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($data,'tag'); ?>
		<?php echo $form->textField($data,'tag',array('size'=>40,'maxlength'=>100)); ?>
		<?php echo $form->error($data,'tag',array('id'=>'Resource_tag_em_'.$index)); ?>
	</div>
	
	<div class="row buttons">
		<?php 
		//echo CHtml::submitButton(Yii::t('bm','Save')); 
		echo CHtml::ajaxSubmitButton(
			Yii::t('bm','Save'),
			CHtml::normalizeUrl(array('importsave')),
			array(
				//'update'=>'#ajax-'.$index,
				'success'=>"function(html) {
						if (html.indexOf('{')==0) {
							jQuery('#web-form-".$index."').ajaxvalidationmessages('show', html, '".$index."');
						}
						else {
							jQuery('#web-form-".$index."').ajaxvalidationmessages('hide');
						}
					}",
				'error'=>"function(html) {
						jQuery('#web-form-".$index."').ajaxvalidationmessages('hide');
					}",
			)
			);
		?>
	</div>

<?php $this->endWidget(); ?>

<!-- <div class="" id="ajax-<?php echo $index; ?>"></div> -->

</div>