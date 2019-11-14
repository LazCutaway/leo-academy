<?php
$this->breadcrumbs = array(
    'Tracks' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Track', 'url' => array('index')),
    array('label' => 'Create Track', 'url' => array('create')),
);
?>

<h1>Manage Tracks</h1>

<?php
$this->widget('bootstrap.widgets.TbGridView', array(
    'id' => 'track-grid',
    'type' => 'striped bordered condensed',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
	'id',
	'owner_id',
	'title',
	'description',
	'is_public',
	'publishing_date',	
	'is_featured',
	'price',	 
	array(
	    'class' => 'bootstrap.widgets.TbButtonColumn',
	),
    ),
));
?>
