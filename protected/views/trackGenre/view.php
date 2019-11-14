<?php
$this->breadcrumbs=array(
	'Track Genres'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List TrackGenre','url'=>array('index')),
array('label'=>'Create TrackGenre','url'=>array('create')),
array('label'=>'Update TrackGenre','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete TrackGenre','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage TrackGenre','url'=>array('admin')),
);
?>

<h1>View TrackGenre #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'track_id',
		'genre_id',
),
)); ?>
