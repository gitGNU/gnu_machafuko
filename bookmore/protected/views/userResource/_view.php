<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('res')); ?>:</b>
    <?php echo CHtml::encode($data->res); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('user')); ?>:</b>
    <?php echo CHtml::encode($data->user); ?>
    <br />

</div>
