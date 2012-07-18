<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ProgramacionesRecord extends TActiveRecord
{
    const TABLE="programaciones"; //table name

    public $id;
	public $hora;
    public $caso;
    public $informe;
	public $estado;
	public $grupo_id;
	public $sesion_id;
	
	

    public static $RELATIONS=array
    (
        'grupo' => array(self::BELONGS_TO, 'GruposRecord','grupo_id'),
		'sesion' => array(self::BELONGS_TO, 'SesionesRecord','sesion_id'),
		'procesos' => array(self::HAS_MANY, 'ProcesosRecord', 'proceso_id'),
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