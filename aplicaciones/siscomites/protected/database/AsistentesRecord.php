<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AsistentesRecord extends TActiveRecord
{
    const TABLE="asistentes"; //table name

	public $id;
    public $nombre;
    public $rol;
	public $entidad;
	public $numero;
	public $correo;
    public $asistio;
    public $acta_id;

 
 	public static $RELATIONS=array
    (
        'acta' => array(self::BELONGS_TO, 'ActasRecord','acta_id'),
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