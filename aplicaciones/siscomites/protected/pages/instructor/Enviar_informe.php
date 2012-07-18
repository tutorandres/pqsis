<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Enviar_informe extends TPage
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
			
		}
		 
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
		
    }

	



    public function prepararDatos($sender,$param)
    {
			
			$this->mensajes->Text = '';
			$this->alertas->Text = '';
			
			
			$InformesRecord = new InformesRecord();
			$InformesRecord->grupo_id = TPropertyValue::ensureString(htmlspecialchars($this->grupo_id->Text));
			$InformesRecord->descripcion = TPropertyValue::ensureString(htmlspecialchars($this->caso_descripcion->Text));
			$InformesRecord->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->quejoso_nombre->Text),MB_CASE_TITLE,"UTF-8"));
			$InformesRecord->identificacion = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_id->Text));
			$InformesRecord->identificacion_tipo = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_id_tipo->Text));
			$InformesRecord->correo = TPropertyValue::ensureString(htmlspecialchars($this->quejoso_correo->Text));
			$InformesRecord->estado = 1;

			$InformesRecord->fecha = date('Y-m-d');
			
			$this->agregar_mensajes_unicode($InformesRecord->save(),'Informe enviado correctamente',true);
	}
	
	



     public function cargar_grupos($sender,$param)
     {
            $default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue(' ');
			
			$result = Null;
			$casos  = Null;			
		    
			$criteria = new TActiveRecordCriteria;
		    $criteria->OrdersBy['codigo'] = 'desc';
		    $criteria->Condition = 'estado=1 AND programa_id = :programa';
			$criteria->Parameters[':programa'] = htmlspecialchars($this->programa_id->Text);
			
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
            $this->grupo_id->setEnabled(True);
			

       	$this->mensajes->Text = '';
		$this->alertas->Text = '';
			
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