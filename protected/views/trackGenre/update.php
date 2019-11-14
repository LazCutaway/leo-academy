<?php
$this->breadcrumbs=array(
	'Track Genres'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List TrackGenre','url'=>array('index')),
	array('label'=>'Create TrackGenre','url'=>array('create')),
	array('label'=>'View TrackGenre','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage TrackGenre','url'=>array('admin')),
	);
	?>

	<h1>Update TrackGenre <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>