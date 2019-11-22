<?php
/* @var $this LocationController */
/* @var $model Location */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'location-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nome'); ?>
		<?php echo $form->textField($model,'nome',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nome'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'indirizzo'); ?>
		<?php echo $form->textField($model,'indirizzo',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'indirizzo'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cap'); ?>
		<?php echo $form->textField($model,'cap',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'cap'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'citta'); ?>
		<?php echo $form->textField($model,'citta',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'citta'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->