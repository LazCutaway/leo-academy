<?php
    $this->breadcrumbs=array(
            'Export'=>array('admin'),
            $model->nome,
    );

$this->menu=array(
	array('label'=>'Gestisci Export', 'url'=>array('admin')),
	array('label'=>'Modifica Export', 'url'=>array('update', 'id'=>$model->id)))
	//array('label'=>'Esegui Export', 'type'=>'warning', 'url'=>array('exec', 'id'=>$model->id)));
?>

<h1><?php echo $model->nome; ?></h1>

<?php 
    $this->widget('bootstrap.widgets.TbDetailView', array(
        'type'=>'bordered condensed',
        'data'=>$model,
        'attributes'=>array(
                'nome',
                'description',
                //'query',
                //'json_params',
        ),
    )); 
?>

<?php echo $this->renderPartial('_formExec', array('model'=>$model)); ?>