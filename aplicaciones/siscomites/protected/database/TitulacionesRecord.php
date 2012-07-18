<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TitulacionesRecord extends TActiveRecord
{
    const TABLE="titulaciones"; //table name

    public $id;
    public $nombre;
    public $tipo;

	public static $RELATIONS=array
    (
		'grupos' => array(self::HAS_MANY, 'GruposRecord', 'titulacion_id'),
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
