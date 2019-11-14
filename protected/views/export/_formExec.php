<?php
    $mesi = array("", "gennaio", "febbraio", "marzo", "aprile", "maggio", "giugno", "luglio", "agosto", "settembre", "ottobre", "novembre", "dicembre");
    $anni = array("");
    $anno = 2000;
    while ($anno <= date("Y")) {
        $anni[$anno] = $anno;
        $anno++;
    }
?>

<script type="text/javascript">
    $(function () {
        $("#formGenExport").submit(function () {
            var errori = false;
            $(".inputCondizioni").each(function () {
                if ($(this).val() == "" || $(this).val() == "0" || $(this).val() == 0) {
                    errori = true;
                }
            });

            if (errori) {
                alert("Non sono stati compilati tutti i campi obbligatori");
                return false;
            } else {
                $("#genExport").val('gen');               
            }
        });
    });
</script>

<div class="form-horizontal">

    <form id="formGenExport" action="<?php echo Yii::app()->request->baseUrl; ?>/index.php/export/exec/<?php echo $model->id; ?>" method="post">

        <?php echo CHtml::hiddenField('genExport', ''); ?>
        <?php echo CHtml::hiddenField('intestazione', 'si'); ?>
        <?php echo CHtml::hiddenField('tipo_export', 'excel'); ?>
        
        <div class="control-group">
            <div class="controls">
                <?php
                if ((substr_count($model->query, '::') > 0) && ($model->json_params != "")) {
                    $json = json_decode($model->json_params);
                    $campi = $json->campi;
                    foreach ($campi as $campo) {
                        echo CHtml::label($campo->campo . ' <span class="required">*</span>', $campo->parametro);

                        if ($campo->type == "varchar") {
                            echo CHtml::textField($campo->parametro, '', array('class' => 'inputCondizioni'));
                        } else if ($campo->type == "dropDownList") {
                            $sqlDropDownList = "SELECT " . $campo->chiave . ", " . $campo->valore . " FROM " . $campo->tabella;
                            if ($campo->condizioni != "") {
                                $sqlDropDownList .= " WHERE " . $campo->condizioni;
                            }
                            $listData = CHtml::listData(Yii::app()->db->createCommand($sqlDropDownList)->query(), $campo->chiave, $campo->valore);
                            echo CHtml::dropDownList($campo->parametro, '', $listData, array('class' => 'inputCondizioni', 'prompt' => ''));
                        } else if ($campo->type == "mese") {
                            echo CHtml::dropDownList($campo->parametro, '', $mesi, array('class' => 'inputCondizioni'));
                        } else if ($campo->type == "anno") {
                            echo CHtml::dropDownList($campo->parametro, '', $anni, array('class' => 'inputCondizioni'));
                        }
                    }
                }
                ?>
            </div>
        </div>

        <div class="control-group">
            <div class="controls row buttons">
                
                <?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'warning',
			'label'=>'Esegui',
		)); ?>
            </div>
        </div>
    </form>
</div>