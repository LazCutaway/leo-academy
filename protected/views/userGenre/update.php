<?php
$this->breadcrumbs=array(
	'User Genres'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List UserGenre','url'=>array('index')),
	array('label'=>'Create UserGenre','url'=>array('create')),
	array('label'=>'View UserGenre','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage UserGenre','url'=>array('admin')),
	);
	?>

	<h1>Update UserGenre <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>