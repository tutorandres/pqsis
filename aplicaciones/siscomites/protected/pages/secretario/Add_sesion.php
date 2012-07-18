<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_sesion extends TPage
{
    
    public function onLoad($param)
    {
        parent::onLoad($param);

        if(!$this->IsPostBack)
        {			
			$default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue(' ');
			
			
			$criteria->OrdersBy['id'] = 'asc';
		    $criteria->Condition = 'estado=1';
			
			$trimestres = TrimestresRecord::finder()->findAll($criteria);		
            $this->trimestres->DataSource=$trimestres;
            $this->trimestres->DataTextField='nombre';
            $this->trimestres->DataValueField='id';
            $this->trimestres->dataBind();
            $this->trimestres->items->insertAt(0,$default);	

		}
			
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
    
	}

	



    public function prepararDatos($sender,$param)
    {
			$this->mensajes->Text = '';
			$this->alertas->Text = '';
			
			$SesionesRecord = new SesionesRecord();
			$SesionesRecord->fecha = htmlspecialchars($this->fecha->getDate());
			$SesionesRecord->estado =TPropertyValue::ensureInteger(htmlspecialchars($this->estado->getSelectedValue()));
			$SesionesRecord->trimestre_id =TPropertyValue::ensureInteger(htmlspecialchars($this->trimestres->getSelectedValue()));		
			$SesionesRecord->programa_id = TPropertyValue::ensureInteger(htmlspecialchars($this->Application->User->Roles[1]));
			
            $this->agregar_mensajes_unicode($SesionesRecord->save(),'Agregar sesión',true);
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