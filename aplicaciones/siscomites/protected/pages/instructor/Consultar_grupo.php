<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Consultar_grupo extends TPage
{

    var $total_registros;
	

    public function onLoad($param)
    {
        parent::onLoad($param);

        if(!$this->IsPostBack)
        {
		   
            $casos = Null;
			
			$default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue(' ');
						
			$criteria = new TActiveRecordCriteria;
		    $criteria->OrdersBy['codigo'] = 'desc';
		    $criteria->Condition = 'estado=1 AND programa_id = :programa';
			$criteria->Parameters[':programa'] = htmlspecialchars($this->Application->User->Roles[1]);
			
			$result = GruposRecord::finder()->findAll($criteria); 
		
			if(count($result))
			{
				foreach ($result as $caso) {
				
				   $titulacion  = $caso->titulacion;
	
				   $casos[] = array('id' => $caso->id,
									'nombre' => $caso->codigo . ' ' . $titulacion->nombre);
				}
			}
		    
			$this->grupos->items->clear();
			$this->grupos->DataSource=$casos;
			$this->grupos->DataTextField='nombre';
            $this->grupos->DataValueField='id';
            $this->grupos->dataBind();
            $this->grupos->items->insertAt(0,$default);
			   
		}	

			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
        
		
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
    }	
	
	
	
	
	public function busqueda($sender, $param)
	{
	     	$this->DataList->DataSource=$this->Data;			
			//$this->DataList->dataBind();			
		
			if($this->total_registros > 0)
			{
				$this->DataList->CurrentPageIndex=0;
				$this->populateData();
				$this->DataPanel->render($param->NewWriter);	
			}
			else
			{
			   $this->DataList->items->clear();
			   $this->Pager->Visible = false;
			   $this->paginacion->Visible = false;
			   $this->DataPanel->render($param->NewWriter);
			   $this->agregar_mensajes_unicode(true,'Ningún caso o informe encontrado',false);
			}   
        
	}
	
	

 	public function getData($limit = 0)
    {	
		$grupo_id = htmlspecialchars($this->grupos->Text);
		
		$casos   = Null;
		$result  = Null;
		$result2 = Null;
		$this->total_registros = 0;
		
		$this->mensajes->Text = '';
		$this->alertas->Text = '';
		
		$this->Pager->Visible = true;
		$this->paginacion->Visible = true;
		
		$criteria = new TActiveRecordCriteria;
		$criteria->OrdersBy['fecha'] = 'desc';
		$criteria->Condition = 'grupo_id = :grupo_id';
		$criteria->Parameters[':grupo_id'] = $grupo_id;
		
		
		if($limit > 0)
		{
			$limit  = 'LIMIT ' .  $limit;
		    $criteria->Limit = TPropertyValue::ensureInteger($limit);
		}
		else
         	$limit  = ' ';	
		
		
		$result = 	CasosRecord::finder()->findAllBySql('
					SELECT casos.id, fecha, tipificaciones, casos.estado, aprendiz_id, grupo_id, quejoso_id
					FROM `casos` 
					INNER JOIN `grupos` ON casos.grupo_id = grupos.id
					INNER JOIN `aprendices` ON casos.aprendiz_id = aprendices.id
					INNER JOIN `quejosos` ON casos.quejoso_id = quejosos.id
					WHERE grupos.estado=1 AND grupos.id=' . $grupo_id . ' 
					ORDER BY fecha ' . $limit);	
		
		
		//Prado::log(var_export($grupo_id, true),TLogger::ERROR,'ANDRES');
		
		//CASOS CASOS CASOS CASOS CASOS CASOS CASOS 
		
		if(count($result))
		{
			foreach ($result as $caso) 
			{
				  $grupo 		= 	$caso->grupo;
				  $quejoso 		= 	$caso->quejoso;
				  $aprendiz 	= 	$caso->aprendiz;
				  
				  $tipificaciones = unserialize($caso->tipificaciones);
				  $nombres = Null;
				  
				  foreach ($tipificaciones as $item)
				  {
					  $result = TipificacionesRecord::finder()->findByPk($item);
					  $nombres[] = $result->nombre;  
				  }
				  
				 
				  $titulacion  = $grupo->titulacion;
				  
				  				  
				  //ESTABLECER EL ESTADO DEL CASO ENVIADO
				  $programaciones = ProgramacionesRecord::finder()->findAll('caso = ?', array($caso->id));
				  
				  if(count($programaciones))
				  {
					  $sesion  = $programaciones[0]->sesion;
					  $proceso = ProcesosRecord::finder()->findAll('programacion_id = ?', array($programaciones[0]->id));
					  
					  if(count($proceso))
					  {
						$decision = DecisionesRecord::finder()->findByPk($proceso[0]->id);
						
						if(count($decision))
						{
							$sancion        = $decision->sancion;
						    $sancion_nombre = $sancion->nombre; 
						}
						else
						    $sancion_nombre  = 'Ninguna';
						
						$estado   = 'Ejecutado: ' . $sesion->fecha . ' Recomendaci&oacute;n: ' . $sancion_nombre . ' Segun Acta:  ' . $proceso[0]->acta_id;			
					  }	
					  else
						 $estado = 'Programado: ' . $sesion->fecha . ' Hora: ' . $programaciones[0]->hora;					  
				  }
				  else
				      $estado = 'Pendiente';
				  
				  

				  $casos[] = array('fecha' 		  => $caso->fecha, 
								   'aprendiz' 	  => $aprendiz->nombre,
								   'tipificacion' => implode(", ", $nombres),
								   'quejoso' 	  => $quejoso->nombre,
								   'estado' 	  => $estado); 
			}  
		}

			
		//INFORMES INFORMES INFORMES INFORMES INFORMES INFORMES 
		$result2 = 	InformesRecord::finder()->findAll($criteria);
		
		if(count($result2))
		{
			foreach ($result2 as $informe) 
			{
				  //ESTABLECER EL ESTADO DEL INFORME ENVIADO
				  $programaciones = ProgramacionesRecord::finder()->findAll('informe = ?', array($informe->id));
				  if(count($programaciones))
				  {
					  $sesion = $programaciones[0]->sesion;

				 				  
				      $proceso = ProcesosRecord::finder()->findAll('tipo="informe" AND codigo = ?', array($informe->id));
					  
					  if(count($proceso))
					     $estado = 'Ejecutado: ' . $sesion->fecha . ' Hora: ' . $programaciones[0]->hora . ' Segun Acta: ' . $proceso[0]->acta_id;
					  else     		  
					     $estado = 'Programado: ' . $sesion->fecha . ' Hora: ' . $programaciones[0]->hora;	
				   
				  }
				  else
				      $estado = 'Pendiente';
			

			
			
				  $casos[] = array('fecha'  	  => $informe->fecha, 
								   'aprendiz' 	  => 'Informe General', 
								   'tipificacion' => 'Informe General', 
								   'quejoso'      => $informe->nombre,
								   'estado' 	  => $estado); 
			}  
		}

		
		$this->total_registros = count($casos);
		return $casos;	
    }
		
		
		
	public function pageChanged($sender,$param)
    {
        $this->DataList->CurrentPageIndex=$param->NewPageIndex;
        $this->populateData();
		
		$this->mensajes->Text = '';
	    $this->alertas->Text = '';
		
		return 0;
    }
 
	protected function populateData()
    {
        $offset=$this->DataList->CurrentPageIndex*$this->DataList->PageSize;
        $limit=$this->DataList->PageSize;
		
        if($offset+$limit>$this->DataList->VirtualItemCount)
            $limit=$this->DataList->VirtualItemCount-$offset;
        $data=$this->getData($limit);
        $this->DataList->DataSource=$data;
        $this->DataList->dataBind();
		
		
		if(($offset+$this->DataList->PageSize) > $this->total_registros)
		  $this->paginacion->Text = '<br/>Mostrando del ' . ($offset+1) . ' al ' . ($offset + ($this->total_registros - $offset)) . ' de un total de ' . $this->total_registros . ' registros. ';	
		else
		  $this->paginacion->Text = '<br/>Mostrando del ' . ($offset+1) . ' al ' . ($offset+$this->DataList->PageSize) . ' de un total de ' . $this->total_registros . ' registros. ';	
	
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