<?php
$this->breadcrumbs=array(
	'User Track Bookmarks'=>array('index'),
	'Create',
);

$this->menu=array(
array('label'=>'List UserTrackBookmark','url'=>array('index')),
array('label'=>'Manage UserTrackBookmark','url'=>array('admin')),
);
?>

<h1>Create UserTrackBookmark</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>