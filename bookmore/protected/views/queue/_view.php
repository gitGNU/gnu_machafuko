<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('res')); ?>:</b>
    <?php echo CHtml::encode($data->res); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('priority')); ?>:</b>
    <?php echo CHtml::encode($data->priority); ?>
    <br />

</div>
