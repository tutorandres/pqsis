<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class InformesRecord extends TActiveRecord
{
    const TABLE="informes"; //table name

    public $id;
	public $grupo_id;
    public $descripcion;
    public $nombre;
	public $identificacion;
	public $identificacion_tipo;
	public $correo;
	public $estado;
	public $fecha;
		
		
	public static $RELATIONS=array
    (
        'grupo' => array(self::BELONGS_TO, 'GruposRecord','grupo_id'),
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