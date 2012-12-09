<?php
$this->breadcrumbs=array(
    Yii::t('bm','Documents'),
);

$this->menu=array(
    array('label'=>Yii::t('bm','Create Document'), 'url'=>array('create')),
    array('label'=>Yii::t('bm','Manage Document'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm','Documents'); ?></h1>

<?php
if ($dataProvider!=null) {
    $this->widget('zii.widgets.CListView', array(
        'dataProvider'=>$dataProvider,
        'itemView'=>'_view',
        'itemsCssClass'=>'grid-container',
    ));
} else {
    echo Yii::t('bm','No results found').'.';
}
