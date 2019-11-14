<?php
$this->breadcrumbs=array(
	'Attendances'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List Attendance','url'=>array('index')),
array('label'=>'Create Attendance','url'=>array('create')),
array('label'=>'Update Attendance','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete Attendance','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage Attendance','url'=>array('admin')),
);
?>

<h1>View Attendance #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'course_id',
		'employee_id',
),
)); ?>
