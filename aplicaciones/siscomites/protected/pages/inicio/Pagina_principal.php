<?php

class Pagina_principal extends TPage
{
    
	
	public function onLoad($param)
    {
        parent::onLoad($param);
		
		if(!$this->Application->User->IsGuest)
		{
			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';
		}
	}
	
	
	

}

?>