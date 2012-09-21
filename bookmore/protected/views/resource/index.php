<?php
$this->breadcrumbs=array(
	Yii::t('bm', 'Bookmarks'),
);

$this->menu=array(
	array('label'=>Yii::t('bm', 'Create Web Bookmark'), 'url'=>array('web/create')),
	array('label'=>Yii::t('bm', 'Create Document Bookmark'), 'url'=>array('document/create')),
	array('label'=>Yii::t('bm', 'Manage Bookmark'), 'url'=>array('admin')),
);
?>

<h1><?php echo Yii::t('bm', 'Bookmarks'); ?></h1>

<?php 
if($dataProvider!=null)
{
	$this->widget('zii.widgets.CListView', array(
		'dataProvider'=>$dataProvider,
		'itemView'=>'_view',
		'itemsCssClass'=>'grid-container',
	));
}
else
{
	echo Yii::t('bm','No results found').'.';
} 
?>
