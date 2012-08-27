<div class="grid view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array($data->web ? 'web/view' : 'document/view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uri')); ?>:</b>
	<?php echo CHtml::encode($data->uri); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('privacy')); ?>:</b>
	<?php echo CHtml::encode($data->privacy) ? Yii::t('bm', 'Private') : Yii::t('bm', 'Public'); ?>
	<br />
	
	<!-- A resource can be a web or a document -->
	<?php if($data->web) { ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->web->logo); ?>
	<br />
	<?php } ?>
	<?php if($data->document) { ?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('mimeType')); ?>:</b>
	<?php echo CHtml::encode($data->document->mimeType); ?>
	<br />
	<?php } ?>

</div>