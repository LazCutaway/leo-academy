<?php
$this->breadcrumbs=array(
	'Gestisci Export',
);

$this->menu=array(
	array('label'=>'Crea un nuovo Export', 'url'=>array('create')),
);
?>

<h1>Gestisci Export</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'export-grid',
        'type' => 'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nome',
		'description',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
                    'buttons' => array(
                        'delete' => array(
                            'visible' => 'false',
                        ),
                    ),
		),
	),
)); ?>
