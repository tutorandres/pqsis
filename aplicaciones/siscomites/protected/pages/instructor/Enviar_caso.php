<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Enviar_caso extends TPage
{

    
    public function onLoad($param)
    {
        parent::onLoad($param);

        if(!$this->IsPostBack)
        {
			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
		
		
            $casos = Null;
			
			$default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue(' ');
						
			$criteria = new TActiveRecordCriteria;
		    $criteria->OrdersBy['codigo'] = 'desc';
		    $criteria->Condition = 'estado=1';
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
		    
			$this->grupo_id->items->clear();
			$this->grupo_id->DataSource=$casos;
			$this->grupo_id->DataTextField='nombre';
            $this->grupo_id->DataValueField='id';
            $this->grupo_id->dataBind();
            $this->grupo_id->items->insertAt(0,$default);

		
		    $this->checkbox->DataSource=$this->Tipificaciones;
            $this->checkbox->dataBind();
				
			//Prado::log(var_export($solo_letras, true),TLogger::ERROR,'ANDRES');				
			//$Response = $this->getResponse();
			//$Response->Redirect("index.php?page=casos.Enviar");
        }
		
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
    }

	



    public function prepararDatos($sender,$param)
    {
			
			$this->mensajes->Text = '';
			$this->alertas->Text = '';
			
			
			$AprendicesRecord = new AprendicesRecord();		
			$AprendicesRecord->identificacion = TPropertyValue::ensureString(htmlspecialchars($this->aprendiz_id->Text));
			$AprendicesRecord->nombre =  TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->aprendiz_nombre->Text),MB_CASE_TITLE,"UTF-8"));
			$AprendicesRecord->correo =  TPropertyValue::ensureString(htmlspecialchars($this->aprendiz_correo->Text));
			$AprendicesRecord->id_tipo = TPropertyValue::ensureString(htmlspecialchars($this->aprendiz_id_tipo->Text));
			
			if($AprendicesRecord->save())
			{

				$conexion = $AprendicesRecord->getDbConnection();
				$aprendiz_id = $conexion->getLastInsertID();	
				
				$QuejososRecord = new QuejososRecord();
				$QuejososRecord->identificacion = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_id->Text));
				$QuejososRecord->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->quejoso_nombre->Text),MB_CASE_TITLE,"UTF-8"));
				$QuejososRecord->correo = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_correo->Text));
				$QuejososRecord->id_tipo = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_id_tipo->Text));
				
			
			    if($QuejososRecord->save())
				{
					$conexion = $QuejososRecord->getDbConnection();
					$quejoso_id = $conexion->getLastInsertID();	
					
				
					$CasosRecord = new CasosRecord();
					$CasosRecord->descripcion = TPropertyValue::ensureString(htmlspecialchars($this->caso_descripcion->Text));
					$CasosRecord->pruebas = TPropertyValue::ensureString(htmlspecialchars($this->caso_pruebas->Text));
					$CasosRecord->tipificaciones = serialize($this->checkbox->getSelectedValues());
					$CasosRecord->grupo_id = TPropertyValue::ensureString(htmlspecialchars($this->grupo_id->Text));
					$CasosRecord->quejoso_id = $quejoso_id;
					$CasosRecord->aprendiz_id = $aprendiz_id;
					
					$CasosRecord->fecha = date('Y-m-d');
					
					/* 	Se va a manejar los siguientes codigos de seguiiento de casos: 
						1 - cuando el caso es creado, osea enviado.
						2 - cuando el caso es asignado o programado
						3 - cuando el caso queda abierto con un condicionamiento
							o cancelacion.
						4 - cuando el caso se ha cerrado.

								1 - ENVIADO
								2 - PROGRAMADO
								3 - ABIERTO
								4 - CERRADO
					*/
					
					$CasosRecord->estado = 1;
					$this->agregar_mensajes_unicode($CasosRecord->save(),'Caso enviado correctamente.',true);		
				
				}
				else
					$this->agregar_mensajes_unicode(false,'Ocurrio un error ingresando el quejoso',true);	
		 }
		 else
			$this->agregar_mensajes_unicode(false,'Ocurrio un error ingresando el aprendiz',true);	
	}
	
	

	 
	 
	 
	 
	public function getTipificaciones()
    {   
		$result = TipificacionesRecord::finder()->findAll();
		$tipificaciones = Null;
		
 		foreach ($result as $tipificacion) {
		  		  
           $tipificaciones[] = array( 'id' => $tipificacion->id, 
							          'nombre' => $tipificacion->nombre
						       );
		}  
		
		//Prado::log(var_export($result, true),TLogger::ERROR,'ANDRES');
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