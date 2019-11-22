<?php

class Service extends CApplicationComponent {

	public function actionCom() {
		$connection = Yii::app()->db;

		$sql = 'SELECT descrizione FROM comuni ORDER BY descrizione';
		$command = $connection->createCommand($sql);
		$comuni = $command->queryAll($fetchAssociative = true);

		$comArray = array();

		foreach ($comuni as $comune) {
			array_push($comArray, $comune['descrizione']);
		}

		return $comArray;
	}

	public function regioniSelect() {

		$ret_array = array();
		$ret_array[''] = '';

		foreach (Regioni::model()->findall(array('order' => 'descrizione')) as $r) {
			$ret_array[$r->id] = $r->descrizione;
		};

		return $ret_array;
	}

	public function fromComuneToFullSelect($id_comune) {

		$ret_array = array();
		$comune = Comuni::model()->findByPk($id_comune);

		$ret_array['comuni'] = array();
		$ret_array['comuni'][''] = '';
		foreach (Comuni::model()->findAll('id_provincia=:id_provincia ORDER BY descrizione', array('id_provincia' => $comune->provincia->id)) as $r) {
			$ret_array['comuni'][$r->id] = $r->descrizione;
		};

		$ret_array['province'] = array();
		$ret_array['province'][''] = '';
		foreach (Province::model()->findAll('id_regione=:id_regione ORDER BY descrizione', array('id_regione' => $comune->provincia->regione->id)) as $r) {
			$ret_array['province'][$r->id] = $r->descrizione . ' - ' . $r->targa;
		};

		$ret_array['regioni'] = array();
		$ret_array['regioni'][''] = '';
		foreach (Regioni::model()->findAll(array('order' => 'descrizione')) as $r) {
			$ret_array['regioni'][$r->id] = $r->descrizione;
		};

		return $ret_array;
	}
	
}
