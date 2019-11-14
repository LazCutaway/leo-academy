<?php
$this->breadcrumbs = array(
    'Tracks' => array('index'),
    $model->title,
);

$this->menu = array(
    array('label' => 'List Track', 'url' => array('index')),
    array('label' => 'Create Track', 'url' => array('create')),
    array('label' => 'Update Track', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Track', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Track', 'url' => array('admin')),
);
?>

<h1>View Track #<?php echo $model->id; ?></h1>

<?php
$this->widget('bootstrap.widgets.TbDetailView', array(
    'data' => $model,
    'attributes' => array(
	'id',
	'owner_id',
	'title',
	'description',
	'is_public',
	'publishing_date',
	'is_featured',
	'price',
    ),
));
?>
