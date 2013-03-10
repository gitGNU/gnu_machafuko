<div class="grid">

    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/'.
            CHtml::encode($data->logo),CHtml::encode($data->resource->name)),
            array('web/view', 'id'=>$data->id)); ?>
    <br />
    <?php echo CHtml::encode($data->resource->name); ?>

</div>
