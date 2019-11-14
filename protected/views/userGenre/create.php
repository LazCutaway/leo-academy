<?php
$this->breadcrumbs=array(
	'User Genres'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List UserGenre','url'=>array('index')),
array('label'=>'Manage UserGenre','url'=>array('admin')),
);
?>

<h1>Create UserGenre</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>