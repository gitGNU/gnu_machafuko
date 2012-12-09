<div class="grid">

    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.CHtml::encode(Yii::app()->params['mimeImg'][$data->mimeType]),CHtml::encode($data->resource->name)),
            array('document/view', 'id'=>$data->id)); ?>
    <br />
    <?php echo CHtml::encode($data->resource->name); ?>

</div>
