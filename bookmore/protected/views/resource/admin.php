<?php
$this->breadcrumbs=array(
    Yii::t('bm','Resources')=>array('index'),
    Yii::t('bm','Manage'),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();

    return false;
});
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('resource-grid', {
        data: $(this).serialize()
    });

    return false;
});
");
?>

<h1><?php echo Yii::t('bm','Manage Resources'); ?></h1>

<p>
<?php echo Yii::t('bm','You may optionally enter a comparison operator'); ?> (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
<?php echo Yii::t('bm','or'); ?> <b>=</b>) <?php echo Yii::t('bm','at the beginning of each of your search values to specify how the comparison should be done'); ?>.
</p>

<?php echo CHtml::link(Yii::t('bm','Advanced Search'),'#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
    'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'resource-grid',
	'htmlOptions'=>array('class'=>'my-grid-view'),
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'id',
        'uri',
        'name',
        'description',
        'created',
        'privacy',
        array(
            'class'=>'CButtonColumn',
        ),
    ),
));
