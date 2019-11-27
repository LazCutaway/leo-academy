<?php
/* @var $this EmployeeController */
/* @var $data Employee */
?>

<div class="view">

	

	<b><?php echo CHtml::encode($data->getAttributeLabel('identification')); ?>:</b>
	<?php echo CHtml::encode($data->identification); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('surname')); ?>:</b>
	<?php echo CHtml::encode($data->surname); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('name')); ?>:</b>
	<?php echo CHtml::encode($data->name); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_deleted')); ?>:</b>
	<?php echo CHtml::encode($data->is_deleted); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('last_edit_time')); ?>:</b>
	<?php echo CHtml::encode($data->last_edit_time); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('supervisor_email')); ?>:</b>
	<?php echo CHtml::encode($data->supervisor_email); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('employeeType_id')); ?>:</b>
	<?php echo CHtml::encode($data->employeeType_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('source_id')); ?>:</b>
	<?php echo CHtml::encode($data->source_id); ?>
	<br />

	*/ ?>

</div>
