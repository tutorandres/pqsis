<?php
/* 
 * Generado por el Ingeniero:
 * Andr?Augusto Garc?Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


class Editar_asistente_acta extends TPage
{
   
    
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Modificar asistencia";		
    } 
   
       
	public function onLoad($param)
    {
        parent::onLoad($param);
		
		   if(!$this->getPage()->getIsPostBack())
		   {

				$asistentes = AsistentesRecord::finder()->findByPk(array($this->request['id']));
				
				if(count($asistentes))
				{
					$this->asistente_id->Text = $asistentes->id;
					$this->nombre->Text = $asistentes->nombre;
					$this->rol->Text = $asistentes->rol;
					$this->entidad->Text = $asistentes->entidad;
					$this->numero->Text = $asistentes->numero;
					$this->correo->Text = $asistentes->correo;			
					$this->asistio->SelectedValue = $asistentes->asistio;			
				}
				else
				   $this->agregar_mensajes_unicode(true,'No se encontraron asistentes para este comite.',false);	
         }				  
	}
	
	
	
	public function guardar($sender,$param)
    {
	    $this->mensajes->Text = '';
		$this->alertas->Text = '';
	
		$datosAsistentes = AsistentesRecord::finder()->findByPk($this->asistente_id->Text);
		
		$datosAsistentes->id 	  = $this->asistente_id->Text;
     	$datosAsistentes->nombre  = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->nombre->Text),MB_CASE_TITLE,"UTF-8"));
        $datosAsistentes->rol 	  = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->rol->Text),MB_CASE_TITLE,"UTF-8"));
		$datosAsistentes->entidad = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->entidad->Text),MB_CASE_TITLE,"UTF-8"));
		$datosAsistentes->numero  = htmlspecialchars($this->numero->Text);
		$datosAsistentes->correo  = htmlspecialchars($this->correo->Text);			
		$datosAsistentes->asistio = htmlspecialchars($this->asistio->getSelectedValue());
		
		$this->agregar_mensajes_unicode($datosAsistentes->save(),'Editar asistente',false);   	
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