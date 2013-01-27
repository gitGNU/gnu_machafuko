<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'web-form',
    'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

    <p class="note"><?php echo Yii::t('bm','Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('bm','are required'); ?>.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="container">

        <div class="span-9">

            <div class="row">
                <?php echo $form->labelEx($resModel,'uri'); ?>
                <?php echo $form->textField($resModel,'uri',array('size'=>40,'maxlength'=>200)); ?>
                <?php echo $form->error($resModel,'uri'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($resModel,'name'); ?>
                <?php echo $form->textField($resModel,'name',array('size'=>40,'maxlength'=>100)); ?>
                <?php echo $form->error($resModel,'name'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($resModel,'description'); ?>
                <?php echo $form->textArea($resModel,'description',array('size'=>40,'maxlength'=>200, 'cols'=>'40', 'rows'=>'2')); ?>
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

            <div class="row">
                <?php echo $form->labelEx($model,'logo'); ?>
                <?php echo $form->fileField($model,'logo'); ?>
                <?php echo $form->error($model,'logo'); ?>
            </div>

            <?php if (!empty($model->logo)) { ?>
            <div class="row">
                 <?php echo CHtml::image(Yii::app()->request->baseUrl.'/'.$model->logo,'image',array('width'=>200)); ?>
            </div>
            <?php } ?>

        </div><!-- div span-9 -->

        <div class="span-9 last view">

            <p class="note"><?php echo Yii::t('bm','Fill in this formulary if you have an account in this new web page with your account information'); ?>.</p>

            <div class="row">
                <?php echo $form->labelEx($waModel,'username'); ?>
                <?php echo $form->textField($waModel,'username',array('size'=>40,'maxlength'=>100)); ?>
                <?php echo $form->error($waModel,'username'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($waModel,'email'); ?>
                <?php echo $form->textField($waModel,'email',array('size'=>40,'maxlength'=>100)); ?>
                <?php echo $form->error($waModel,'email'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($waModel,'rawPassword'); ?>
                <?php echo $form->passwordField($waModel,'rawPassword',array('size'=>40,'maxlength'=>100)); ?>
                <?php echo $form->error($waModel,'rawPassword'); ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($waModel,'passwordRepeat'); ?>
                <?php echo $form->passwordField($waModel,'passwordRepeat',array('size'=>40,'maxlength'=>100)); ?>
                <?php echo $form->error($waModel,'passwordRepeat'); ?>
            </div>

        </div><!-- div span-9 last -->

        <div class="span-18 last view">

            <div class="row">
                <input type="checkbox" name="isarticle" id="isarticle" <?php if($articleModel->id || $articleModel->isarticle) echo "checked"; ?> />
                <?php echo Yii::t('bm','if it is an article you can queue it to read later. Would you like?'); ?>
            </div>
            
            <div class="row">
                <?php
                    echo $form->checkBox($articleModel, 'readed');
                    echo ' '.Yii::t('bm', 'check it if the article has been readed');
                ?>
            </div>

            <div class="row">
                <?php echo $form->labelEx($articleModel,'priority'); ?>
                <?php
                    echo $form->dropDownList($articleModel,'priority',CHtml::listData($articleModel->priorityobj,'id','name'));
                ?>
                <?php echo $form->error($articleModel,'priority'); ?>
            </div>

        </div><!-- div span-18 last -->

    </div><!-- div container -->

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? Yii::t('bm','Create') : Yii::t('bm','Save')); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
