<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');
Prado::using('Application.libraries.funciones');

 
class Casos_pendientes extends TPage
{
        
    public function onLoad($param)
    {
        parent::onLoad($param);
        if(!$this->IsPostBack)
        {
            $this->DataList->DataSource=$this->Data;
            $this->DataList->dataBind();	
		}
	
	
			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
	}						   

 
 
    public function getData()
    {   
		$casos    = Null;
		$procesos = Null;
	
		//$procesos = ProcesosRecord::finder()->findAll('estado = ? OR estado = ?', array(2,3));
							
		$procesos = ProcesosRecord::finder()->findAllBySql('							
					SELECT procesos.id, programacion_id, codigo
					FROM `procesos`
					INNER JOIN `programaciones` ON procesos.programacion_id = programaciones.id		
					INNER JOIN `sesiones` ON programaciones.sesion_id = sesiones.id	
					WHERE procesos.estado = 3 AND sesiones.programa_id=' .
					$this->Application->User->Roles[1]);
		 
		//Prado::log(var_export($procesos2, true),TLogger::ERROR,'ANDRES');
												  
		if(count($procesos))
		{
			foreach ($procesos as $item) 
			{

			   $caso         = CasosRecord::finder()->findByPk($item->codigo);
			   $grupo 	     = $caso->grupo;
			   $aprendiz     = $caso->aprendiz;
			   $titulacion   = $grupo->titulacion;
			   $decision     = DecisionesRecord::finder()->findByPk($item->id);
			   $programacion = ProgramacionesRecord::finder()->findByPk($item->programacion_id);
			   $sesion       = $programacion->sesion;
			   		
			    			   
			   //le sumo los tres meses maximos
			   $fec_vencimi = date("Y-m-d", strtotime("$sesion->fecha + 90 days"));			   
			   $fec_hoy     = date("Y-m-d");
			   $fec_dias    = restaFechas($fec_vencimi,$fec_hoy);
			   
				
			   $casos[] = array('id' => $item->id,
								'grupo' => $titulacion->nombre .' '. $grupo->codigo,
								'aprendiz' => $aprendiz->nombre .' '. $aprendiz->identificacion,
								'responsable' => $decision->responsable,
								'fecha' => 'Comite: ' . $sesion->fecha . ' Limite: ' . $fec_vencimi,
								'dias' => $fec_dias . ' dias');
			}


		}
		else
		{
		   	$this->agregar_mensajes_unicode(true,'Ningún registro encontrado',false);
			$this->DataList->items->clear();
			$this->brecordar->setenabled(false); 			
		}
		   
		
		return $casos;	
    }
 
 
 

 
	 
	 
	 
