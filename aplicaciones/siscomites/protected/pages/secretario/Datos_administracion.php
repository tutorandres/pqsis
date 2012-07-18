<?php
 /* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Datos_administracion extends TPage
{

    var $total_registros;
	
     
    public function onLoad($param)
    {
        parent::onLoad($param);
        if(!$this->IsPostBack)
        {

        	$this->Title="Modificar usuario";
					
			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
					
		    $this->recargar();
		
		
		}
	}						   

 
 
    public function recargar($limit = Null)
    {   				
		$contacto = AdministracionRecord::finder()->findAll();
		
		$this->nombre->Text = $contacto[0]->nombre;
		$this->correo->Text = $contacto[0]->correo;	
    }
 
    
	 
	public function guardar($sender,$param)
    {
	    $this->mensajes->Text = '';
		$this->alertas->Text = '';
	
		$datos = AdministracionRecord::finder()->findByPk(1);
		
		$datos->nombre = htmlspecialchars($this->nombre->Text);
		$datos->correo = htmlspecialchars($this->correo->Text);
		
		$this->agregar_mensajes_unicode($datos->save(),'Guardar Administración',true); 
		
		$this->recargar();	
	}
	 
	 
	 
	 
	 
	 
	 
	 
		public function agregar_mensajes_unicode($flag,$mensaje,$alert)
		{
			if($flag)
			{
				  $this->mensajes->Text = '<div class="ok-message">Proceso ejecutado satisfactoriamente (' . htmlentities($mensaje) . ').</div>' .  $this->mensajes->Text;
			      $men_alert = 'OK - '. utf8_encode($mensaje);
			}
			else 
			{
				  $this->mensajes->Text = '<div class="error-message">No se pudo completar el proceso (' . htmlentities($mensaje) . ').</div>' .  $this->mensajes->Text;		
				  $men_alert = 'ERROR - '. utf8_encode($mensaje);
		    }
		    
			if($alert)
			      $this->alertas->Text = '<script languaje="javascript">alert("'. $men_alert .'");</script>' .  $this->alertas->Text; 
		
		}
	 
	 
	 
}
 
?>