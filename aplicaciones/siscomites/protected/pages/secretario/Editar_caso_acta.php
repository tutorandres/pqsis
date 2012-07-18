<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


class Editar_caso_acta extends TPage
{   
   
    
    public function onPreInit($param){
        $this->MasterClass="Application.layouts.MainLayout";
		$this->Title="Modificar caso";		
    } 
   
       
	public function onLoad($param)
    {
        parent::onLoad($param);
		

		       
		if(!$this->getPage()->getIsPostBack())
		{
								
				$caso = CasosRecord::finder()->findByPk(array(htmlspecialchars($this->request['id'])));
				
				if(count($caso))
				{
					//CONTRUIR EL ARRAY DE TIPIFICACIONES 
					$result = TipificacionesRecord::finder()->findAll();
									   
							if(count($result))
							{
								foreach ($result as $tipificacion) 
								{
												  
										   $tipificaciones[] = array( 'id' => $tipificacion->id, 
																	  'nombre' => $tipificacion->nombre
																	);
								}
							}
							else
								$tipificaciones = Null;
				
				
					$quejoso 	= 	$caso->quejoso;
				    $aprendiz 	= 	$caso->aprendiz;
					
					
					$this->caso_id->Text	  			  = $caso->id;
					$this->pruebas->Text 	  			  = $caso->pruebas;
					$this->descripcion->Text  			  = $caso->descripcion;
					$this->fecha->Date 		  			  = $caso->fecha;	
					
					
					$this->tipificaciones->DataSource 	  = $tipificaciones;
					$this->tipificaciones->SelectedValues = unserialize($caso->tipificaciones);						
					$this->tipificaciones->dataBind();

					
					$this->quejoso_nombre->Text 		  = $quejoso->nombre;
					$this->quejoso_identificacion->Text   = $quejoso->identificacion;
					$this->quejoso_id_tipo->Text 		  = $quejoso->id_tipo;
					$this->quejoso_correo->Text 		  = $quejoso->correo;
					
					$this->aprendiz_nombre->Text 		  = $aprendiz->nombre;
					$this->aprendiz_identificacion->Text  = $aprendiz->identificacion;
					$this->aprendiz_id_tipo->Text 		  = $aprendiz->id_tipo;
					$this->aprendiz_correo->Text 		  = $aprendiz->correo;

					
				}
				else
				   $this->agregar_mensajes_unicode(true,'No se encontro el caso para este comite.',false);	
         }		  
	}
	
	
	
	
	
	
	public function guardar($sender,$param)
    {
		$this->mensajes->Text = '';
		$this->alertas->Text = '';
	
		$caso = CasosRecord::finder()->findByPk($this->caso_id->Text);		
		$caso->descripcion = TPropertyValue::ensureString(htmlspecialchars($this->descripcion->Text));
		$caso->pruebas = TPropertyValue::ensureString(htmlspecialchars($this->pruebas->Text));
		$caso->tipificaciones = serialize($this->tipificaciones->getSelectedValues());
		$caso->fecha = htmlspecialchars($this->fecha->getDate());
		$this->agregar_mensajes_unicode($caso->save(),'Editar caso',false);
		
		
 		//ACTUALIZAMOS DATOS DEL APRENDIZ
		$aprendiz = $caso->aprendiz;
		$aprendiz->identificacion = TPropertyValue::ensureString(htmlspecialchars($this->aprendiz_identificacion->Text));
		$aprendiz->nombre =  TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->aprendiz_nombre->Text),MB_CASE_TITLE,"UTF-8"));
		$aprendiz->correo =  TPropertyValue::ensureString(htmlspecialchars($this->aprendiz_correo->Text));
		$aprendiz->id_tipo = TPropertyValue::ensureString(htmlspecialchars($this->aprendiz_id_tipo->Text));
		$this->agregar_mensajes_unicode($aprendiz->save(),'Editar aprendiz',false);
		
		
		//ACTUALIZAMOS DATOS DEL QUEJOSO
		$quejoso = $caso->quejoso;
		$quejoso->identificacion = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_identificacion->Text));
		$quejoso->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->quejoso_nombre->Text),MB_CASE_TITLE,"UTF-8"));
		$quejoso->correo = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_correo->Text));
		$quejoso->id_tipo = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_id_tipo->Text));
		$this->agregar_mensajes_unicode($quejoso->save(),'Editar quejoso',false); 
		
		
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