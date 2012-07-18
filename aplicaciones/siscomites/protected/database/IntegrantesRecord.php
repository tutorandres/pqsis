<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class IntegrantesRecord extends TActiveRecord
{
    const TABLE="integrantes"; //table name

    public $id;
    public $nombre;
	public $rol;
	public $entidad;
	public $numero;
    public $correo;
	public $programa_id;

	
	public static $RELATIONS=array
    (
        'programa'  => array(self::BELONGS_TO, 'ProgramasRecord','programa_id'),
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