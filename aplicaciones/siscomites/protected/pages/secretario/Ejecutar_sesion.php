<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');
Prado::using('Application.libraries.funciones');



class Ejecutar_sesion extends TPage
{
   
       
    public function onLoad($param)
    {
        parent::onLoad($param);
        if(!$this->IsPostBack)
        {
			$default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue('0');
			
			$criteria = new TActiveRecordCriteria;
            $criteria->OrdersBy['nombre'] = 'asc';
            $finder = TrimestresRecord::finder();
            $this->trimestre_id->DataSource=$finder->findAll($criteria);
            $this->trimestre_id->DataTextField='nombre';
            $this->trimestre_id->DataValueField='id';
			$this->trimestre_id->dataBind();
			$this->trimestre_id->items->insertAt(0,$default);	   
		}	
		
				$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
	
	
	  	$this->DataList->items->clear();
	    $this->mensajes->Text = '';
	    $this->alertas->Text = '';
	}




    public function cargar_sesiones($sender,$param)
    {
			$default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue('0');
			
			$criteria = new TActiveRecordCriteria;
            $criteria->OrdersBy['fecha'] = 'asc';
			$criteria->Condition = 'trimestre_id = :trimestre AND estado=1 AND programa_id = :programa';
			$criteria->Parameters[':trimestre'] = htmlspecialchars($this->trimestre_id->Text);
			$criteria->Parameters[':programa']  = htmlspecialchars($this->Application->User->Roles[1]);
									
		    $datos = SesionesRecord::finder()->findAll($criteria);
			
			if(!count($datos))
			     $this->agregar_mensajes_unicode(true,'No se encontraron sesiones en el trimestre seleccionado',false);					
						
            $this->sesion_id->DataSource=$datos;
            $this->sesion_id->DataTextField='fecha';
            $this->sesion_id->DataValueField='id';
            $this->sesion_id->dataBind();
			$this->sesion_id->items->insertAt(0,$default);
			$this->sesion_id->Enabled = true;
			
			
			$this->bgenerar_resumen->Enabled = false;
			
			//$this->mensajes->Text = '';
			//$this->alertas->Text = '';
			$this->DataList->items->clear();
    } 	

	
	
	
	
	 public function cargar_programacion($sender=Null,$param=Null)
     {
            //PARA LA GRILLA DE DATOS

			$this->DataList->SelectedItemIndex=-1;
			$this->DataList->EditItemIndex=-1;
			$this->DataList->DataSource=$this->Data;
			$this->DataList->dataBind();						   
	 }
	
	
	
	
	
