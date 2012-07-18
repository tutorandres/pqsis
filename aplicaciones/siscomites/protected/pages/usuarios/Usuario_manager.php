<?php
 
Prado::using('System.Security.TUserManager');
Prado::using('System.Security.TUser');
 
class Usuario_manager extends TUserManager
{
    public function validateUser($name, $password)
    {    
		if(UsuariosRecord::finder()->findBy_nombre_AND_password($name,$password))
		   return true;
		else
		   return false;	
	}
 
 
    public function getUser($name = null)
    {
        $user = new TUser($this);
 
        if (is_null($name)) {
            $user->IsGuest = true;
        } else 
		{
		    $res_user = UsuariosRecord::finder()->findBy_nombre($name);
		
		    if($res_user)
		    {
				$user->IsGuest = false;
                
				
				//GUARDAMOS EL ROL EN EL NOMBRE PORQUE LAS VALIDACIONES
				//ESTAN POR NOMBRE DE USUARIO ASI TODOS LOS USUARIOS
				//DE NOMBRE instructor SOLO PODRAN VER LAS PAGINAS
				//PARA ISNTRUCTOR
				$user->Name = $res_user->rol;
				
				$programa = $res_user->programa;					
				$centro   = $programa->centro;
	
				

			    // SI FUERA CON ->findAll  SERIA CON EL INDICE 0 $programa[0]->nombre,
				// PERO SI ES CON ->findByPk ES DIRECTO          $programa->nombre,
			
/* 				foreach ($result as $programa) 
				{  
				  if($programa->centro)
					  $centro  =  $programa->centro;
				} */

                //$this->Application->User->Roles[1]
				$user->Roles = array(
							    /* 0 */	 $res_user->rol,
								/* 1 */	 $res_user->programa_id,
								/* 2 */  $centro->id,
								/* 3 */	 0,
								/* 4 */	 $programa->nombre,
								/* 5 */  $centro->nombre,
								/* 6 */	 0,
								/* 7 */	 $res_user->nombre,

									);
			}
		    else
			{
				$user->IsGuest = true;
		    }
		}
 
        return $user;
    } 
}
 
?>