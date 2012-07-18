<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


class Compartir_info extends TPage
{
   
   
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Informaci&oacute;n Compartida";		
    } 
       
	public function onLoad($param)
    {
        parent::onLoad($param);
				
		if(!$this->getPage()->getIsPostBack())
        {		
		    $this->recargar();
		}
	}
	
	public function recargar()
    {
		$programa = ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);
		$this->info->Text = $programa->informacion;
	}			  
	
	
	public function guardar($sender,$param)
    {
	    $this->mensajes->Text = '';
		$this->alertas->Text = '';
	
		$programa = ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);
		$programa->informacion = TPropertyValue::ensureString($this->info->Text);
		$this->agregar_mensajes_unicode($programa->save(),'Informaci�n guardada',false); 
		
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