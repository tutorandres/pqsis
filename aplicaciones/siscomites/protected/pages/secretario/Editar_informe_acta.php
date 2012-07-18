<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


class Editar_informe_acta extends TPage
{
   
    
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Modificar informe";		
    
	} 
   
       
	public function onLoad($param)
    {
        parent::onLoad($param);
		
		   if(!$this->getPage()->getIsPostBack())
		   {
				
				$informe = InformesRecord::finder()->findByPk(array($this->request['id']));
				
				if(count($informe))
				{
					$this->informe_id->Text					  = $informe->id;
					$this->nombre->Text 					  = $informe->nombre;
					$this->descripcion->Text 				  = $informe->descripcion;
					$this->identificacion->Text 			  = $informe->identificacion;
					$this->identificacion_tipo->SelectedValue = $informe->identificacion_tipo;
					$this->correo->Text 	 				  = $informe->correo;
					$this->fecha->Date 						  = $informe->fecha;					
				}
				else
				   $this->agregar_mensajes_unicode(true,'No se encontro informe para este comite.',false);	
         }				  
	}
	
	
	
	public function guardar($sender,$param)
    {
	    $this->mensajes->Text = '';
		$this->alertas->Text = '';
	
		$informe = InformesRecord::finder()->findByPk($this->informe_id->Text);
		
		$informe->id = $this->informe_id->Text;
		
		$informe->descripcion = TPropertyValue::ensureString(htmlspecialchars($this->descripcion->Text));
		$informe->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->nombre->Text),MB_CASE_TITLE,"UTF-8"));
		$informe->identificacion = TPropertyValue::ensureString(htmlspecialchars($this->identificacion->Text));		
		$informe->identificacion_tipo = TPropertyValue::ensureString(htmlspecialchars($this->identificacion_tipo->Text));
		$informe->correo = TPropertyValue::ensureString(htmlspecialchars($this->correo->Text));
		$informe->fecha = htmlspecialchars($this->fecha->getDate());
		
		$this->agregar_mensajes_unicode($informe->save(),'Editar informe',false);   	
		
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