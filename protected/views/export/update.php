<?php
$this->breadcrumbs=array(
	'Gestisci Export'=>array('admin'),
	$model->nome=>array('view','id'=>$model->id),
	'Modifica',
);

$this->menu=array(
	array('label'=>'Gestisci Export', 'url'=>array('admin')),
	array('label'=>'Torna a Export', 'url'=>array('view', 'id'=>$model->id)),
);
?> 

<h1>Modifica Export <?php echo $model->nome; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>