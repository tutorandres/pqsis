<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


 
class Crud_caso extends TPage
{

    var $total_registros;
	
     
    public function onLoad($param)
    {
        parent::onLoad($param);
        if(!$this->IsPostBack)
        {
            $this->DataList->DataSource=$this->Data;
            $this->DataList->dataBind();	
		}
	
		$this->paginar();
		$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
	
	}						   

 
 
    public function getData($limit = 0)
    {   
		$casos = Null;
		$result = Null;
		
		//$this->grupo->items->clear();
		
		
		if($limit > 0)
			$limit  = 'LIMIT ' .  $limit;
		else
         	$limit  = ' ';	
		
		
		
		//CONTRUIR EL ARRAY DE TIPIFICACIONES 
		$result = TipificacionesRecord::finder()->findAll();
				   
		if(count($result))
        {
			foreach ($result as $tipificacion) {
							  
					   $tipificaciones[] = array( 'id' => $tipificacion->id, 
												  'nombre' => $tipificacion->nombre
									            );
			}
		}
		else
			$tipificaciones = Null;
			
			
		
		//Prado::log(var_export($tipificaciones, true),TLogger::ERROR,'ANDRES'); 

		//CONSTRIR EL ARRAY DE GRUPOS
		$criteria->OrdersBy['id'] = 'asc';
		$criteria->Condition = 'estado=1';
			   
		$result = GruposRecord::finder()->findAll($criteria);
			   
		if(count($result))
        {
			foreach ($result as $item) {
				$titulacion = $item->titulacion;        
				$grupos[] = array('id'      => $item->id,
								       'nombre' =>  $item->codigo . ' ' . $titulacion->nombre);
            }			   
		}
		else
			$grupos = Null;
		
		
        		
        $result = CasosRecord::finder()->findAllBySql('
				SELECT casos.id, fecha, tipificaciones, pruebas, descripcion, casos.estado, aprendiz_id, grupo_id, quejoso_id
				FROM `casos` 
				INNER JOIN `grupos` ON casos.grupo_id = grupos.id
				INNER JOIN `aprendices` ON casos.aprendiz_id = aprendices.id
				INNER JOIN `quejosos` ON casos.quejoso_id = quejosos.id
				WHERE casos.estado=1 AND grupos.programa_id=' . $this->Application->User->Roles[1] . ' 
				ORDER BY grupo_id, fecha ' . $limit);	 

		

		
		
		if(count($result))
		{
			foreach ($result as $caso) 
			{
				  $grupo 		= 	$caso->grupo;
				  $quejoso 		= 	$caso->quejoso;
				  $aprendiz 	= 	$caso->aprendiz;
				  $titulacion  =    $grupo->titulacion;
		
				
				  $casos[] = array('id' 			 		 => $caso->id,
								'pruebas' 		 		 => $caso->pruebas,
								'descripcion' 	 		 => $caso->descripcion,
								'tipificacion_select' 	 => unserialize($caso->tipificaciones),
								'tipificaciones'    	 => $tipificaciones,
								'fecha' 		 		 => $caso->fecha,
			   
			                    'grupo_id' 		         => $caso->grupo_id,
								'grupo_nombre'           => $titulacion->nombre,
								'grupo_codigo'           => $grupo->codigo,
								'grupos'          		 => $grupos,
								
								'quejoso_id' 		 	 => $quejoso->id,
								'quejoso_identificacion' => $quejoso->identificacion,
								'quejoso_nombre' 		 => $quejoso->nombre,
								'quejoso_correo' 		 => $quejoso->correo,
								'quejoso_id_tipo' 		 => $quejoso->id_tipo,
								
								'aprendiz_id' 		 	 => $aprendiz->id,
								'aprendiz_identificacion'=> $aprendiz->identificacion,
								'aprendiz_nombre' 		 => $aprendiz->nombre,
								'aprendiz_correo' 		 => $aprendiz->correo,
								'aprendiz_id_tipo' 		 => $aprendiz->id_tipo); 
				  				  
			}
			
			
			$this->Pager->Visible = true; 
			
		}	
		else
		{
			$this->agregar_mensajes_unicode(true,'Ningún registro encontrado',false);
			$this->DataList->items->clear();
			$this->Pager->Visible = false;			
		}

			
		$this->total_registros = count($casos);
		
		return $casos;	
		
				

    }
 
     
	public function editItem($sender,$param)
    {
        $this->DataList->SelectedItemIndex=-1;
        $this->DataList->EditItemIndex=$param->Item->ItemIndex;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		$this->mensajes->Text = '';
	    $this->alertas->Text = '';
		
		$this->paginar();
    }
 
	 
	public function cancelItem($sender,$param)
    {
        $this->DataList->SelectedItemIndex=-1;
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		$this->mensajes->Text = '';
	   $this->alertas->Text = '';
		
		$this->paginar();
    }
 
	 
	 
	 
	public function deleteItem($sender,$param)
    {
		$this->mensajes->Text = '';
	    $this->alertas->Text = '';
		
		
		try {
				
	    $caso = CasosRecord::finder()->findByPk($this->DataList->DataKeys[$param->Item->ItemIndex]); 

		if(CasosRecord::finder()->deleteByPk($this->DataList->DataKeys[$param->Item->ItemIndex]))
        {
			$this->agregar_mensajes_unicode(true,'Eliminar caso',true);
			
			if(AprendicesRecord::finder()->deleteByPk($caso->aprendiz_id))
					$this->agregar_mensajes_unicode(true,'Eliminar aprendiz',false);
			else
			        $this->agregar_mensajes_unicode(false,'Eliminar aprendiz',false);
			
			if(QuejososRecord::finder()->deleteByPk($caso->quejoso_id))
					$this->agregar_mensajes_unicode(true,'Eliminar quejoso',false);
		    else
			        $this->agregar_mensajes_unicode(false,'Eliminar quejoso',false);
			
		}
		else 
             $this->agregar_mensajes_unicode(false,'Eliminar caso',true);
		
		
		
		 } catch (Exception $e) {
                
				$this->agregar_mensajes_unicode(false,'Compruebe que el caso que intenta eliminar
				no se encuentra programado. Deberá eliminar las programaciones primero',false);	
         }	
		
		
		$this->DataList->SelectedItemIndex=-1;
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		$this->paginar();
		
    }
	
	
	
	
	public function updateItem($sender,$param)
    {
        $item=$param->Item;

		
		//ACTUALIZAMOS DATOS DEL CASO
		$CasosRecord = CasosRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
				
		$CasosRecord->descripcion = TPropertyValue::ensureString(htmlspecialchars($item->descripcion->Text));
		$CasosRecord->pruebas = TPropertyValue::ensureString(htmlspecialchars($item->pruebas->Text));
		$CasosRecord->tipificaciones = serialize($item->tipificaciones->getSelectedValues());
		$CasosRecord->grupo_id = TPropertyValue::ensureString(htmlspecialchars($item->grupo->Text));	
		$CasosRecord->fecha = htmlspecialchars($item->fecha->getDate());
		
		$this->agregar_mensajes_unicode($CasosRecord->save(),'Editar caso',true);
		
		
	
		//ACTUALIZAMOS DATOS DEL APRENDIZ
		$AprendicesRecord = $CasosRecord->aprendiz;
		$AprendicesRecord->identificacion = TPropertyValue::ensureString(htmlspecialchars($item->aprendiz_identificacion->Text));
		$AprendicesRecord->nombre =  TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->aprendiz_nombre->Text),MB_CASE_TITLE,"UTF-8"));
		$AprendicesRecord->correo =  TPropertyValue::ensureString(htmlspecialchars($item->aprendiz_correo->Text));
		$AprendicesRecord->id_tipo = TPropertyValue::ensureString(htmlspecialchars($item->aprendiz_id_tipo->Text));
		
