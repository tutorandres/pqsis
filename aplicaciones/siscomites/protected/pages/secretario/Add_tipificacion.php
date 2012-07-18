<?php 
/* 
 * Generado por el Ingeniero: 
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_tipificacion extends TPage
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
			
			$datosTipificacion = new TipificacionesRecord();
			
		    $datosTipificacion->nombre =TPropertyValue::ensureString($this->nombre->Text);
			$datosTipificacion->tipo_falta =TPropertyValue::ensureString(htmlspecialchars($this->tipo_falta->getSelectedValue()));
			$datosTipificacion->nivel = TPropertyValue::ensureString(urldecode($this->nivel->getSelectedValue()));
			$datosTipificacion->reglamento_aplicado = TPropertyValue::ensureString(htmlspecialchars($this->reglamento_aplicado->Text));		
			
			$this->agregar_mensajes_unicode($datosTipificacion->save(),'Agregar tipificación',true);				
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