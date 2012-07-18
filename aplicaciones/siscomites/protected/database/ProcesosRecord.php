<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ProcesosRecord extends TActiveRecord
{
    const TABLE="procesos"; //table name

	public $id;
    public $acta_id;
    public $programacion_id;
    public $codigo;
    public $tipo;
    public $estado;
 
 
 
 	public static $RELATIONS=array
    (
        'acta' => array(self::BELONGS_TO, 'ActasRecord','acta_id'),
		'programacion' => array(self::BELONGS_TO, 'ProgramacionesRecord','programacion_id'),
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