	public function getData()
    {   
		$casos = Null;
		$result = Null;
		$lista[] = -1;
					   
		$result = ProgramacionesRecord::finder()->findAllBySql('							
		SELECT programaciones.id, hora, caso, informe, grupo_id, sesion_id
		FROM `programaciones` 
		WHERE programaciones.sesion_id =' . htmlspecialchars($this->sesion_id->Text) . ' 
		ORDER BY hora');					   
    
	   //Prado::log(var_export(array_values($result), true),TLogger::ERROR,'ANDRES');	
	
		if(count($result))
		{
			foreach ($result as $item) 
			{ 
				    $grupo = $item->grupo;
					$titulacion  = $grupo->titulacion;

					$acta   = ActasRecord::finder()->findByPK($this->sesion_id->Text . '-' . $grupo->id);
					$estado = '';
					
					if(count($acta))
					{
					    if($acta->estado == 2)
							$estado='background-color:#F5A9A9;';							
					}

					if(!in_array($grupo->codigo, $lista))
					{
							 $casos[] = array('grupo_id' => $grupo->id,
							 'sesion_id' => htmlspecialchars($this->sesion_id->Text),
							 'grupo_codigo' => $grupo->codigo,
							 'hora' => DATE("H:i",STRTOTIME($item->hora)),
							 'estado' => $estado,
							 'grupo_nombre' => $titulacion->nombre);
	
					         $lista[] = $grupo->codigo;
				  }
			}

			$this->bgenerar_resumen->Enabled = true;
			
		}

        if($casos == Null)
		{
			$this->DataList->reset();
			$this->agregar_mensajes_unicode(true,'No hay programaciones en esta sesión o ninguna tiene casos o informes',false);	
		    $this->bgenerar_resumen->Enabled = false;
		}
		
		return $casos;	
    }
	
	
	
	
	
	
	
	public function generar_resumen($sender,$param)
    {
	
		$result = ProgramacionesRecord::finder()->findAllBySql('							
		SELECT programaciones.id, hora, caso, informe, grupo_id, sesion_id
		FROM `programaciones` 
		WHERE programaciones.sesion_id =' . htmlspecialchars($this->sesion_id->Text) . ' 
		ORDER BY hora');
	
	    	
		$sesion 		 = $result[0]->sesion;
		$comite_fecha 	 = fechalarga($sesion->fecha);
			
		$programa 		 = ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);
		$programa_nombre = utf8_decode($programa->nombre);
		

		$conta_llam = 0;
		$conta_con = 0;
		$conta_can = 0;
		$conta_casos = 0;
		$conta_informes = 0;
		$conta_compro = 0;
		$lista[] = -1;
		
		$compro = '';
		
		foreach ($result as $item) 
		{ 
			$grupo = $item->grupo;
			$titulacion  = $grupo->titulacion;

			if(!in_array($grupo->codigo, $lista))
			{
				$proceso = ProcesosRecord::finder()->findAll('acta_id = ?', $this->sesion_id->Text . '-' . $grupo->id);
				
				if(count($proceso))
				{
					foreach ($proceso as $item2) 
					{
										
				        if($item2->tipo == 'caso')
						{
							$caso  	  = CasosRecord::finder()->findByPk($item2->codigo);
							$aprendiz = $caso->aprendiz;
							$nombre_aprendiz = $aprendiz->nombre;
							
							$conta_casos = $conta_casos + 1;
						}
						else
						{
							$informe  =  InformesRecord::finder()->findByPk($item2->codigo);
							$nombre_aprendiz = $informe->nombre;
							
							$conta_informes = $conta_informes + 1;
						}
				
						$decision = DecisionesRecord::finder()->findByPK($item2->id);
						
						
				        if(count($decision))
						{
							$sancion = $decision->sancion;
							
						    if($decision->sancion_id == 2)
							{
								$conta_llam = $conta_llam + 1;
								$conta_compro = $conta_compro + 3;
						    }
							elseif($decision->sancion_id == 3) 
							{ 	
								$conta_con = $conta_con + 1;
								$conta_compro = $conta_compro + 3;
							}
							elseif($decision->sancion_id == 4) 
							{
							  $conta_can = $conta_can + 1;
							  $conta_compro = $conta_compro + 2;
						    }
						
											
							$compro = $compro . '\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx709\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx2835\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx4820\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx6804\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx8946\pard\intbl\nowidctlpar ' . $this->sesion_id->Text . '-' . $grupo->id . '\cell ' . $titulacion->nombre . ' ' . $grupo->codigo . '\cell ' . $aprendiz->nombre . '\cell ' . $decision->responsable . '\cell ' . $sancion->nombre . '\cell\row\trowd\trgaph70\trleft-284\trbrdrl\brdrs\brdrw10\brdrcf1 \trbrdrt\brdrs\brdrw10\brdrcf1 \trbrdrr\brdrs\brdrw10\brdrcf1 \trbrdrb\brdrs\brdrw10\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3';
						}	
					

						
					
					

					
					}		 
				}
				
				
				//COMPROMISOS EXTRAS
				$compromisos = CompromisosRecord::finder()->findAll('acta_id = ?', $this->sesion_id->Text . '-' . $grupo->id);
				
				if(count($compromisos))
				{
					foreach ($compromisos as $item3)
					{
						$conta_compro = $conta_compro + 1;
						
						$compro = $compro . '\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx709\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx2835\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx4820\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx6804\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx8946\pard\intbl\nowidctlpar ' . $item3->acta_id . '\cell ' . $titulacion->nombre . ' ' . $grupo->codigo . '\cell\cell ' . $item3->responsables . '\cell ' . $item3->descripcion . '\cell\row\trowd\trgaph70\trleft-284\trbrdrl\brdrs\brdrw10\brdrcf1 \trbrdrt\brdrs\brdrw10\brdrcf1 \trbrdrr\brdrs\brdrw10\brdrcf1 \trbrdrb\brdrs\brdrw10\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3';

					}
				}
				
				$lista[] = $grupo->codigo;
				
			}	
				
	
			
		}
		
		
		if($compro == '')
			$compro =  '\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx709\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx2835\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx4820\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx6804\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx8946\pard\intbl\nowidctlpar \cell Ninguna recomendaciÃ³n encontrada.\cell\cell\cell\cell\row\trowd\trgaph70\trleft-284\trbrdrl\brdrs\brdrw10\brdrcf1 \trbrdrt\brdrs\brdrw10\brdrcf1 \trbrdrr\brdrs\brdrw10\brdrcf1 \trbrdrb\brdrs\brdrw10\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3';

		
		$nombreArchivo = do_generar_nombre_archivo("resumen_") . 'doc';
		$plantilla     = file_get_contents('doc_guias/resumen.rtf');
		
		$plantilla = str_replace('#nomPro#',utf8_decode($programa_nombre),$plantilla);
		$plantilla = str_replace('#fecAct#',utf8_decode($comite_fecha),$plantilla);
		$plantilla = str_replace('#totCas#',$conta_casos,$plantilla);
		$plantilla = str_replace('#totInf#',$conta_informes,$plantilla);
		$plantilla = str_replace('#totCom#',$conta_compro,$plantilla);
		$plantilla = str_replace('#totLLam#',$conta_llam,$plantilla);
		$plantilla = str_replace('#totCon#',$conta_con,$plantilla);
		$plantilla = str_replace('#totCan#',$conta_can,$plantilla);
		
		
		$plantilla = str_replace('#res#',utf8_decode($compro),$plantilla);

		
		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO
		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 
		if(!is_dir($nombre_carpeta)){ 
		  mkdir($nombre_carpeta, 0755); 
		}
		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);
		descargar($nombre_carpeta,$nombreArchivo);
		//eliminar_archivo($nombreArchivo);
		

		$this->cargar_programacion();
		
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