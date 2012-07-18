<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CasosRecord extends TActiveRecord
{
    const TABLE="casos"; //table name

    public $id;
	public $estado;
    public $pruebas;
    public $descripcion;
    public $tipificaciones;
    public $grupo_id;
    public $quejoso_id;
	public $aprendiz_id;
    public $fecha;

	//public $grupo;
	
	public static $RELATIONS=array
    (
        'grupo' => array(self::BELONGS_TO, 'GruposRecord','grupo_id'),
		'quejoso' => array(self::BELONGS_TO, 'QuejososRecord','quejoso_id'),
		'aprendiz' => array(self::BELONGS_TO, 'AprendicesRecord','aprendiz_id'),
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