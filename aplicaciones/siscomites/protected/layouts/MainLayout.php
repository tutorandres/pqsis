<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MainLayout extends TTemplateControl
{
	
	public function onLoad($param)
    {
        parent::onLoad($param);
		
		date_default_timezone_set("America/Bogota");
		
	}
	
	
}
?>
