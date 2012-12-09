<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'resource-form',
    'enableClientValidation'=>true,
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'uri'); ?>
        <?php echo $form->textField($model,'uri',array('size'=>60,'maxlength'=>200)); ?>
        <?php echo $form->error($model,'uri'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($model,'name'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model,'description',array('size'=>60,'maxlength'=>200, 'cols'=>'50', 'rows'=>'2')); ?>
        <?php echo $form->error($model,'description'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'created'); ?>
        <?php echo $form->textField($model,'created'); ?>
        <?php echo $form->error($model,'created'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'privacy'); ?>
        <?php echo $form->dropDownList($model,'privacy',array('0'=>'Public','1'=>'Private'),
                array('prompt'=>'(Select...)', 'options'=>array('1'=>array('selected'=>'selected')))); ?>
        <?php echo $form->error($model,'privacy'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
