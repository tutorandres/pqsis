<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_titulacion extends TPage
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
			
			$datosTitulaciones = new TitulacionesRecord();
		    $datosTitulaciones->nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->nombre->Text),MB_CASE_TITLE,"UTF-8"));
		    $datosTitulaciones->tipo = $this->tipo->getSelectedValue();
			
			$this->agregar_mensajes_unicode($datosTitulaciones->save(),'Agregar titulación',true);
			
			
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