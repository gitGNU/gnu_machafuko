<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-comment-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'comment'); ?>
        <?php echo $form->textField($model,'comment'); ?>
        <?php echo $form->error($model,'comment'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'user'); ?>
        <?php echo $form->textField($model,'user'); ?>
        <?php echo $form->error($model,'user'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
