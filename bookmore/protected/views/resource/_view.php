<div class="grid">

    <!-- A resource can be a web or a document -->
    <?php if ($data->web) { ?>
    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/'.CHtml::encode($data->web->logo),CHtml::encode($data->name)),
            array('web/view', 'id'=>$data->id),array('align'=>'center')); ?>
    <br />
    <?php echo CHtml::encode($data->name); ?>
    <?php } ?>
    <?php if ($data->document) { ?>
    <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.CHtml::encode(Yii::app()->params['mimeImg'][$data->document->mimeType]),CHtml::encode($data->name)),
            array('document/view', 'id'=>$data->id)); ?>
    <br />
    <?php echo CHtml::encode($data->name); ?>
    <?php } ?>

</div>
