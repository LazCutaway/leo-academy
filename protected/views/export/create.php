<?php
$this->breadcrumbs=array(
	'Gestisci Export'=>array('admin'),
	'Crea un nuovo Export',
);

$this->menu=array(
	array('label'=>'Gestisci Export', 'url'=>array('admin')),
);
?>

<h1>Crea un nuovo Export</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>