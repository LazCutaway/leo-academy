<?php
$this->breadcrumbs=array(
	'User Track Bookmarks'=>array('index'),
	$model->id,
);

$this->menu=array(
array('label'=>'List UserTrackBookmark','url'=>array('index')),
array('label'=>'Create UserTrackBookmark','url'=>array('create')),
array('label'=>'Update UserTrackBookmark','url'=>array('update','id'=>$model->id)),
array('label'=>'Delete UserTrackBookmark','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
array('label'=>'Manage UserTrackBookmark','url'=>array('admin')),
);
?>

<h1>View UserTrackBookmark #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
'data'=>$model,
'attributes'=>array(
		'id',
		'track_id',
		'user_id',
		'purchase_date',
		'eclusive',
),
)); ?>
