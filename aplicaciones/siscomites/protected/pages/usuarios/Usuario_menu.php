<?php
/* 
 * Generado por el Ingeniero:
 * Andr�s Augusto Garc�a Pineda.
 * Proyecto SENACOMITES con prado framework.
 */

class Usuario_menu extends TPage
{

	
	public function onLoad($param)
    {
        parent::onLoad($param);

			if(!$this->IsPostBack)
			{
			
			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 
								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 
								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';

			}
    }
   

}	
?>