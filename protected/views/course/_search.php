<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

		<?php echo $form->textFieldRow($model,'id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'protocol',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

		<?php echo $form->datepickerRow($model,'date',array('options'=>array(),'htmlOptions'=>array('class'=>'span5')),array('prepend'=>'<i class="icon-calendar"></i>','append'=>'Click on Month/Year at top to select a different year or type in (mm/dd/yyyy).')); ?>

		<?php echo $form->textFieldRow($model,'slot',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'last_edit_time',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'source_id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'courseType_id',array('class'=>'span5')); ?>

		<?php echo $form->textFieldRow($model,'teacher_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType' => 'submit',
			'type'=>'primary',
			'label'=>'Search',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
