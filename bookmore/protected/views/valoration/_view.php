<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('votes')); ?>:</b>
    <?php echo CHtml::encode($data->votes); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('total')); ?>:</b>
    <?php echo CHtml::encode($data->total); ?>
    <br />

</div>
