<?php $this->beginContent('//layouts/main'); ?>
<div class="span-19">
    <div id="content">
        <?php echo $content; ?>
    </div><!-- content -->
</div>
<div class="span-5 last">
    <div id="sidebar">
    	<?php
        if (!Yii::app()->user->isGuest) {
            $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>Yii::t('bm','Operations'),
            ));
            $this->widget('zii.widgets.CMenu', array(
                'items'=>$this->menu,
                'htmlOptions'=>array('class'=>'operations'),
            ));
            $this->endWidget();
        }

        $this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>Yii::t('bm','Tags'),
        ));
    	?>
        <div class="form">
	        <?php $form=$this->beginWidget('CActiveForm', array(
	                'id'=>'tagsearch-form',
	                'enableAjaxValidation'=>false,
	                'action'=>'searchbytag',
	                )); ?>
	                    <div class="row">
	                        <input type="text" id="tag" name="tag" />
	                    </div>
	        <?php $this->endWidget(); ?>
        </div><!-- form -->
    	<?php
        $this->widget('zii.widgets.CMenu', array(
            'items'=>$this->tags,
            'htmlOptions'=>array('class'=>'operations'),
        ));
        $this->endWidget();
    	?>
    </div><!-- sidebar -->
</div>
<?php $this->endContent();
