<div class="grid view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('uri')); ?>:</b>
	<?php echo CHtml::encode($data->resource->uri); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->resource->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
	<?php echo CHtml::encode($data->resource->description); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('created')); ?>:</b>
	<?php echo CHtml::encode($data->resource->created); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('privacy')); ?>:</b>
	<?php echo CHtml::encode($data->resource->privacy) ? Yii::t('bm', 'Private') : Yii::t('bm', 'Public'); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('logo')); ?>:</b>
	<?php echo CHtml::encode($data->logo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('account')); ?>:</b>
	<?php echo CHtml::encode($data->account); ?>
	<br />

</div>