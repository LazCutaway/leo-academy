<?php
$this->breadcrumbs=array(
	'Audit Logs'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List AuditLog','url'=>array('index')),
array('label'=>'Manage AuditLog','url'=>array('admin')),
);
?>

<h1>Create AuditLog</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>