<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'my-how-to-form',
	'enableAjaxValidation'=>false,
)); ?>

    <p class="note"><?php echo Yii::t('bm','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('bm','are required') ?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
        <?php echo $form->labelEx($resModel,'name'); ?>
        <?php echo $form->textField($resModel,'name',array('size'=>60,'maxlength'=>100)); ?>
        <?php echo $form->error($resModel,'name'); ?>
        <?php echo $form->error($resModel,'uri'); ?> <!-- The how to name is the URI too. Because URI is not int the form we have to write here this -->
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
	    Yii::import('ext.krichtexteditor.KRichTextEditor');
	    
	    echo $form->labelEx($model,'body');
	    $this->widget('KRichTextEditor', array(
	    		'model' => $model,
	    		'value' => $model->isNewRecord ? '' : $model->body,
	    		'attribute' => 'body',
	    		'options' => array(
	    				'theme_advanced_resizing' => 'true',
	    				'theme_advanced_statusbar_location' => 'bottom',
	    		),
	    ));
        echo $form->error($model,'body');
	    ?>
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
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->