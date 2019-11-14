<?php
$this->breadcrumbs=array(
	'Track Genres'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List TrackGenre','url'=>array('index')),
array('label'=>'Manage TrackGenre','url'=>array('admin')),
);
?>

<h1>Create TrackGenre</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>