	public function deleteItem($sender,$param)
    {
	    $this->mensajes->Text = '';
	    $this->alertas->Text = '';
		
		$item=$param->Item;
		
		$datos = ProcesosRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
		
		//procesos con estado 102 y 103 significa que ya estan cerrados
		//osea ya se verifico que los instructores realizaran los planes
		//de mejoramiento ?.
		$datos->estado = $datos->estado + 100;
		$this->agregar_mensajes_unicode($datos->save(),'Cerrar caso',true);  
		 
		$this->DataList->SelectedItemIndex=-1;
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
    }
	
	
	
	
	public function updateItem($sender,$param)
    {
		$this->mensajes->Text = '';
		$this->alertas->Text  = '';
		
		$item=$param->Item;
		
		$proceso 	= ProcesosRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
		$decision   = DecisionesRecord::finder()->findByPk($proceso->id);
		$caso 		= CasosRecord::finder()->findByPk($proceso->codigo);
		$grupo 		= $caso->grupo;
		$titulacion = $grupo->titulacion;
		
		$aprendiz 		= $caso->aprendiz;
		$quejoso 		= $caso->quejoso;
		$programacion 	= $proceso->programacion;
		$sesion 		= $programacion->sesion;
	
		$correos = '"' . utf8_decode($quejoso->nombre) . '" <' . $quejoso->correo . '>,';
				
		$nombreArchivo = do_generar_nombre_archivo($grupo->codigo . "_recordatorio_") . 'doc';
		$plantilla = file_get_contents('doc_guias/recordatorio_plan.rtf');	
		
		
		//REMPLAZOS COMUNES
		$plantilla = str_replace('#correos#',$correos,$plantilla);
		$plantilla = str_replace('#responsable#',utf8_decode($decision->responsable),$plantilla);
		$plantilla = str_replace('#cofecha#',utf8_decode($sesion->fecha),$plantilla);
		$plantilla = str_replace('#grupo#',utf8_decode($titulacion->nombre) .' '. $grupo->codigo,$plantilla);
		$plantilla = str_replace('#aprendiz#',utf8_decode($aprendiz->nombre) .' '. $aprendiz->id_tipo .' '. $aprendiz->identificacion,$plantilla);
		$plantilla = str_replace('#lifecha#',date("Y-m-d", strtotime("$sesion->fecha + 90 days")),$plantilla);

		
	
		
		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO
		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 
		if(!is_dir($nombre_carpeta)){ 
		  mkdir($nombre_carpeta, 0755); 
		}
		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);
		descargar($nombre_carpeta,$nombreArchivo);
		//eliminar_archivo($nombreArchivo);
		
		
		
			
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		return false;
		
    }
	
	
	
	
	
	
	public function recordar()
    {
		$this->mensajes->Text = '';
		$this->alertas->Text  = '';
		
		$correos = Null;
		$datos   = Null;
		
		
		$procesos = ProcesosRecord::finder()->findAllBySql('							
					SELECT procesos.id, programacion_id, codigo
					FROM `procesos`
					INNER JOIN `programaciones` ON procesos.programacion_id = programaciones.id		
					INNER JOIN `sesiones` ON programaciones.sesion_id = sesiones.id	
					WHERE procesos.estado = 3 AND sesiones.programa_id=' .
					$this->Application->User->Roles[1]);
		
		
		if(count($procesos))
		{
			foreach ($procesos as $item) 
			{

			   $caso         = CasosRecord::finder()->findByPk($item->codigo);
			   $grupo 	     = $caso->grupo;
			   $aprendiz     = $caso->aprendiz;
			   $quejoso 	 = $caso->quejoso;
			   $titulacion   = $grupo->titulacion;
			   $decision     = DecisionesRecord::finder()->findByPk($item->id);
			   $programacion = ProgramacionesRecord::finder()->findByPk($item->programacion_id);
			   $sesion       = $programacion->sesion;
			   		
			    			   
			   //le sumo los tres meses maximos
			   $fec_vencimi = date("Y-m-d", strtotime("$sesion->fecha + 90 days"));			   
			   $fec_hoy     = date("Y-m-d");
			   $fec_dias    = restaFechas($fec_vencimi,$fec_hoy);
			   
			   
			   	//PARA QUE NO INGRESEN CORREOS DUPLICADOS
				$pos = strpos($correos, $quejoso->correo);
				if ($pos === false)
						$correos = $correos . '"' . utf8_decode($quejoso->nombre) . '" <' . $quejoso->correo . '>,';
			   
				
				$datos = $datos . '\clbrdrl\brdrw10\brdrs\brdrcf4\clbrdrt\brdrw10\brdrs\brdrcf4\clbrdrr\brdrw10\brdrs\brdrcf4\clbrdrb\brdrw10\brdrs\brdrcf4 \cellx1690\clbrdrl\brdrw10\brdrs\brdrcf4\clbrdrt\brdrw10\brdrs\brdrcf4\clbrdrr\brdrw10\brdrs\brdrcf4\clbrdrb\brdrw10\brdrs\brdrcf4 \cellx3686\clbrdrl\brdrw10\brdrs\brdrcf4\clbrdrt\brdrw10\brdrs\brdrcf4\clbrdrr\brdrw10\brdrs\brdrcf4\clbrdrb\brdrw10\brdrs\brdrcf4 \cellx5884\clbrdrl\brdrw10\brdrs\brdrcf4\clbrdrt\brdrw10\brdrs\brdrcf4\clbrdrr\brdrw10\brdrs\brdrcf4\clbrdrb\brdrw10\brdrs\brdrcf4 \cellx7513\clbrdrl\brdrw10\brdrs\brdrcf4\clbrdrt\brdrw10\brdrs\brdrcf4\clbrdrr\brdrw10\brdrs\brdrcf4\clbrdrb\brdrw10\brdrs\brdrcf4 \cellx8931\pard\intbl\nowidctlpar '.$titulacion->nombre.' '.$grupo->codigo.'\cell '.$aprendiz->nombre.' '.$aprendiz->identificacion.'\cell '.$decision->responsable.'\cell Comite: '.$sesion->fecha.' Limite: '.$fec_vencimi.'\cell '.$fec_dias . ' dias\cell\row\trowd\trgaph70\trrh376\trbrdrl\brdrs\brdrw10\brdrcf4 \trbrdrt\brdrs\brdrw10\brdrcf4 \trbrdrr\brdrs\brdrw10\brdrcf4 \trbrdrb\brdrs\brdrw10\brdrcf4 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3';
				
				
			}
		}
		
		
		
		
				
		$nombreArchivo = do_generar_nombre_archivo($grupo->codigo . "_recordatorio_todos_") . 'doc';
		$plantilla = file_get_contents('doc_guias/recordatorio_planes.rtf');	
		
		
		//REMPLAZOS COMUNES
		$plantilla = str_replace('#correos#',$correos,$plantilla);
		$plantilla = str_replace('#res#',utf8_decode($datos),$plantilla);
		//$plantilla = str_replace('#cofecha#',utf8_decode($sesion->fecha),$plantilla);
		//$plantilla = str_replace('#grupo#',utf8_decode($titulacion->nombre) .' '. $grupo->codigo,$plantilla);
		//$plantilla = str_replace('#aprendiz#',utf8_decode($aprendiz->nombre) .' '. $aprendiz->id_tipo .' '. $aprendiz->identificacion,$plantilla);
		//$plantilla = str_replace('#lifecha#',date("Y-m-d", strtotime("$sesion->fecha + 90 days")),$plantilla);

		
		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO
		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 
		if(!is_dir($nombre_carpeta)){ 
		  mkdir($nombre_carpeta, 0755); 
		}
		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);
		descargar($nombre_carpeta,$nombreArchivo);
		//eliminar_archivo($nombreArchivo);
		
			
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		return false;
				
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