<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.

  La routine effettua i controllo dell'autenticazione tramite  il server LDAP (definito nei parametri
  param/ldap nel modulo "main.php") oppure, se non attivato, tramite il databale via tabella "loc_users".
  L'abilitazione dell'auteticazione via LDAP viene effettuata definendo i parametri

  La funzione si appoggia inoltre alla tabella "Utenti" che contiene i livelli utente
 * (0=guest, 1=normal user, 2=system user, 3=admin)		
  Nota: il campo password viene gestito solo in caso di autenticazione senza LDAP.

  Memorizza inoltre le seguenti informazioni (se presenti):
  Yii::app()->user->id;              -> username (effettuato per default dalla classe)
  Yii::app()->user->usrFullName;     -> nome completo dell'utente (tramite setstate)
  Yii::app()->user->usrEmail;        -> indirizzo di posta dell'utente (tramite setstate)
  Yii::app()->user->usrLevel;        -> livello privilegi utente (tramite setstate)
 */
class UserIdentity extends CUserIdentity {

	private $_id = NULL;

	public function auditWrite($username) {
		$record = new Audit;
		$record->username = $username;
		$record->dateof = new CDbExpression('NOW()');
		$record->code = 1001;
		$record->message = '';
		$record->save();

		Yii::log('AuditWrite (LOGIN): ' . $username, 'info', 'system.web.UserIdentity');
	}

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {

		if (is_null(Yii::app()->params['ldap'])) {	// Autentecazione senza LDap
			$username = $this->username;				// Legge il parametro dalla form
			$password = $this->password;				// Legge il parametro dalla form		
			// ------------------------------------
			// ------ accede alla local user ------
			// ------------------------------------
			$record = User::model()->findByAttributes(array('username' => $username));
			if (is_null($record)) {
				Yii::log('Invalid username [Local]', 'error', 'system.web.UserIdentity');
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				return !$this->errorCode;
			}

			if ($password != $record->password) {
				Yii::log('Invalid password [Local]', 'error', 'system.web.UserIdentity');
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				return !$this->errorCode;
			}

			//$this->auditWrite($username);  // Scrive l'audit
			$this->errorCode = self::ERROR_NONE;
			$this->_id = $record->id;
			$this->setState('admin', $record->isAdmin());
			
			// Store the role in the session if it is set
			if ($arrayAuthRoleItems = Yii::app()->authManager->getAuthItems(2, $record->id)) {
				$arrayKeys = array_keys($arrayAuthRoleItems);
				$role = strtolower($arrayKeys[0]);
				$this->setState('roles', $arrayKeys);
			}
			
			return !$this->errorCode;
			
		} else { // Via LDAP
			$options = Yii::app()->params['ldap'];
			$dc_string = "dc=" . implode(",dc=", $options['dc']);
			$connection = ldap_connect($options['host'], $options['port']);

			if ($connection == NULL) {
				Yii::log('LDAP Error connection', 'error', 'system.web.UserIdentity');
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				return !$this->errorCode;
			}

			ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($connection, LDAP_OPT_REFERRALS, 0);

			$username = $this->username;	// Legge il parametro dalla form
			$password = $this->password;	// Legge il parametro dalla form
			$userDom = $options['domain'] . "\\" . $this->username; // Username+Dominio
			//Yii::log('LDAP Query:'.$userDom, 'info', 'system.web.UserIdentity');
			// Collega l'utenza di servizio
			$bind = @ldap_bind($connection, $userDom, $password);
			if ($bind == NULL) {
				Yii::log('LDAP Error bind USER', 'error', 'system.web.UserIdentity');
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				@ldap_close($connection);
				return !$this->errorCode;
			}

			$_SecurityGroups = array();
			$_UsrFullName = "";
			$_UsrEmail = "";

			// -------------------------------------------------------------
			// ------ Connessione LDAP OK / Legge gli altri parametri ------
			// -------------------------------------------------------------
			// Cerca l'utente effettivo 
			$filter = "(sAMAccountName=" . $username . ")";
			Yii::log('LDAP search: ' . $filter, 'info', 'system.web.UserIdentity');

			$result = ldap_search($connection, $dc_string, $filter);
			ldap_sort($connection, $result, "sn");
			$info = ldap_get_entries($connection, $result);

			// LEGGO INFO UTENTE
			if ($info['count'] > 0) {
				$_UsrFullName = (isset($info['0']['givenname']['0'])) ? ($info['0']['givenname']['0']) : ('');
				$_UsrEmail = (isset($info['0']['mail']['0'])) ? ($info['0']['mail']['0']) : ('');

				if (isset($info['0']['memberof'])) {
					foreach ($info['0']['memberof'] AS $sg) {
						preg_match('/CN=(.*?),/', $sg, $matches);
						if (isset($matches[1])) {
							// popolo l'array dei gruppo con i soli consentiti
							if (in_array($matches['1'], $options['groupsEnabled'])) {
								$_SecurityGroups[] = $matches['1'];
								//Yii::log("Gruppo =".$matches['1'], 'info', 'system.web.UserIdentity');
							}
						}
					}
				}
			}

			@ldap_close($connection);

			// ------------------------------------
			// ------ accede alla local user ------
			// ------------------------------------
			// OLD gestione dei ruoli SRBAC : aggiungo i ruoli in base ai gruppi esistenti
			// $this->checkRoles($_SecurityGroups);
			// gestione dei ruoli SRBAC : aggiungo i ruoli al sistema in base A QUELLI ABILITATI IN CONF
			$this->checkRoles($options['groupsEnabled']);
			
			// se l'utente appartiene ad un gruppo abilitato da CONF
			if (count($_SecurityGroups) > 0) {
				$record = User::model()->findByAttributes(array('username' => $username));

				if (isset($record)) {
					//aggiorno email
					if ($record->email != $_UsrEmail) {
						$record->email = $_UsrEmail;
						$record->save();
					}
				} else {
					$record = new User;
					$record->username = $username;
					$record->email = $_UsrEmail;
					$record->save();
				}

				$this->assignRoles($_SecurityGroups, $record->id);

				$this->setState('usrFullName', $_UsrFullName);
				$this->setState('usrEmail', $_UsrEmail);

				$this->auditWrite($username);	// Scrive l'audit

				$this->errorCode = self::ERROR_NONE;
				$this->_id = $record->id;
				$this->setState('admin', $record->isAdmin());
				
				// Store the role in the session:
				$arrayAuthRoleItems = Yii::app()->authManager->getAuthItems(2, $record->id);
				$arrayKeys = array_keys($arrayAuthRoleItems);
				$role = strtolower($arrayKeys[0]);
				$this->setState('roles', $arrayKeys);

			return !$this->errorCode;
			} else {
				Yii::log('LDAP GROUP not valid', 'error', 'system.web.UserIdentity');
				$this->errorCode = self::ERROR_USERNAME_INVALID;
				@ldap_close($connection);
				return !$this->errorCode;
			}
		}
		
	}

//        // OLD aggiorna i ruoli della piattaforma sulla base dei gruppi AD dell'utente
//	public function checkRoles($groups) 
//	{
//            $connection = Yii::app()->db;
//            
//            $sql = 'SELECT name FROM srbac_items WHERE type = 2';
//            $command = $connection->createCommand($sql);
//            $roles = $command->queryAll();
//            
//            $roleNames[] = '';          
//            
//            // transcodifica dei nomi perchè PHP!!!!
//            foreach($roles as $role) {
//                $roleNames[] = $role['name'];
//            }
//   
//            foreach($groups AS $group){
//                // aggiungo solo i gruppi abilitati in conf
//                if(!in_array($group,$roleNames) && in_array($options['groupsEnabled'])){
//                    $sql = "insert into srbac_items (name, type) values ('".$group."','2')";
//                    Yii::app()->db->createCommand($sql)->execute();
//                    Yii::log('Role created: '.$group, 'info', 'system.web.UserIdentity');	
//                }  
//            }	
//	}
	// aggiorna i ruoli della piattaforma sulla base di quelli abilitati da CONF
	public function checkRoles($groups) {
		$connection = Yii::app()->db;

		$sql = 'SELECT name FROM srbac_items WHERE type = 2';
		$command = $connection->createCommand($sql);
		$roles = $command->queryAll();

		$roleNames[] = '';

		// transcodifica dei nomi perchè PHP!!!!
		foreach ($roles as $role) {
			$roleNames[] = $role['name'];
		}

		foreach ($groups AS $group) {
			// aggiungo solo i gruppi abilitati in conf
			if (!in_array($group, $roleNames)) {
				$sql = "insert into srbac_items (name, type) values ('" . $group . "','2')";
				Yii::app()->db->createCommand($sql)->execute();
				Yii::log('Role created: ' . $group, 'info', 'system.web.UserIdentity');
			}
		}
	}

	// aggiorna i ruoli dell'utente in base a quelli di AD
	public function assignRoles($groups, $userId) {
		$connection = Yii::app()->db;

		$sql = 'SELECT itemname FROM srbac_assignments WHERE userid = ' . $userId;
		$command = $connection->createCommand($sql);
		$roles = $command->queryAll();

		$names[] = '';

		// transcodifica dei nomi perchè PHP!!!!
		foreach ($roles as $role) {
			$names[] = $role['itemname'];
		}

		array_push($groups, 'Base');

		foreach ($groups AS $group) {
			if (!in_array($group, $names)) {
				$sql = "insert into srbac_assignments (itemname, userid, bizrule, data) values ('" . $group . "','" . $userId . "','','s:0:\"\";')";
				Yii::app()->db->createCommand($sql)->execute();
				Yii::log('Role ' . $group . 'assigned to user ' . $userId, 'info', 'system.web.UserIdentity');
			}
		}
	}

	public function getId() {
		return $this->_id;
	}

}
