<?php



$basePath=dirname(__FILE__);

$frameworkPath=$basePath.'/../framework/pradolite.php';

$assetsPath=$basePath.'/assets';

$runtimePath=$basePath.'/protected/runtime';



if(!is_writable($assetsPath))

	die("Please make sure that the directory $assetsPath is writable by Web server process.");

if(!is_writable($runtimePath))

	die("Please make sure that the directory $runtimePath is writable by Web server process.");



require_once($frameworkPath);







date_default_timezone_set("America/Bogota"); 



$dia  = date("j");

$mes  = date("n");

$hora = date("H");





if(($mes % 2) == 0) 

{

	if($hora > 11)

			$_POST["img"] = 'paquete1_dia_'. $dia; 

	else

			$_POST["img"] = 'paquete1_noche_'. $dia;  

}

else

{

	if($hora > 11)

			$_POST["img"] = 'paquete2_dia_'. $dia; 

	else

			$_POST["img"] = 'paquete2_noche_'. $dia;  	

}

	



$application=new TApplication;

$application->run();



?>