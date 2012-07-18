<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class SesionesRecord extends TActiveRecord
{
    const TABLE="sesiones"; //table name

    public $id;
	public $fecha;
	public $estado;
	public $programa_id;
	public $trimestre_id;
	
		
	public static $RELATIONS=array
    (
		'programa' => array(self::BELONGS_TO, 'ProgramasRecord','programa_id'),
		'trimestre' => array(self::BELONGS_TO, 'TrimestresRecord','trimestre_id'),
		'programaciones' => array(self::HAS_MANY, 'ProgramacionesRecord', 'sesion_id'),
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