<?php

/**
* Script de funciones utilizadas en los demas scripts
*
* @package comites
*
* @author Andres Garcia. andresgarcia@misena.edu.co
* @version 0.1   Fecha creación: 02/08/2009
*
*
*/

/*************************************
 Devuelve una cadena con la fecha que se
 le manda como parámetro en formato largo.
 *************************************/
function fechalarga($fecha){

$fecha = explode ("-", $fecha);

switch($fecha[1]) {
case '01': $mesletra="Enero"; break;
case '02': $mesletra="Febrero"; break;
case '03': $mesletra="Marzo"; break;
case '04': $mesletra="Abril"; break;
case '05': $mesletra="Mayo"; break;
case '06': $mesletra="Junio"; break;
case '07': $mesletra="Julio"; break;
case '08': $mesletra="Agosto"; break;
case '09': $mesletra="Septiembre"; break;
case '10': $mesletra="Octubre"; break;
case '11': $mesletra="Noviembre"; break;
case '12': $mesletra="Diciembre"; break;
}
return $fecha[2] . ' de ' . $mesletra . ' de ' . $fecha[0];
}


function restaFechas($dFecIni, $dFecFin)
{
 	 
	$fecha_inicial = explode("-",$dFecIni); 
	$fecha_final   = explode("-",$dFecFin);
	 
	$ano1 = $fecha_inicial[0]; 
	$mes1 = $fecha_inicial[1]; 
	$dia1 = $fecha_inicial[2]; 

	$ano2 = $fecha_final[0]; 
	$mes2 = $fecha_final[1];  
	$dia2 = $fecha_final[2];  
	
	
/* 	//para pruebas
	$mes2 = 7;  
	$dia2 = 15;   */
	

	//calculo timestam de las dos fechas 
	$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
	$timestamp2 = mktime(4,12,0,$mes2,$dia2,$ano2); 

	//resto a una fecha la otra 
	$segundos_diferencia = $timestamp1 - $timestamp2; 
	//echo $segundos_diferencia; 

	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 

	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	//$dias_diferencia = abs($dias_diferencia); 

	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 

	return $dias_diferencia; 

}



function do_generar_nombre_archivo($archivo)
{
    date_default_timezone_set("America/Bogota");
    
    $partes = explode(".",$archivo);

    if (!isset($partes['0']))
        $partes['0'] = "";

    if (!isset($partes['1']))
        $partes['1'] = "";
          
    $nombre = $partes['0'];
	$extension = $partes['1'];
	$archivo = $nombre.time().".".$partes['1'];
	return $archivo;
}
    
    
	function descargar($root,$archivo){
        	
        $file = basename($archivo);
        $path = $root.$file;
        $type = '';
		
		$host  = $_SERVER['HTTP_HOST']; 
		$uri  = rtrim(dirname($_SERVER['PHP_SELF']), '/\\'); 
		$base = "http://" . $host . $uri . "/"; 
		
		//header('Location: login.php'); 
		//exit();
		//echo '<script> alert("' . $base . $path . '") </script>';
		//header('Content-type: application/msword');
		//header( 'Location: ' . $base . $path );
		//header( 'Location: http://localhost');
		//redirect(descargar.php?f=imagen.jpg.
		//header('Location: login.php'); 
		if (is_file($path))
		{
			header( 'Location: ' . $base . $path );
			//ESTE EXIT ES CLAVE SINO NO FUNCIONA
			exit();
		}	
		else 
            die("El archivo no existe.");
	}





	function eliminar_archivo($nombreArchivo)
	{
	  $root = "doc_generados/";
	
      if(is_file($root.$nombreArchivo))
      {
        if(!unlink($root.$nombreArchivo))
           echo 'error al tratar de eliminar el archivo: ' . $root . $nombreArchivo;

      }
	  
	  return false;
	  
    }

	
	
	function vaciar_directorio($directorio)
	{
	   if(is_dir($directorio)) 
		{
		  
		  $handle = opendir($directorio); 
		  while ($file = readdir($handle))  
		  {   
			 if (is_file($directorio.$file)) 
				  unlink($directorio.$file); 
		  } 
		}

			
		return false;
    }
	
	
		
	function visitas()
	{
		$destino = "themes/Basic/contador/numero.dat";
		$abrir = fopen($destino,"r");
		$cuenta = trim(fread($abrir,filesize($destino)));
		$contador = '<b>Total Procesos Ejecutados:</b></br>';
		  
		if ($cuenta != "") $cuenta++;
		else $cuenta = 1;
		@fclose($abrir);
		$abrir = fopen($destino,"w");
		@fputs($abrir,$cuenta);


		for($i=0;$i<strlen($cuenta);$i++) {
			$imagen = substr($cuenta,$i,1);
			$contador .= "<img alt='$imagen ' src='themes/Basic/contador/$imagen.gif'>";
		}
		@fclose($abrir);
					
		return $contador;
    }	
		


	
?>