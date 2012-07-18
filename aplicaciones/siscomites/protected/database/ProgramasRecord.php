<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class ProgramasRecord extends TActiveRecord
{
    const TABLE="programas"; //table name

    public $id;
	public $codigo;
    public $nombre;
    public $coordinador_nombre;
    public $coordinador_id;
    public $coordinador_id_tipo;
	public $correo_envio;
	public $correo_envio_pass;
    public $correo_host;
	public $correo_auth;
	public $ambiente_comites;
	public $informacion;
	public $centro_id;
	

	public static $RELATIONS=array
    (
        'centro' => array(self::BELONGS_TO, 'CentrosRecord','centro_id'),
		'programas' => array(self::HAS_MANY, 'IntegrantesRecord', 'programa_id'),
		'sesiones' => array(self::HAS_MANY, 'SesionesRecord', 'programa_id'),
		'grupos' => array(self::HAS_MANY, 'GruposRecord', 'programa_id'),
		'usuarios' => array(self::HAS_MANY, 'UsuariosRecord', 'programa_id'),
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