<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'course-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="help-block">Fields with <span class="required">*</span> are required.</p>

<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model,'protocol',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'name',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'date',array('class'=>'span5','maxlength'=>45)); ?>

	<?php echo $form->textFieldRow($model,'slot',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'source_id',array('class'=>'span5')); ?>

	<?php echo $form->textFieldRow($model,'courseType_id',array('class'=>'span5')); ?>
        
	<?php echo $form->textFieldRow($model,'teacher_id',array('class'=>'span5')); ?>
	<?php

 	$sedi =	Location::model()->findAll();
	$elenco_sedi = [];
	for($i = 0;$i < count($sedi); $i++) {
		$nome_sede = $sedi[$i]->nome;
		$id_sede = $sedi[$i]->id;
		$elenco_sedi[$id_sede] = $nome_sede;
	//	array_push($elenco_sedi, array($id_sede => $nome_sede));

	}

	// var_dump($sedi).die();

	?>
	<?php echo $form->dropDownList($model,'location_id',$elenco_sedi,array('class'=>'span5')); ?>


        <?php 
                $sedi = Location::model()->findAll();
                
                $elenco_sedi=[];
                for($i = 0; $i < count($sedi); $i++){
                    
                    $nome_sede = $sedi[$i]-> nome;
                    $id_sede = $sedi[$i]-> id;
                    $elenco_sedi[$id_sede] = $nome_sede;
                    
                    //array_push($elenco_sedi, array($id_sede => $nome_sede));
                    
                    //var_dump($elenco_sedi).die();
                   
                   //$elenco_sedi = array ($id_sede => $nome_sede);
                           
                }
                //var_dump($elenco_sedi).die();
        
        
            $sedi_list =array(
            "1" => "sede1",
            "2" => "sede2", 
            "3" => "sede3" );?>

        <?php echo $form->dropDownList($model,'location_id',$elenco_sedi,array('class'=>'span5'));

        //
 ?>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
</div>

<?php $this->endWidget(); ?>
