<?php
$this->breadcrumbs=array(
    'Web Accounts'=>array('index'),
    'Create',
);

$this->menu=array(
    array('label'=>'List WebAccount', 'url'=>array('index')),
    array('label'=>'Manage WebAccount', 'url'=>array('admin')),
);
?>

<h1>Create WebAccount</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model));
