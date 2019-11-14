<?php

class ExportController extends SBaseController {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
	$this->render('view', array(
	    'model' => $this->loadModel($id),
	));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
	$model = new Export;

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Export'])) {
	    $model->attributes = $_POST['Export'];
	    if ($model->save())
		$this->redirect(array('view', 'id' => $model->id));
	}

	$this->render('create', array(
	    'model' => $model,
	));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
	$model = $this->loadModel($id);

	// Uncomment the following line if AJAX validation is needed
	// $this->performAjaxValidation($model);

	if (isset($_POST['Export'])) {
	    $model->attributes = $_POST['Export'];
	    if ($model->save())
		$this->redirect(array('view', 'id' => $model->id));
	}

	$this->render('update', array(
	    'model' => $model,
	));
    }

    /**
     * Esegue un particolare export
     */
    public function actionExec($id) {
	$model = $this->loadModel($id);

	set_time_limit(6000);
	$query = $model->query;
	$json_parametri = json_decode($model->json_params);
	if (count($json_parametri) > 0) {
	    foreach ($json_parametri->campi as $campo) {
		$query = str_replace('::' . $campo->parametro, '"' . $_POST[$campo->parametro] . '"', $query);
	    }
	}
//			if($_POST['tipo_export'] == "csv"){
//                            $this->genCsv($query, $_POST['intestazione'], str_replace(" ","_",$model->nome).".csv");
//                            exit();
//			}elseif($_POST['tipo_export'] == "excel"){
	//$this->genCsv($query, $_POST['intestazione'], str_replace(" ", "_", $model->nome) . ".csv");
	$this->genExcel($query, str_replace(" ", "_", $model->nome) . ".xlsx");
	exit();

//		$this->render('exec',array(
//			'model'=>$model,
//		));
    }

    /**
     * Esegue un particolare export
     */
    public function actionExecScheduler($id) {
	$model = ExportController::loadModel($id);
	echo "\nRunning export: " . $model->nome . "...\n";
	set_time_limit(6000);

	// Se è già presente un file dei cambiamenti di oggi esci 
	$fileurl = Yii::app()->params['faaccpURL'] . Yii::app()->params['exportDownloadFolder'] . date("Ymd") . '-' . str_replace(" ", "_", $model->nome) . '.xlsx';
	$fheaders = @get_headers($fileurl);
	if (!strpos($fheaders[0], '404')) {
	    echo "Export file already exists: abort! \n";
	    die();
	}

	$query = $model->query;
	$json_parametri = json_decode($model->json_params);
	if (count($json_parametri) > 0) {
	    foreach ($json_parametri->campi as $campo) {
		$query = str_replace('::' . $campo->parametro, '"' . $_POST[$campo->parametro] . '"', $query);
	    }
	}
	$fileExported = ExportController::genScheduledExcel($query, str_replace(" ", "_", $model->nome) . ".xlsx");
	//$fileExported = ExportController::genScheduledCsv($query, $_POST['intestazione'], str_replace(" ","_",$model->nome).".csv");

	if ($fileExported == "NODATA") {
	    echo "No changes today, email not sent";
	    die();
	}
	if ($fileExported == NULL) {
	    echo 'Error saving Excel file';
	} else {
	    $messaggio = 'Scaricare il file Excel generato in data ' . date('d/m/Y') . ' al link qui sotto:<br/><br/>'
		    . '<a href="' . $fileExported . '">' . $fileExported . '</a><br/><br/>';
	    //echo $messaggio."\n";			
	    // Log a console invio TODO: aggiungi + info
	    echo 'File Changes saved in: ' . $fileExported . "\n";
	    $utentiInfo = new User();
	    echo 'Sending email to user ' . $utentiInfo->findByPk('1')->username . ' : ' . $utentiInfo->findByPk('1')->email . " ...\n";
	    EventiController::sendAlert('PoiSendChanges', array(), array(), $messaggio);
	}
    }

    /*
     * Crea il file di export in formato CSV
     */

    private function genScheduledCsv($query, $intestazione, $fileName) {
	try {
	    $connection = Yii::app()->dbRead;
	    $command = $connection->createCommand($query);
	    $dati = $command->query();
	    $fname = Yii::app()->basePath . '/../' . Yii::app()->params['exportDownloadFolder'] . date("Ymd") . '-' . $fileName;
	    //$fname = tempnam("/tmp", $fileName);
	    $NewFile = fopen($fname, "w");
	    fwrite($NewFile, "\xEF\xBB\xBF"); // UTF-8 BOM
// 		Cicla i risultati
	    if ($dati->rowCount == 0) {
		return('NODATA');
		die();
	    }
	    foreach ($dati as $key => $row) {
		if ($key == 0) {
// 				Se si � scelto di inserire anche l'intestazione
		    $testa = "";
		    foreach ($row as $nomeCampo => $valore) {
			$testa = $testa . $nomeCampo . "|";
		    }
		    $testa = substr($testa, 0, -1) . "\n";
		    fwrite($NewFile, $testa);
		}

// 			Cicla i valori
		$csv = "";
		foreach ($row as $nomeCampo => $valore) {
		    $csv = $csv . $valore . "|";
		}
		$csv = substr($csv, 0, -1) . "\n";
		fwrite($NewFile, $csv);
	    }

	    fclose($NewFile);
	    header('Pragma: public');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header("Content-Type: text/csv; name=\"$fileName\"");
	    header("Content-Disposition: attachment; filename=\"$fileName\"");
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Length: " . filesize($fname));
	    header("Connection: Close");
	    //readfile($fname);
	    // Salva file export Excel in public
	    $exportURL = Yii::app()->params['faaccpURL'] . Yii::app()->params['exportDownloadFolder'] . date("Ymd") . '-' . $fileName;
	    // Cancella file tmp
	    //unlink($fname);
	} catch (CDbException $e) {
	    throw new CHttpException(500, 'Database error: ' . $e->getMessage());
	}
	//var_dump($exportURL);
	return $exportURL;
    }

    /*
     * Crea il file di export in formato Excel e lo salva nella dir di download
     */

    private function genScheduledExcel($query, $fileName) {
	try {
	    $connection = Yii::app()->dbRead;
	    $command = $connection->createCommand($query);
	    $dati = $command->query();
	    $fname = tempnam("/tmp", $fileName);
	    $NewFile = fopen($fname, "w");
	    fwrite($NewFile, "\xEF\xBB\xBF"); // UTF-8 BOM
	    // Cicla i risultati
	    if ($dati->rowCount == 0) {
		return('NODATA');
		die();
	    }
	    foreach ($dati as $key => $row) {
		if ($key == 0) {
		    //Se si è scelto di inserire anche l'intestazione
		    $testa = "";
		    foreach ($row as $nomeCampo => $valore) {
			$testa = $testa . $nomeCampo . "|";
		    }
		    $testa = substr($testa, 0, -1) . "\n";
		    fwrite($NewFile, $testa);
		}

		// 	Cicla i valori
		$csv = "";
		foreach ($row as $nomeCampo => $valore) {
		    $csv = $csv . $valore . "|";
		}
		$csv = substr($csv, 0, -1) . "\n";
		fwrite($NewFile, $csv);
	    }

	    fclose($NewFile);
	    $objReader = PHPExcel_IOFactory::createReader('CSV');

	    // If the files uses a delimiter other than a comma (e.g. a tab), then tell the reader
	    $objReader->setDelimiter("|");
	    $objPHPExcel = $objReader->load($fname);
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

	    header('Pragma: public');
	    header('Expires: 0');
	    //		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name=\"$fileName\"");
	    header("Content-Disposition: attachment; filename=\"$fileName\"");
	    header("Content-Transfer-Encoding: binary");
	    header("Connection: Close");
	    // Salva file export Excel in public
	    $path = Yii::app()->basePath . '/../' . Yii::app()->params['exportDownloadFolder'] . date("Ymd") . '-' . $fileName;
	    $objWriter->save($path);
	    $exportURL = Yii::app()->params['faaccpURL'] . Yii::app()->params['exportDownloadFolder'] . date("Ymd") . '-' . $fileName;
	    // Cancella file tmp
	    unlink($fname);
	} catch (CDbException $e) {
	    throw new CHttpException(500, 'Database error: ' . $e->getMessage());
	}
	//var_dump($path);
	//var_dump($exportURL);
	return $exportURL;
    }

    /*
     * Crea il file di export in formato CSV
     */

    private function genCsv($query, $intestazione, $fileName) {
	try {
	    $connection = Yii::app()->db;
	    $command = $connection->createCommand($query);
	    $dati = $command->query();
	    $fname = tempnam("/tmp", $fileName);
	    $NewFile = fopen($fname, "w");
	    fwrite($NewFile, "\xEF\xBB\xBF"); // UTF-8 BOM
// 		Cicla i risultati
	    foreach ($dati as $key => $row) {
		if ($key == 0 && $intestazione == 'si') {
// 				Se si � scelto di inserire anche l'intestazione
		    $testa = "";
		    foreach ($row as $nomeCampo => $valore) {
			$testa = $testa . $nomeCampo . "|";
		    }
		    $testa = substr($testa, 0, -1) . "\n";
		    fwrite($NewFile, $testa);
		}

// 			Cicla i valori
		$csv = "";
		foreach ($row as $nomeCampo => $valore) {
		    $csv = $csv . $valore . "|";
		}
		$csv = substr($csv, 0, -1) . "\n";
		fwrite($NewFile, $csv);
	    }

	    fclose($NewFile);
	    header('Pragma: public');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header("Content-Type: text/csv; name=\"$fileName\"");
	    header("Content-Disposition: attachment; filename=\"$fileName\"");
	    header("Content-Transfer-Encoding: binary");
	    header("Content-Length: " . filesize($fname));
	    header("Connection: Close");
	    readfile($fname);
	} catch (CDbException $e) {
	    throw new CHttpException(500, 'Database error: ' . $e->getMessage());
	}
    }

    /*
     * Crea il file di export in formato Excel
     */

    private function genExcel($query, $fileName) {
	try {
	    $connection = Yii::app()->db;
	    $command = $connection->createCommand($query);
	    $dati = $command->query();
	    $fname = tempnam(Yii::getPathOfAlias('webroot') . '/public/excel/', $fileName);
	    $NewFile = fopen($fname, "w");
	    fwrite($NewFile, "\xEF\xBB\xBF"); // UTF-8 BOM
// 		Cicla i risultati
	    foreach ($dati as $key => $row) {
		if ($key == 0) {
// 				Se si � scelto di inserire anche l'intestazione
		    $testa = "";
		    foreach ($row as $nomeCampo => $valore) {
			$testa = $testa . $nomeCampo . "|";
		    }
		    $testa = substr($testa, 0, -1) . "\n";
		    fwrite($NewFile, $testa);
		}

// 			Cicla i valori
		$csv = "";
		foreach ($row as $nomeCampo => $valore) {
		    $csv = $csv . $valore . "|";
		}
		$csv = substr($csv, 0, -1) . "\n";
		fwrite($NewFile, $csv);
	    }

	    fclose($NewFile);
	    $objReader = PHPExcel_IOFactory::createReader('CSV');

	    // If the files uses a delimiter other than a comma (e.g. a tab), then tell the reader
	    $objReader->setDelimiter("|");
	    $objPHPExcel = $objReader->load($fname);
	    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

	    header('Pragma: public');
	    header('Expires: 0');
	    //		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	    header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; name=\"$fileName\"");
	    header("Content-Disposition: attachment; filename=\"$fileName\"");
	    header("Content-Transfer-Encoding: binary");
	    header("Connection: Close");
	    $objWriter->save('php://output');

	    unlink($fname);
	} catch (CDbException $e) {
	    throw new CHttpException(500, 'Database error: ' . $e->getMessage());
	}
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
	if (Yii::app()->request->isPostRequest) {
	    // we only allow deletion via POST request
	    $this->loadModel($id)->delete();

	    // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
	    if (!isset($_GET['ajax']))
		$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	} else
	    throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
	$model = new Export('search');
	$model->unsetAttributes(); // clear any default values
	if (isset($_GET['Export']))
	    $model->attributes = $_GET['Export'];

	$this->render('admin', array(
	    'model' => $model,
	));
    }

    /**
     * Manages all models.
     */

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
	$model = Export::model()->findByPk((int) $id);
	if ($model === null)
	    throw new CHttpException(404, 'The requested page does not exist.');
	return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
	if (isset($_POST['ajax']) && $_POST['ajax'] === 'export-form') {
	    echo CActiveForm::validate($model);
	    Yii::app()->end();
	}
    }

}
