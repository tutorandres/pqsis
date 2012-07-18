<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class GruposRecord extends TActiveRecord
{
    const TABLE="grupos"; //table name

    public $id;
    public $codigo;
    public $director_nombre;
	public $director_correo;
	public $vocero_nombre;
	public $vocero_correo;
    public $fecha_inicial;
    public $fecha_final;
    public $estado;
    public $titulacion_id;
	public $programa_id;
	
	
	//public $casos=array();
	
	
	public static $RELATIONS=array
    (
        'programa' => array(self::BELONGS_TO, 'ProgramasRecord','programa_id'),
		'titulacion' => array(self::BELONGS_TO, 'TitulacionesRecord','titulacion_id'),
		'casos' => array(self::HAS_MANY, 'CasosRecord', 'grupo_id'),
		'informes' => array(self::HAS_MANY, 'InformesRecord', 'grupo_id'),
		'programaciones' => array(self::HAS_MANY, 'ProgramacionesRecord', 'grupo_id'),
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