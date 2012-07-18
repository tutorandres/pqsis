<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AdministracionRecord extends TActiveRecord
{
    const TABLE="administracion"; //table name

	public $id;
    public $nombre;
    public $correo;
	
 
    /**
     * @return TActiveRecord active record finder instance
     */
    public static function finder($className=__CLASS__)
    {
        return parent::finder($className);
    }
}


?>