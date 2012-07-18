<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


class Modificar_usuario extends TPage
{
   
       
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
	
	public function recargar()
    {
			    $criteria = new TActiveRecordCriteria;
				$criteria->OrdersBy['rol'] = 'asc';
				$criteria->Condition = 'programa_id = :programa AND rol != "Administrador"';
				$criteria->Parameters[':programa'] = $this->Application->User->Roles[1];

				$usuarios = UsuariosRecord::finder()->findAll($criteria);				
				
				if(count($usuarios) > 1)
				{
					    $item = $usuarios[0];
						$this->id1->Value			 = $item->id;
						$this->rol->Text			 = $item->rol;
						$this->nombre_usuario1->Text = $item->nombre;
						$this->password->Text 		 = $item->password;
						
						$item = $usuarios[1];
						$this->id2->Value			 = $item->id;
						$this->rol2->Text			 = $item->rol;
						$this->nombre_usuario2->Text = $item->nombre;
						$this->password2->Text 		 = $item->password;
					
					 
					    $this->guardar->setenabled(true);
				}
				else
				   $this->agregar_mensajes_unicode(false,'No se encontraron los dos usuarios (secretario, instructor) del programa actual. Haga la solicitud al administrador.',false);	
	}			  
	
	
	public function guardar($sender,$param)
    {
	    $this->mensajes->Text = '';
		$this->alertas->Text = '';
	
		$usuario = UsuariosRecord::finder()->findByPk($this->id1->Value);
		$usuario->password = htmlspecialchars($this->password->Text);
		$this->agregar_mensajes_unicode($usuario->save(),'Editar primer rol',false); 
		
		$usuario2 = UsuariosRecord::finder()->findByPk($this->id2->Value);
		$usuario2->password = htmlspecialchars($this->password2->Text);
		$this->agregar_mensajes_unicode($usuario2->save(),'Editar segundo rol',false); 
		
		//Prado::log(var_export($usuario, true),TLogger::ERROR,'ANDRES');
		
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