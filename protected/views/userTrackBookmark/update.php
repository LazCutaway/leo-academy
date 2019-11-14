<?php
$this->breadcrumbs=array(
	'User Track Bookmarks'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List UserTrackBookmark','url'=>array('index')),
	array('label'=>'Create UserTrackBookmark','url'=>array('create')),
	array('label'=>'View UserTrackBookmark','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UserTrackBookmark','url'=>array('admin')),
	);
	?>

	<h1>Update UserTrackBookmark <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>