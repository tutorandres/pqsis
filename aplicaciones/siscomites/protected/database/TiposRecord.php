<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TiposRecord extends TActiveRecord
{
    const TABLE="tipos"; //table name

	public $id;
    public $nombre;

 
 
    public static $RELATIONS=array
    (
        'actas' => array(self::HAS_MANY, 'ActasRecord', 'tipo_id'),
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