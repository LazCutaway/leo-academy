<?php

class m140908_113511_crea_lov extends CDbMigration
{
	public function up()
	{
		//TABELLA
		$this->createTable('lov', array(
            'id' => 'pk', //
            'lista' => 'VARCHAR(50) NOT NULL',
            'codice' => 'VARCHAR(50)',
            'descrizione' => 'VARCHAR(50)',
            'ordine' => 'INTEGER(5)',
            'flag_attivo' => 'boolean'
        ));

        $this->seedLov();
	}

	public function down()
	{
		$this->dropTable('lov');
	}

	public function seedLov()
	{

		$lov_names = array(
			'stato_candidato' => 'stato_candidato',
			'priorita_candidato' => 'priorita_candidato',
			'fase_sarf' => 'fase_sarf',
			'struttura_sito' => 'struttura_sito',
			'ruolo_sito' => 'ruolo_sito',
			'status_permessi' => 'status_permessi',
			'tipologia_locatore' => 'tipologia_locatore',
			'tecnologia' => 'tecnologia',
			'posizione' => 'posizione',
			'fattibilita_contrattuale' => 'fattibilita_contrattuale',
			'tipologia_permesso' => 'tipologia_permesso',
			'vincoli' => 'vincoli',
			'tipologia_contratto' => 'tipologia_contratto',
			'status_contratto' => 'status_contratto',
			'documentazione_contrattuale' => 'documentazione_contrattuale',
			'evento_decorrenza_contrattuale' => 'evento_decorrenza_contrattuale',
			'rinnovo_contratto' => 'rinnovo_contratto',
			'termini_rinnovo' => 'termini_rinnovo',
			'termine_preavviso_recesso' => 'termine_preavviso_recesso',
			'cessione' => 'cessione',
			'sublocazione' => 'sublocazione',
			'istat' => 'istat',
			'perc_istat' => 'perc_istat',
			'onere_registrazione' => 'onere_registrazione',
			'percentuale_registrazione' => 'percentuale_registrazione',
			'modalita_registrazione' => 'modalita_registrazione',
			'tipologia_rata' => 'tipologia_rata',
			'tipologia_integrazione' => 'tipologia_integrazione',
			'stato_pratica' => 'stato_pratica',
			'fornitura' => 'fornitura',
			'potenza_richiesta' => 'potenza_richiesta',
			'procedimento' => 'procedimento',
			'status_richiesta' => 'status_richiesta',
			'stato_sollecito' => 'stato_sollecito'
		);

		$class = new ListOfValues();
		foreach($lov_names as $k => $v){
			$i = 1;
			foreach($class->getListFile($k) as $key => $value){
				$this->insert('lov', array('lista' => $k, 'codice' => $key, 'descrizione' => $value, 'ordine' => $i, 'flag_attivo' => true));
				$i++;
			};
		};

	}
}