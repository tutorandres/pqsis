<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class AprendicesRecord extends TActiveRecord
{
    const TABLE="aprendices"; //table name

    public $id;
	public $identificacion;
    public $nombre;
    public $correo;
	public $id_tipo;

	
	public static $RELATIONS=array
    (
        'casos' => array(self::HAS_MANY, 'CasosRecord', 'aprendiz_id'),
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