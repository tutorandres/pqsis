<?php
/* 
 * Generado por el Ingeniero:
 * Andrés Augusto García Pineda.
 * Proyecto SENACOMITES con prado framework.
 */


class Usuario_cerrar extends TPage
{

    public function onLoad($param)
    {
       parent::onLoad($param);

	   $auth=$this->Application->getModule('auth');
       $auth->logout();
	   $this->Application->User->IsGuest = true;
	   
	   //Prado::log(var_export($this->Application->User->IsGuest, true),TLogger::ERROR,'ANDRES');
	   
	   $url = $this->Service->constructUrl($this->Service->DefaultPage);
       $this->Response->redirect($url);
		
    }

}	
?>