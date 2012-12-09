<?php
$this->breadcrumbs=array(
    'User Comments'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List UserComment', 'url'=>array('index')),
    array('label'=>'Manage UserComment', 'url'=>array('admin')),
);
?>

<h1>Create UserComment</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
