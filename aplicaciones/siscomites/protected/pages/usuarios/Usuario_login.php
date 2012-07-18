<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*'); 


class Usuario_login extends TPage
{

	
	function loginUser($sender,$param)
	{
		$auth=$this->Application->getModule('auth');
		
		//if($auth->login(htmlspecialchars($this->username->Text),htmlspecialchars($this->password->Text),3600))
		if($auth->login(htmlspecialchars($this->username->Text),htmlspecialchars($this->password->Text),1500))
		//last parameter means that login will be expire in 3600 seconds
		{	  
			//login success
			$this->Response->redirect('index.php?page=usuarios.Usuario_menu');
			return true;
		}
		else
		{//login failed
				$this->mensajes->Text = '';
				$this->alertas->Text = '';
		
				$this->agregar_mensajes_unicode(false,'Datos Incorrectos',true);	       
				
				return false;
		}
	
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