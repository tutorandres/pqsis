<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SancionesRecord extends TActiveRecord
{
    const TABLE="sanciones"; //table name

    public $id;
	public $nombre;

		
	public static $RELATIONS=array
    (
		'decisiones' => array(self::HAS_MANY, 'DecisionesRecord', 'sancion_id'),
    );
	
		
		
		
    /**
     * @return TActiveRecord active record finder instance
     */
    public static function finder($className=__CLASS__)
    {
        return parent::finder($className);
    }
}


?>