		$this->agregar_mensajes_unicode($AprendicesRecord->save(),'Editar aprendiz',false);
		
			
		
		//ACTUALIZAMOS DATOS DEL QUEJOSO
		$QuejososRecord = $CasosRecord->quejoso;
		$QuejososRecord->identificacion = TPropertyValue::ensureString(htmlspecialchars($item->quejoso_identificacion->Text));
		$QuejososRecord->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->quejoso_nombre->Text),MB_CASE_TITLE,"UTF-8"));
		$QuejososRecord->correo = TPropertyValue::ensureString(htmlspecialchars($item->quejoso_correo->Text));
		$QuejososRecord->id_tipo = TPropertyValue::ensureString(htmlspecialchars($item->quejoso_id_tipo->Text));
		
		$this->agregar_mensajes_unicode($QuejososRecord->save(),'Editar quejoso',false);
		
				
		
		
		$this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		$this->paginar();
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
		
		$this->paginar($offset);
	}


	 	protected function paginar($offset = 0)
		{
			
		  if($this->total_registros > 0)
			{
				if(($offset+$this->DataList->PageSize) > $this->total_registros)
				  $this->paginacion->Text = 'Mostrando del ' . ($offset+1) . ' al ' . ($offset + ($this->total_registros - $offset)) . ' de un total de ' . $this->total_registros . ' registros.';	
				else
				  $this->paginacion->Text = 'Mostrando del ' . ($offset+1) . ' al ' . ($offset+$this->DataList->PageSize) . ' de un total de ' . $this->total_registros . ' registros.';	
			}
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