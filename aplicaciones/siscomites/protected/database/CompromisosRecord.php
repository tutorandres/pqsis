<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CompromisosRecord extends TActiveRecord
{
    const TABLE="compromisos"; //table name

	public $id;
    public $responsables;
    public $descripcion;
    public $fecha;
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