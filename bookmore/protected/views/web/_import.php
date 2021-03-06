<div class="view grid-2 form">

<?php $form=$this->beginWidget('CActiveForm', array(
        'id'=>'web-form-'.$index,
        'enableAjaxValidation'=>true,
        'clientOptions'=>array('validateOnSubmit'=>true),
));
?>

    <?php echo $form->errorSummary($data); ?>

    <input type="hidden" id="index" name="index" value="<?php echo $index; ?>" />
    <input type="hidden" id="page" name="page" value="<?php echo isset($_GET['page'])?$_GET['page']:'1'; ?>" />

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
        echo CHtml::ajaxSubmitButton(
            Yii::t('bm','Save'),
            CHtml::normalizeUrl(array('importsave')),
            array(
                'success'=>"function(html) {
                        if (html.indexOf('{')==0) {
                            jQuery('#web-form-".$index."').ajaxvalidationmessages('show', html, '".$index."');
                        } else {
                            jQuery('#web-form-".$index."').ajaxvalidationmessages('hide');
                            jQuery('#submit-".$index."').attr('disabled','disabled'); // I have added this line to disabled this button when this form will be saved/queued.
                            jQuery('#queue-".$index."').attr('disabled','disabled');  // I have added this line to disabled this button when this form will be saved/queued.
                            jQuery('#error-".$index."').attr('class','flash-success');
                            jQuery('#error-".$index."').text('".Yii::t('bm','The web has been inserted')."');
                        }
                    }",
                'error'=>"function(html,textStatus,errorThrown) {
                        jQuery('#web-form-".$index."').ajaxvalidationmessages('hide');
                        if (errorThrown=='CDbException') {
                            jQuery('#error-".$index."').attr('class','flash-error');
                            jQuery('#error-".$index."').text('".Yii::t('bm','Database exception: does this site?')."');
                        } else
                            alert(html.responseText);
                    }",
            ),
            array('id'=>'submit-'.$index,'name'=>'submit-'.$index,'disabled'=>$data->id?1:0) // I have added this line to change the id and name attribute.
                                                                                             // Although, if $data have id it means that it have been saved.
            );
        ?>
        
        <?php
        echo CHtml::ajaxSubmitButton(
            Yii::t('bm','Queue'),
            CHtml::normalizeUrl(array('importsave?queue=1')),
            array(
                'success'=>"function(html) {
                        if (html.indexOf('{')==0) {
                            jQuery('#web-form-".$index."').ajaxvalidationmessages('show', html, '".$index."');
                        } else {
                            jQuery('#web-form-".$index."').ajaxvalidationmessages('hide');
                            jQuery('#submit-".$index."').attr('disabled','disabled'); // I have added this line to disabled this button when this form will be saved/queued.
                            jQuery('#queue-".$index."').attr('disabled','disabled');  // I have added this line to disabled this button when this form will be saved/queued.
                            jQuery('#error-".$index."').attr('class','flash-success');
                            jQuery('#error-".$index."').text('".Yii::t('bm','The web has been inserted')."');
                        }
                    }",
                'error'=>"function(html,textStatus,errorThrown) {
                        jQuery('#web-form-".$index."').ajaxvalidationmessages('hide');
                        if (errorThrown=='CDbException') {
                            jQuery('#error-".$index."').attr('class','flash-error');
                            jQuery('#error-".$index."').text('".Yii::t('bm','Database exception: does this site?')."');
                        } else
                            alert(html.responseText);
                    }",
            ),
            array('id'=>'queue-'.$index,'name'=>'queue-'.$index,'disabled'=>$data->id?1:0) // I have added this line to change the id and name attribute.
                                                                                             // Although, if $data have id it means that it have been saved.
            );
        ?>
    </div>

<?php $this->endWidget(); ?>

<div id="error-<?php echo $index; ?>" class="<?php echo $data->id?'flash-success':''; ?>">
    <?php echo $data->id?Yii::t('bm','The web has been inserted'):''; ?>
</div>

</div>
