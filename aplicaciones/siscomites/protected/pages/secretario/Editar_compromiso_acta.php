<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


class Editar_compromiso_acta extends TPage
{
   
    
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Modificar compromiso";		
    } 
   
       
	public function onLoad($param)
    {
        parent::onLoad($param);
		
		   if(!$this->getPage()->getIsPostBack())
		   {
				
				$compromisos = CompromisosRecord::finder()->findByPk(array($this->request['id']));
				
				if(count($compromisos))
				{
					$this->compromiso_id->Text 	= $compromisos->id;
					$this->responsables->Text 	= $compromisos->responsables;
					$this->descripcion->Text 	= $compromisos->descripcion;
					$this->fecha->Date 			= $compromisos->fecha;					
				}
				else
				   $this->agregar_mensajes_unicode(true,'No se encontraron compromisos para este comite.',false);	
         }				  
	}
	
	
	
	public function guardar($sender,$param)
    {
			$this->mensajes->Text = '';
			$this->alertas->Text = '';
		
			$compromiso = CompromisosRecord::finder()->findByPk($this->compromiso_id->Text);
			
			$compromiso->id = $this->compromiso_id->Text;
			$compromiso->responsables = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->responsables->Text),MB_CASE_TITLE,"UTF-8"));
			$compromiso->descripcion = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->descripcion->Text),MB_CASE_TITLE,"UTF-8"));
			$compromiso->fecha = htmlspecialchars($this->fecha->getDate());
			
			$this->agregar_mensajes_unicode($compromiso->save(),'Editar compromiso',false);	
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