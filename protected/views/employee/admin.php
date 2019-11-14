<?php
/* @var $this EmployeeController */

$this->breadcrumbs=array(
	'Employee'=>array('/employee'),
	'Admin',
);
?>
<h1>Dipendenti</h1>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
    'id'=>'dipendenti-grid',
    'type' => 'striped bordered condensed',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
    'columns'=>array(
        'name',
        'surname',
        'email',
        'employeeType.description',
//        array(
//            'class'=>'bootstrap.widgets.TbButtonColumn',
//            'buttons' => array(
//                'delete' => array(
//                    'visible' => 'false',
//                ),
//            ),
//        ),
    ),
)); ?>