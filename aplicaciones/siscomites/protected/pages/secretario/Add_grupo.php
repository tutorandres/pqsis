<?php 
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */
Prado::using('System.Web.UI.ActiveControls.*');



class Add_grupo extends TPage
{
    
    public function onLoad($param)
    {
        parent::onLoad($param);

        if(!$this->IsPostBack)
        {			
			
			//CONTRUIR EL ARRAY DE TITULACIONES
			$result = TitulacionesRecord::finder()->findAll();
					   
			if(count($result))
			{
				foreach ($result as $item) {
								  
						   $titulaciones[] = array( 'id' => $item->id, 
													'nombre' => $item->nombre
												  );
				}
			}
			else
				$titulaciones = Null;
			
			
		   	$default = new TListItem();
            $default->setText('Seleccione');
            $default->setValue(' ');

            $this->titulaciones->DataSource=$titulaciones;
            $this->titulaciones->DataTextField='nombre';
            $this->titulaciones->DataValueField='id';
            $this->titulaciones->dataBind();
            $this->titulaciones->items->insertAt(0,$default);	
			
		}
		
	   $this->mensajes->Text = '';
	   $this->alertas->Text = '';
		
    }

	



    public function prepararDatos($sender,$param)
    {
			$this->mensajes->Text = '';
			$this->alertas->Text = '';
			
			
			$GruposRecord = new GruposRecord();
			$GruposRecord->codigo = TPropertyValue::ensureInteger(htmlspecialchars($this->codigo->Text));
			$GruposRecord->director_nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->director_nombre->Text),MB_CASE_TITLE,"UTF-8"));			
			$GruposRecord->director_correo = TPropertyValue::ensureString(htmlspecialchars($this->director_correo->Text));
			$GruposRecord->vocero_nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($this->vocero_nombre->Text),MB_CASE_TITLE,"UTF-8"));			
			$GruposRecord->vocero_correo = TPropertyValue::ensureString(htmlspecialchars($this->vocero_correo->Text));
			$GruposRecord->fecha_inicial = htmlspecialchars($this->fecha_inicial->getDate());
			$GruposRecord->fecha_final = htmlspecialchars($this->fecha_final->getDate());
			
			$GruposRecord->estado =TPropertyValue::ensureInteger(htmlspecialchars($this->estado->getSelectedValue()));
			
			$GruposRecord->titulacion_id =TPropertyValue::ensureInteger(htmlspecialchars($this->titulaciones->getSelectedValue()));		
			$GruposRecord->programa_id = TPropertyValue::ensureInteger(htmlspecialchars($this->Application->User->Roles[1]));
			
					
			$this->agregar_mensajes_unicode($GruposRecord->save(),'Agregar grupo',true);
			
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