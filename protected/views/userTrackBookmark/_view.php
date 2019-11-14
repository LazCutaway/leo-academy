<div class="view">

		<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id),array('view','id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('track_id')); ?>:</b>
	<?php echo CHtml::encode($data->track_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('user_id')); ?>:</b>
	<?php echo CHtml::encode($data->user_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('purchase_date')); ?>:</b>
	<?php echo CHtml::encode($data->purchase_date); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('eclusive')); ?>:</b>
	<?php echo CHtml::encode($data->eclusive); ?>
	<br />


</div>