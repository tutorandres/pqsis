<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*'); 


class Usuario_reglamento_sancion extends TPage
{

		   
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Reglamento Sanciones";		
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
					
		$this->dl_sancion->DataSource=$this->Reglamentos;
        $this->dl_sancion->dataBind();
	}	
	
	  
	  
	     
		public function getReglamentos()
		{   
			$result = Null;
			
			
			//CONTRUIR EL ARRAY DE TIPIFICACIONES 
			$result = ReglamentosRecord::finder()->findAll();
			$contador = 1;
			
			if(count($result))
			{
				foreach ($result as $reglamento) {
								  
						   $reglamentos[] = array( 'numero' => $contador, 
												 'nombre' => $reglamento->nombre,
											     'tipo'   => $reglamento->tipo,
												 'reglamento' => $reglamento->texto
												);
				
				$contador = $contador + 1;
				 
				}
			}
			else
			{
				$this->agregar_mensajes_unicode(true,'Ninguna sanción encontrada.',false);
				$this->dl_sancion->items->clear();	
				$reglamentos = Null;
			}	
				
		
			return $reglamentos;	
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