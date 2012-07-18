<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ReglamentosRecord extends TActiveRecord
{
    const TABLE="reglamentos"; //table name

    public $id;
	public $nombre;
    public $tipo;
    public $texto;
 
 

    /**
     * @return TActiveRecord active record finder instance
     */
    public static function finder($className=__CLASS__)
    {
        return parent::finder($className);
    }
}


?>