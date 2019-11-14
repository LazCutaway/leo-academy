<?php
$this->breadcrumbs=array(
	'Audit Logs'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List AuditLog','url'=>array('index')),
array('label'=>'Create AuditLog','url'=>array('create')),
array('label'=>'Update AuditLog','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete AuditLog','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage AuditLog','url'=>array('admin')),
);
?>

<h1>View AuditLog #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'user_id',
		'track_id',
),
)); ?>
