<?php
/* @var $this LocationController */
/* @var $data Location */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nome')); ?>:</b>
	<?php echo CHtml::encode($data->nome); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('indirizzo')); ?>:</b>
	<?php echo CHtml::encode($data->indirizzo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cap')); ?>:</b>
	<?php echo CHtml::encode($data->cap); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('citta')); ?>:</b>
	<?php echo CHtml::encode($data->citta); ?>
	<br />


</div>