<?php
$this->breadcrumbs=array(
    'Resource Valorations'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List ResourceValoration', 'url'=>array('index')),
    array('label'=>'Manage ResourceValoration', 'url'=>array('admin')),
);
?>

<h1>Create ResourceValoration</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
