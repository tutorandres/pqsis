<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class TipificacionesRecord extends TActiveRecord
{
    const TABLE="tipificaciones"; //table name

    public $id;
    public $nombre;
    public $tipo_falta;
    public $reglamento_aplicado;
	public $nivel;

	
	
    /**
     * @return TActiveRecord active record finder instance
     */
    public static function finder($className=__CLASS__)
    {
        return parent::finder($className);
    }
}


?>
