<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TrimestresRecord extends TActiveRecord
{
    const TABLE="trimestres"; //table name

    public $id;
    public $nombre;
	public $estado;
    public $fecha_inicial;
    public $fecha_final;

	
    /**
     * @return TActiveRecord active record finder instance
     */
    public static function finder($className=__CLASS__)
    {
        return parent::finder($className);
    }
}


?>
