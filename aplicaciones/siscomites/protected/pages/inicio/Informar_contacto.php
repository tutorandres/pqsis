<?php

class Informar_contacto extends TPage
{

    public function onLoad($param)
    {
        parent::onLoad($param);

		$contacto = AdministracionRecord::finder()->findAll();
		
		$this->nombre->Text = $contacto[0]->nombre;
		$this->correo->Text = '<a href="mailto:' . $contacto[0]->correo . '">' . $contacto[0]->correo . '</a>';	

		if(!$this->Application->User->IsGuest)
		{
			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
		}
		
	}





}

?>