<?php 
/* 
 * Generado por el Ingeniero: 
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_trimestre extends TPage
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
			
			$datosTrimestre = new TrimestresRecord();
			
			$datosTrimestre->nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->nombre->Text),MB_CASE_TITLE,"UTF-8"));
			$datosTrimestre->fecha_inicial = htmlspecialchars($this->fecha_inicial->getDate());
			$datosTrimestre->fecha_final   = htmlspecialchars($this->fecha_final->getDate());
			$datosTrimestre->estado =TPropertyValue::ensureInteger(htmlspecialchars($this->estado->getSelectedValue()));
			
			$this->agregar_mensajes_unicode($datosTrimestre->save(),'Agregar trimestre',true);			
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