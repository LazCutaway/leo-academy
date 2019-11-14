<?php
$this->breadcrumbs=array(
	'Genres',
);

$this->menu=array(
array('label'=>'Create Genre','url'=>array('create')),
array('label'=>'Manage Genre','url'=>array('admin')),
);
?>

<h1>Genres</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
'dataProvider'=>$dataProvider,
'itemView'=>'_view',
)); ?>
