<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_compromiso_acta extends TPage
{
    
	    
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Agregar compromiso";		
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
			
			$compromiso = new CompromisosRecord();
			$compromiso->responsables = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->responsables->Text),MB_CASE_TITLE,"UTF-8"));
			$compromiso->descripcion = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->descripcion->Text),MB_CASE_TITLE,"UTF-8"));
			$compromiso->fecha = htmlspecialchars($this->fecha->getDate());
			$compromiso->acta_id = htmlspecialchars($this->request['acta_id']);
			
			$this->agregar_mensajes_unicode($compromiso->save(),'Agregar compromiso',true);	
						
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