<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');


 
class Datos_coordinacion extends TPage
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
		$programa = Null;

		
		$programa 	= ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);
		
		if(count($programa))
		{
			$centro = $programa->centro;
			   
			$casos[] = array('id' => $programa->id,
								'codigo' => $programa->codigo,		   
								'nombre' => $programa->nombre,
								'coordinador_nombre' => $programa->coordinador_nombre,
								'coordinador_id' => $programa->coordinador_id,
								'coordinador_id_tipo' => $programa->coordinador_id_tipo,
								'centro_nombre' =>  $centro->nombre,
								'ambiente_comites' =>  $programa->ambiente_comites);


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
		
		$datosProgramas = ProgramasRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);
		
		$datosProgramas->id = TPropertyValue::ensureInteger(htmlspecialchars($this->DataList->DataKeys[$item->ItemIndex]));
		$datosProgramas->nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->nombre->Text),MB_CASE_TITLE,"UTF-8"));
        $datosProgramas->coordinador_nombre =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->coordinador_nombre->Text),MB_CASE_TITLE,"UTF-8"));
		$datosProgramas->coordinador_id =TPropertyValue::ensureString(htmlspecialchars($item->coordinador_id->Text));
		$datosProgramas->coordinador_id_tipo =TPropertyValue::ensureString($item->coordinador_id_tipo->getSelectedValue());
		
		$datosProgramas->ambiente_comites =TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->ambiente_comites->Text),MB_CASE_TITLE,"UTF-8"));
					
		$this->agregar_mensajes_unicode($datosProgramas->save(),'Editar programa',true);
		
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