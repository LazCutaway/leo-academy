<?php

/**
 * Utilizzato per le liste di valori
 */
class ListOfValues extends CApplicationComponent 
{
    private $lov_in_use = 'DB';

    /**
     * Restituisce un array con la lista completa
     * 
     * @param String Listname Nome della lista di valori
     * @param String Element Elemento della lista di valori
     * @return Array
     *
     */
    public function getList($name, $element = null){
        switch ($this->lov_in_use){
            case 'DB':
                return $this->getListDb($name, $element);
                break;
            default:
                return $this->getListFile($name, $element);
        };
    }

    /**
     * Restituisce un array con la lista completa su FILE
     * 
     * @param String Listname Nome della lista di valori
     * @param String Element Elemento della lista di valori
     * @return Array
     *
     */
    public static function getListDb($name, $element = null){

        $elementi = Lov::model()->findAll('lista=:lista ORDER BY ordine ASC', array('lista' => $name));
        if(count($elementi) == 0) return array();

        $elenco = array();
        foreach($elementi as $e){
            $elenco[$e->codice] = $e->descrizione;
        };

        if (is_null($element)) return $elenco;

        if (!array_key_exists($element, $elenco)){
            return '--VALORE NON TROVATO--';
        };
        return $elenco[$element];
    }

    /**
     * Restituisce un array con la lista completa su FILE
     * 
     * @param String Listname Nome della lista di valori
     * @param String Element Elemento della lista di valori
     * @return Array
     *
     */
    public static function getListFile($name, $element = null){

    	$lists = array(

	    'lov_gruppo_proponente'=> array(
		    'mktg' => 'Marketing',
		    'sales' => 'Sales',
		    'network' => 'Network',
	    ),					

    	);

    	if (!array_key_exists($name, $lists)) return array();
    	if (is_null($element)) return $lists[$name];

    	if (!array_key_exists($element, $lists[$name])) return null;
    	return $lists[$name][$element];

    }
    
}