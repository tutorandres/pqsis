<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');




class Consultar_programacion extends TPage
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
	
		
		$this->mensajes->Text = '';
	    $this->alertas->Text = '';
	  	$this->DataList->items->clear();
	
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

				
				if($item->caso == 0)
				{
					$informe  =  InformesRecord::finder()->findByPk($item->informe);
				    $tipo     = 'Informe General de ' . $informe->nombre;
				}  
				else
				{
					$caso  	  = CasosRecord::finder()->findByPk($item->caso);
					$aprendiz = $caso->aprendiz;
					$tipo     = 'Caso de ' . $aprendiz->nombre; 
				}
				
				
				$casos[] = array('hora'         => DATE("H:i",STRTOTIME($item->hora)),
								 'grupo_codigo' => $grupo->codigo,
								 'grupo_nombre' => $titulacion->nombre,
						    	 'tipo'         => $tipo);
			}
		}

        if($casos == Null)
		{
			$this->DataList->reset();
			$this->agregar_mensajes_unicode(true,'No se encontraron casos o informes',false);	
		}
		
		
		return $casos;	
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