<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'export-form',
        'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>


	<?php echo $form->errorSummary($model); ?>
	<?php echo $form->textFieldRow($model,'nome',array('maxlength'=>255,'class'=>'span5')); ?>
        <?php echo $form->textAreaRow($model,'description',array('rows'=>6, 'cols'=>50,'class'=>'span5')); ?>
        <div class="row">
            <div class="column span">
            <?php echo $form->textAreaRow($model,'query',array('rows'=>6, 'cols'=>50,'class'=>'span5')); ?>
            </div>
            <div class="column span">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                   'label'=>'?',
                   'type'=>'info',
                   'htmlOptions'=>array('data-title'=>'Blocco', 'data-content'=>'Utilizza :: (chiave = ::parametro) davanti al nome del parametro nel valore di una condizione per specificare i valori da prendere come input da parte dell\'utente in fase di esecuzione.', 'rel'=>'popover'),
               )); ?>
           </div>
        </div>
        <div class="row">
            <div class="column span">
            <?php echo $form->textAreaRow($model,'json_params',array('rows'=>6, 'placeholder'=>'{"campi":[{ "parametro": "campo1", "type": "dropDownList", "campo": "Priorita", "tabella": "lov", "chiave": "codice", "valore": "descrizione", "condizioni": "lista = \'priorita_candidato\'" }, {"parametro":"mese","type":"mese","campo":"Mese"},{"parametro":"anno","type":"anno","campo":"Anno"} ]}', 'cols'=>50,'class'=>'span5')); ?>
            </div>
            <div class="column span">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                   'label'=>'?',
                   'type'=>'info',
                   'htmlOptions'=>array('data-title'=>'Blocco', 'data-content'=>'Definire i parametri utilizzabili come filtro: "chiave" = VALUE della SELECT, "valore" è la OPTION stampata; per una lista  di valori utilizzare "dropDownList", per un input utilizzare "varchar"', 'rel'=>'popover'),
               )); ?>
           </div>
        </div>
        <div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'inverse',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'',
			'label'=>'Back',
                        'htmlOptions'=>array('onclick' => "history.go(-1);return false;"),
		)); ?>   
        </div>

<?php $this->endWidget(); ?>
