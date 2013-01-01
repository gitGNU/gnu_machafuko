<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'user-form',
    'enableAjaxValidation'=>false,
)); ?>

    <p class="note"><?php echo Yii::t('bm', 'Fields with') ?> <span class="required">*</span> <?php echo Yii::t('bm', 'are required') ?>.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model,'username'); ?>
        <?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'email'); ?>
        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'email'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'emailRepeat'); ?>
        <?php echo $form->textField($model,'emailRepeat',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'emailRepeat'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'rawPassword'); ?>
        <?php echo $form->passwordField($model,'rawPassword',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'rawPassword'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model,'passwordRepeat'); ?>
        <?php echo $form->passwordField($model,'passwordRepeat',array('size'=>60,'maxlength'=>128)); ?>
        <?php echo $form->error($model,'passwordRepeat'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
