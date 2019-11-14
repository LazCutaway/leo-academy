<?php
$this->breadcrumbs=array(
	'User Genres'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List UserGenre','url'=>array('index')),
array('label'=>'Create UserGenre','url'=>array('create')),
array('label'=>'Update UserGenre','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete UserGenre','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage UserGenre','url'=>array('admin')),
);
?>

<h1>View UserGenre #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'user_id',
		'genre_id',
),
)); ?>
