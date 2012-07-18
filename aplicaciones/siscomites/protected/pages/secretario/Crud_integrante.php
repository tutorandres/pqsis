<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


 
class Crud_integrante extends TPage
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
		$casos = Null;
		$result = Null;
		
		
		$result = IntegrantesRecord::finder()->findAllByPrograma_id(htmlspecialchars($this->Application->User->Roles[1]));
		
		
		if(count($result))
		{
			foreach ($result as $caso) {
			
			   $casos[] = array('id' 	  => $caso->id,   
								'nombre'  => $caso->nombre,
								'rol' 	  => $caso->rol,
								'entidad' => $caso->entidad,
								'numero'  => $caso->numero,
								'correo'  => $caso->correo);
			}

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
 
	 
	 
	 
	public function deleteItem($sender,$param)
    {		
		$this->mensajes->Text = '';
	    $this->alertas->Text = '';
		
		try {

			$this->agregar_mensajes_unicode(IntegrantesRecord::finder()->deleteByPk($this->DataList->DataKeys[$param->Item->ItemIndex]),'Eliminar integrante',true);
				
		 } catch (Exception $e) {
                
				$this->agregar_mensajes_unicode(false,'Compruebe que el integrante que intenta eliminar
				no se encuentra realacionado. Deberá eliminar las relaciones primero',false);	
         }	
	
		
		$this->DataList->SelectedItemIndex=-1;
        $this->DataList->EditItemIndex=-1;
        $this->DataList->DataSource=$this->Data;
        $this->DataList->dataBind();
		
    }
	
	
	
	
	public function updateItem($sender,$param)
    {
        $item=$param->Item;
		
		$datosIntegrantes = IntegrantesRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
		 
		$datosIntegrantes->id = TPropertyValue::ensureInteger(htmlspecialchars($this->DataList->DataKeys[$item->ItemIndex]));
		$datosIntegrantes->nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->nombre->Text),MB_CASE_TITLE,"UTF-8"));
        $datosIntegrantes->rol =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->rol->Text),MB_CASE_TITLE,"UTF-8"));
		
		$datosIntegrantes->entidad = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->entidad->Text),MB_CASE_TITLE,"UTF-8"));
		$datosIntegrantes->numero  = htmlspecialchars($item->numero->Text);	
		
		$datosIntegrantes->correo =TPropertyValue::ensureString(htmlspecialchars($item->correo->Text));
		$datosIntegrantes->programa_id =TPropertyValue::ensureString(htmlspecialchars($this->Application->User->Roles[1]));
		
		$this->agregar_mensajes_unicode($datosIntegrantes->save(),'Editar integrante',true);
			
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