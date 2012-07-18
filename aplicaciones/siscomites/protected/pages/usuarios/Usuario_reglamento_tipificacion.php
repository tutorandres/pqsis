<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*'); 


class Usuario_reglamento_tipificacion extends TPage
{

		   
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Reglamento Tipificaciones";		
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
		$this->dl_tipificacion->DataSource=$this->Tipificaciones;
        $this->dl_tipificacion->dataBind();
					
	}	
	  
	  
	    public function getTipificaciones()
		{   
			$result = Null;
			
			
			//CONTRUIR EL ARRAY DE TIPIFICACIONES 
			$result = TipificacionesRecord::finder()->findAll();
			$contador = 1;
			
			if(count($result))
			{
				foreach ($result as $tipificacion) {
								  
						   $tipificaciones[] = array( 'numero' => $contador, 
													  'nombre' => $tipificacion->nombre,
													  'tipo' => $tipificacion->tipo_falta,
													  'nivel' => $tipificacion->nivel,
													  'reglamento' => $tipificacion->reglamento_aplicado
													);
				
				$contador = $contador + 1;
				 
				}
			}
			else
			{
				$this->agregar_mensajes_unicode(true,'Ninguna tipificación encontrada',false);
				$this->dl_tipificacion->items->clear();	
				$tipificaciones = Null;
			}	
				
		
			return $tipificaciones;	
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