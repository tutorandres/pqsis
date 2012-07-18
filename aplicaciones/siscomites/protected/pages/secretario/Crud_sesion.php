<?php
/* 
 * Generado por el Ingeniero:
 * Andr�s Augusto Garc�a Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


 
class Crud_sesion extends TPage
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

 
 
    public function getData($limit = Null)
    {   
		$casos  = Null;
		$result = Null;
	
		$criteria = new TActiveRecordCriteria;
		$criteria->OrdersBy['id'] = 'asc';
		
		if($limit)
			$criteria->Limit = TPropertyValue::ensureInteger($limit);
			
		$result = SesionesRecord::finder()->findAllByPrograma_id(htmlspecialchars($this->Application->User->Roles[1]));
		
		if(count($result))
		{
			foreach ($result as $caso) {
			
			   $trimestre  = $caso->trimestre;
			   $trimestres = TrimestresRecord::finder()->findAll();
			   
			   $casos[] = array('id' => $caso->id,
								'fecha' => $caso->fecha,
								'estado' => $caso->estado,
								'trimestre_nombre' => $trimestre->nombre,
								'trimestre_id' => $trimestre->id,
								'trimestres' => $trimestres);
			}

			$this->Pager->Visible = true;
		}
		else
		{
		   	$this->agregar_mensajes_unicode(true,'Ning�n registro encontrado',false);
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

			$this->agregar_mensajes_unicode(SesionesRecord::finder()->deleteByPk($this->DataList->DataKeys[$param->Item->ItemIndex]),'Eliminar sesi�n',true);
						
		 } catch (Exception $e) {
                
				$this->agregar_mensajes_unicode(false,'Compruebe que la sesi�n que intenta eliminar
				no se encuentra programada. Deber� eliminar las programaciones primero',false);	
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
		
		$datosSesiones = SesionesRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
		
		$datosSesiones->id = TPropertyValue::ensureInteger(htmlspecialchars($this->DataList->DataKeys[$item->ItemIndex]));
		$datosSesiones->fecha   = htmlspecialchars($item->fecha->getDate());
		$datosSesiones->trimestre_id =TPropertyValue::ensureInteger(htmlspecialchars($item->listatrimestre->getSelectedValue()));
		$datosSesiones->estado =TPropertyValue::ensureInteger(htmlspecialchars($item->estado->getSelectedValue()));
		
		$this->agregar_mensajes_unicode($datosSesiones->save(),'Editar sesi�n',true);
		
			
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