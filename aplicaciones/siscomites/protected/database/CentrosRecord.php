<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class CentrosRecord extends TActiveRecord
{
    const TABLE="centros"; //table name

    public $id;
	public $codigo;
    public $nombre;
    public $subdirector_nombre;
    public $subdirector_id;
    public $subdirector_id_tipo;
    public $direccion_y_telefono;
    public $regional_id;
    public $ciudad;
	public $regional;


 
    public static $RELATIONS=array
    (
        'programas' => array(self::HAS_MANY, 'ProgramasRecord', 'centro_id'),
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