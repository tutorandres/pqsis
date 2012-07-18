<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ActasRecord extends TActiveRecord
{
    const TABLE="actas"; //table name

	public $id;
    public $fecha;
    public $tipo_id;
    public $hora;
	public $horafin;
    public $lugar;
    public $responsable;
    public $introduccion;
    public $estado;
 
 
    public static $RELATIONS=array
    (
        'procesos' => array(self::HAS_MANY, 'ProcesosRecord', 'acta_id'),
		'asistentes' => array(self::HAS_MANY, 'AsistentesRecord', 'acta_id'),
		'compromisos' => array(self::HAS_MANY, 'CompromisosRecord', 'acta_id'),
		'tipo' => array(self::BELONGS_TO, 'TiposRecord','tipo_id'),
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