<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
)); ?>

    <div class="row">
        <?php echo $form->label($model,'id'); ?>
        <?php echo $form->textField($model,'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'uri'); ?>
        <?php echo $form->textField($model,'uri',array('size'=>60,'maxlength'=>200)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'name'); ?>
        <?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>100)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'description'); ?>
        <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>200)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'created'); ?>
        <?php echo $form->textField($model,'created'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model,'privacy'); ?>
        <?php echo $form->textField($model,'privacy'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->
