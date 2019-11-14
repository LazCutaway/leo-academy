<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'track-form',
	'enableAjaxValidation'=>true,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php #echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

	<?php #echo $form->textFieldRow($model,'owner_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'title',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php echo $form->textFieldRow($model,'is_public',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'publishing_date',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'is_featured',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'price',array('class'=>'span5')); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
