<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


 
class Datos_centro extends TPage
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
	
	
	
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
	  
	}						   

 
 
    public function getData()
    {   
	    $casos = Null;
		$centro = Null;
		
		
		$centro = CentrosRecord::finder()->findByPk($this->Application->User->Roles[2]);
		
		if(count($centro))
		{
			   
			$casos[] = array('id' => $centro->id,	   
								'nombre' => $centro->nombre,
								'subdirector_nombre' => $centro->subdirector_nombre,
								'subdirector_id' => $centro->subdirector_id,
								'subdirector_id_tipo' => $centro->subdirector_id_tipo,
								'direccion_y_telefono' => $centro->direccion_y_telefono,
								'regional' => $centro->regional,
								'ciudad' => $centro->ciudad);

		}
		else
		{
		    $this->agregar_mensajes_unicode(true,'Ningún registro encontrado',false);
			$this->DataList->items->clear();
		}

		
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
    }
 
	 
	public function cancelItem($sender,$param)
    {
        $this->DataList->SelectedItemIndex=-1;
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
		$this->mensajes->Text = '';
	   $this->alertas->Text = '';

    }
 
	 
	
	public function updateItem($sender,$param)
    {
        $item=$param->Item;
		
		$datosCentros = CentrosRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
		
		$datosCentros->id = $this->DataList->DataKeys[$item->ItemIndex];
		$datosCentros->nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->nombre->Text),MB_CASE_TITLE,"UTF-8"));
        $datosCentros->subdirector_nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->subdirector_nombre->Text), MB_CASE_TITLE, "UTF-8"));
		$datosCentros->subdirector_id =TPropertyValue::ensureString(htmlspecialchars($item->subdirector_id->Text));
		$datosCentros->subdirector_id_tipo = TPropertyValue::ensureString($item->subdirector_id_tipo->getSelectedValue());
		$datosCentros->direccion_y_telefono =TPropertyValue::ensureString(htmlspecialchars($item->direccion_y_telefono->Text));
		$datosCentros->ciudad =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->ciudad->Text), MB_CASE_TITLE, "UTF-8"));
		$datosCentros->regional =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->regional->Text), MB_CASE_TITLE, "UTF-8"));
		
		$this->agregar_mensajes_unicode($datosCentros->save(),'Editar centro',true);
		
			
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();

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