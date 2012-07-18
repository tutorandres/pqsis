<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_asistente_acta extends TPage
{
    
	    
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Agregar asistente";		
    } 
	
	
	
	
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
			
			$AsistenteRecord = new AsistentesRecord();
			$AsistenteRecord->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->nombre->Text),MB_CASE_TITLE,"UTF-8"));
			$AsistenteRecord->rol = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->rol->Text),MB_CASE_TITLE,"UTF-8"));
			$AsistenteRecord->entidad = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->entidad->Text),MB_CASE_TITLE,"UTF-8"));
			$AsistenteRecord->numero = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->numero->Text),MB_CASE_TITLE,"UTF-8"));
			$AsistenteRecord->correo = htmlspecialchars($this->correo->Text);
			$AsistenteRecord->asistio = htmlspecialchars($this->asistio->getSelectedValue());
			$AsistenteRecord->acta_id = htmlspecialchars($this->request['acta_id']);
			
			$this->agregar_mensajes_unicode($AsistenteRecord->save(),'Agregar asistente',true);			
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