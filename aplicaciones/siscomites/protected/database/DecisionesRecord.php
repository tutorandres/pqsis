<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class DecisionesRecord extends TActiveRecord
{
    const TABLE="decisiones"; //table name

    public $id;
	public $descargo;
    public $existencia;
    public $constituye;
    public $probable;
    public $responsabilidad;
	public $danos;
	public $participacion;
	public $antecedente;
	public $rendimiento;
	public $confeso;
	public $procuro;
	public $reparo;
    public $calificacion;
	public $incluir;
	public $amerita;
	public $responsable;
	public $reglamentos;
	public $sancion_id;
	public $duracion;

 
    public static $RELATIONS=array
    (
		'sancion'  => array(self::BELONGS_TO, 'SancionesRecord','sancion_id'),
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