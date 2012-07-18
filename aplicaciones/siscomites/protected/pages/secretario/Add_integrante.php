<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_integrante extends TPage
{
    
    public function onLoad($param)
    {
        parent::onLoad($param);
		
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
		
    }
	
	
	
	
	
	
    public function prepararDatos($sender,$param)
    {
			
			$this->mensajes->Text = '';
			$this->alertas->Text = '';
			
			$IntegrantesRecord = new IntegrantesRecord();
			$IntegrantesRecord->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->nombre->Text),MB_CASE_TITLE,"UTF-8"));
			$IntegrantesRecord->rol = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->rol->Text),MB_CASE_TITLE,"UTF-8"));
			
			$IntegrantesRecord->entidad = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->entidad->Text),MB_CASE_TITLE,"UTF-8"));
			$IntegrantesRecord->numero  = htmlspecialchars($this->numero->Text);			
			
			$IntegrantesRecord->correo = TPropertyValue::ensureString(htmlspecialchars($this->correo->Text));
			$IntegrantesRecord->programa_id = TPropertyValue::ensureInteger(htmlspecialchars($this->Application->User->Roles[1]));
			
			
			$this->agregar_mensajes_unicode($IntegrantesRecord->save(),'Agregar integrante',true);	
			
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