<?php

Prado::using('System.Web.UI.ActiveControls.*');

Prado::using('Application.libraries.funciones');

 

 

class Programar_sesion extends TPage

{



    

    public function onLoad($param)

    {

        parent::onLoad($param);

        if(!$this->IsPostBack)

        {

			$default = new TListItem();

            $default->setText('Seleccione');

            $default->setValue('0');

			

			$criteria = new TActiveRecordCriteria;

            $criteria->OrdersBy['nombre'] = 'asc';

            $finder = TrimestresRecord::finder();

            $this->trimestre_id->DataSource=$finder->findAll($criteria);

            $this->trimestre_id->DataTextField='nombre';

            $this->trimestre_id->DataValueField='id';

			$this->trimestre_id->dataBind();

			$this->trimestre_id->items->insertAt(0,$default);

			



			$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 

			if(!is_dir($nombre_carpeta))

			  mkdir($nombre_carpeta, 0755);

			else

			  vaciar_directorio($nombre_carpeta);



		}	

		

			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 

								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 

								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';

	

	    $this->DataList->items->clear();

	    $this->mensajes->Text = '';

	    $this->alertas->Text = '';

	   

	   

	  //MIENTRAS NO SE COMPLETE NO DEBE SER ACCESIBLE POR EL USUARIO 

	  //$this->Response->redirect('index.php?page=usuarios.Usuario_menu');

	  //return true;

	}						   



 

 



 

     

	 

	public function cargar_sesiones($sender,$param)

    {

			$default = new TListItem();

            $default->setText('Seleccione');

            $default->setValue('0');

			

  			$this->informe_id->setenabled(false);

			$this->caso_id->setenabled(false);

			$this->binforme->setenabled(false);

			$this->bcaso->setenabled(false);

			$this->binvitar->setenabled(false); 

			

			

			$criteria = new TActiveRecordCriteria;

            $criteria->OrdersBy['fecha'] = 'asc';

			$criteria->Condition = 'trimestre_id = :trimestre AND estado=1 AND programa_id = :programa';

			$criteria->Parameters[':trimestre'] = htmlspecialchars($this->trimestre_id->Text);

			$criteria->Parameters[':programa']  = htmlspecialchars($this->Application->User->Roles[1]);

						

						

		    $datos = SesionesRecord::finder()->findAll($criteria);

			

			if(!count($datos))

			     $this->agregar_mensajes_unicode(true,'No se encontraron sesiones en el trimestre seleccionado',false);					

						

						

            $this->sesion_id->DataSource=$datos;

            $this->sesion_id->DataTextField='fecha';

            $this->sesion_id->DataValueField='id';

            $this->sesion_id->dataBind();

			$this->sesion_id->items->insertAt(0,$default);

			

			//$this->mensajes->Text = '';

			//$this->alertas->Text = '';

			$this->DataList->items->clear();

    } 

	 

	 

	 

	



	 public function cargar_programacion($sender=Null,$param=Null)

     {

			

 			if($this->sesion_id->SelectedIndex==0)

			{

				$this->informe_id->setEnabled(False);

				$this->caso_id->setEnabled(False);

				$this->binforme->setEnabled(False);

				$this->bcaso->setEnabled(False);

				$this->binvitar->setenabled(false); 

			}

			else

			{

				$this->informe_id->setEnabled(True);

				$this->caso_id->setEnabled(True);

				$this->binforme->setEnabled(True);

				$this->bcaso->setEnabled(True);

				$this->binvitar->setenabled(True); 

			} 

			

		

 			//PARA INFORMES

			$result = Null;

			$casos = Null;

		

		

		    $result = InformesRecord::finder()->findAllBySql('

			SELECT informes.id, grupo_id

			FROM `informes` 

			INNER JOIN `grupos` ON informes.grupo_id = grupos.id

			WHERE informes.estado=1 AND grupos.estado != 3 AND grupos.programa_id=' . htmlspecialchars($this->Application->User->Roles[1]) . ' 

			ORDER BY grupo_id');	

		

		    			

			if(count($result))

			{

				foreach ($result as $caso) {

				

				   $grupo 	= 	$caso->grupo;

				   $titulacion  = $grupo->titulacion;

	

				   $casos[] = array('id' => $caso->id,

									'nombre' => $grupo->codigo . ' ' . $titulacion->nombre . ' ' . $caso->nombre);

				}

			}

		    



			$this->informe_id->items->clear();

			$this->informe_id->DataSource=$casos;

			$this->informe_id->DataTextField='nombre';

            $this->informe_id->DataValueField='id';

			$this->informe_id->PromptText="Seleccione";

			$this->informe_id->PromptValue=" ";

            $this->informe_id->dataBind();

			$this->informe_id->SelectedIndex=-1; 

		

		

		

			//PARA CASOS

			$result = Null;

			$casos = Null;

			

			$result = CasosRecord::finder()->findAllBySql('

			SELECT casos.id, fecha, casos.estado, aprendiz_id, grupo_id

			FROM `casos` 

			INNER JOIN `grupos` ON casos.grupo_id = grupos.id

			WHERE casos.estado=1 AND grupos.estado != 3 AND grupos.programa_id=' . htmlspecialchars($this->Application->User->Roles[1]) . ' 

			ORDER BY grupo_id');	

			

			

			//Prado::log(var_export($result, true),TLogger::ERROR,'ANDRES');

			

			

			if(count($result))

			{

				foreach ($result as $caso) {

				

				   $grupo 		= 	$caso->grupo;

				   $aprendiz 	= 	$caso->aprendiz;

				   $titulacion  =   $grupo->titulacion;

	

	

				   $casos[] = array('id' => $caso->id,

									'nombre' => $grupo->codigo . ' ' . $titulacion->nombre . ' ' . $aprendiz->nombre);

				}

			}

		    

			

			$this->caso_id->items->clear();

			$this->caso_id->DataSource=$casos;

			$this->caso_id->DataTextField='nombre';

            $this->caso_id->DataValueField='id';			

			$this->caso_id->PromptText="Seleccione";

			$this->caso_id->PromptValue=" ";

			$this->caso_id->dataBind();

			$this->caso_id->SelectedIndex=-1; 

			

			

			



            //PARA LA GRILLA DE DATOS



			$this->DataList->SelectedItemIndex=-1;

			$this->DataList->EditItemIndex=-1;

			$this->DataList->DataSource=$this->Data;

			$this->DataList->dataBind();

      

			//Prado::log(var_export($result, true),TLogger::ERROR,'ANDRES');							   

	 }







 

    public function getData()

    {   

		$casos = Null;

		$result = Null;

		

		$result = ProgramacionesRecord::finder()->findAllBySql('

		SELECT programaciones.id, hora, caso, informe, grupo_id, sesion_id

		FROM `programaciones` 

		WHERE programaciones.sesion_id =' . htmlspecialchars($this->sesion_id->Text) . ' 

		ORDER BY hora, grupo_id');						   

		



		//Prado::log(var_export($result, true),TLogger::ERROR,'ANDRES');

		

		

		if(count($result))

		{

			foreach ($result as $item) 

			{ 

				$grupo 		       = 	$item->grupo;

				$sesion 	  	   = 	$item->sesion;

				$aprendiz_nombre   =	'Grupo';

				$citacion		   =    'Hidden';

				

				$titulacion = $grupo->titulacion;

			

				if($item->caso == 0)

				{

					$tipo 			 = 'Informe';

					

					$informe  	     =  InformesRecord::finder()->findByPk($item->informe);

					$nombre          =  $informe->nombre;

				}

				else

				{

					$tipo 	  		 = 'Caso';

					$citacion		 = 'Fixed';

					

					$caso  	  		 = CasosRecord::finder()->findByPk($item->caso);

					$aprendiz 		 = $caso->aprendiz;

					$nombre          = $aprendiz->nombre; 

				}		

					

				$casos[] = array('id' => $item->id,

								 'hora' => DATE("H:i",STRTOTIME($item->hora)),

								 'grupo_codigo' => $grupo->codigo,

								 'grupo_nombre' => $titulacion->nombre, 									

								 'tipo' => $tipo,

								 'citacion' => $citacion,

								 'nombre' => $nombre);						

			}

		}

		else

		{

			$this->DataList->reset();

			$this->binvitar->setenabled(false); 

			$this->agregar_mensajes_unicode(true,'Ningún registro encontrado',false);			

		}

		return $casos;	

    }

	

	 

	 

	 

	 

	 



	

	

	 

	public function agregar_caso($sender,$param)

    {

		$this->mensajes->Text = '';

	    $this->alertas->Text = '';

		

		$result = CasosRecord::finder()->findByPk(htmlspecialchars($this->caso_id->Text));

		$grupo 	= $result->grupo;

		

		//Prado::log(var_export($result, true),TLogger::ERROR,'ANDRES');

		

		$ProgramacionRecord = new ProgramacionesRecord();	

		$ProgramacionRecord->hora = ($this->hora->Text . ':' . $this->minutos->Text);

		$ProgramacionRecord->sesion_id = htmlspecialchars($this->sesion_id->Text);

		$ProgramacionRecord->caso = htmlspecialchars($this->caso_id->SelectedValue);

		$ProgramacionRecord->grupo_id = $grupo->id;		

		

        if($ProgramacionRecord->save())

        {

		    $this->agregar_mensajes_unicode(true,'Agregar caso',false);

		

            $caso = CasosRecord::finder()->findByPk(htmlspecialchars($this->caso_id->Text));

			$caso->estado = 2;

			

			$this->agregar_mensajes_unicode($caso->save(),'Actualizar caso',true);		

		}

		else

        {

			$this->agregar_mensajes_unicode(false,'Agregar caso',true);

		}		  

			

		$this->cargar_programacion();

    } 

	 

	 

	 

	 

	public function agregar_informe($sender,$param)

    {	

	    $this->mensajes->Text = '';

	    $this->alertas->Text = '';

		

		

		$result = InformesRecord::finder()->findByPk(htmlspecialchars($this->informe_id->Text));

		

		$grupo 	= $result->grupo;

		

		$ProgramacionRecord = new ProgramacionesRecord();	

		$ProgramacionRecord->hora = ($this->hora->Text . ':' . $this->minutos->Text);

		$ProgramacionRecord->sesion_id = htmlspecialchars($this->sesion_id->Text);

		$ProgramacionRecord->informe = htmlspecialchars($this->informe_id->SelectedValue);

		$ProgramacionRecord->grupo_id = $grupo->id;		

	



        if($ProgramacionRecord->save())

		{

			$this->agregar_mensajes_unicode(true,'Agregar informe',false);	   	

					

			$informe = InformesRecord::finder()->findByPk(htmlspecialchars($this->informe_id->Text));

			$informe->estado = 2;

			

			$this->agregar_mensajes_unicode($informe->save(),'Actualizar informe',true);		

		}

		else

        {

			$this->agregar_mensajes_unicode(false,'Agregar informe',true);

		}		  

			

		$this->cargar_programacion();

    } 

	 

	 

	 

	public function deleteItem($sender,$param)

    {

		$this->mensajes->Text = '';

	    $this->alertas->Text = '';

		

		

		try {

		

				

			$programacion = ProgramacionesRecord::finder()->findByPk($this->DataList->DataKeys[$param->Item->ItemIndex]); 

			

			if($programacion->caso != 0)

			{

			   $proceso = ProcesosRecord::finder()->findAll('codigo = ?', array($programacion->caso));

			   if(count($proceso))

			   	   $this->agregar_mensajes_unicode(DecisionesRecord::finder()->deleteByPk($proceso[0]->id),'Eliminar decisión de caso',false);	

			   

			   $this->agregar_mensajes_unicode(ProcesosRecord::finder()->deleteByCodigo($programacion->caso),'Eliminar caso de acta',false);

			}

			

			

			



			if(ProgramacionesRecord::finder()->deleteByPk($this->DataList->DataKeys[$param->Item->ItemIndex]))

			{

				$this->agregar_mensajes_unicode(true,'Eliminar caso',false);

				

				

				if($programacion->caso != 0)

				{

					$caso = CasosRecord::finder()->findByPk($programacion->caso);

					$caso->estado = 1;				

					$this->agregar_mensajes_unicode($caso->save(),'Actualizar caso',true);			

				}	

				elseif($programacion->informe != 0)

				{

					$informe = InformesRecord::finder()->findByPk($programacion->informe);

					$informe->estado = 1;

					$this->agregar_mensajes_unicode($informe->save(),'Actualizar informe',true);	

				}

			}

			else 

				 $this->agregar_mensajes_unicode(false,'Eliminar caso',true);

				

		

		

		} catch (Exception $e) {

                

				$this->agregar_mensajes_unicode(false,'Compruebe que el registro que intenta eliminar

				no se encuentra realacionado. Deberá eliminar las relaciones primero',false);	

        }

		

		

				

		$this->cargar_programacion();

    } 

	

	

	public function editItem($sender,$param)

    {

        $this->DataList->SelectedItemIndex=-1;

        $this->DataList->EditItemIndex=$param->Item->ItemIndex;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

		

		$this->mensajes->Text = '';

	    $this->alertas->Text = '';

		

    }

 

	 

	public function cancelItem($sender,$param)

    {

        $this->DataList->SelectedItemIndex=-1;

        $this->DataList->EditItemIndex=-1;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

		

		$this->mensajes->Text = '';

	   $this->alertas->Text = '';

		

    }

 

	 

	 

	public function updateItem($sender,$param)

    {

		$item=$param->Item;

		

		$datosProgramacion = ProgramacionesRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);

		$datosProgramacion->id = TPropertyValue::ensureInteger(htmlspecialchars($this->DataList->DataKeys[$item->ItemIndex]));

		$datosProgramacion->hora = ($item->horamod->Text . ':' . $item->minutosmod->Text);

		

		$this->agregar_mensajes_unicode($datosProgramacion->save(),'Editar programación',true);	

       

	    $this->DataList->EditItemIndex=-1;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

    } 

	

	

	

	

	



	

	

	

	

	

	public function selectItem($sender,$param)

    {

		

		$correos = '';

		

		$item=$param->Item;

		

		

		//DATOS DE SESION 

		$programacion = ProgramacionesRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);

		$sesion = $programacion->sesion;

		$comite_fecha = fechalarga($sesion->fecha);

		$comite_hora = $programacion->hora;

		

		//DATOS DE GRUPO

		$grupo 		   = $programacion->grupo;

		$titulacion    = $grupo->titulacion;

		$grupo_codigo  = $grupo->codigo;

		$grupo_nombre  = utf8_decode($titulacion->nombre);

		

		//DATOS DE CASO

		$caso = CasosRecord::finder()->findByPk($programacion->caso);

		$caso_fecha = fechalarga($caso->fecha);

		$caso_descripcion   = utf8_decode($caso->descripcion);

		

		//LUGAR Y DATOS DE ENVIO DE CORREO

		$programa = ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);

		$programa_lugar 				= utf8_decode($programa->ambiente_comites);

		$programa_nombre 				= utf8_decode($programa->nombre);

		$programa_coordinador_nombre	= utf8_decode($programa->coordinador_nombre);

		

		

		$programa_correo_envio      = $programa->correo_envio;

		$programa_correo_envio_pass = $programa->correo_envio_pass;

		$programa_correo_host       = $programa->correo_host;

		$programa_correo_auth       = $programa->correo_auth;

		

		//DATOS DE TIPIFICACION

		$tipificaciones = unserialize($caso->tipificaciones);

		$tipificacion_datos = Null;	  

        foreach ($tipificaciones as $item)

		{

			$result = TipificacionesRecord::finder()->findByPk($item);

			

			$tipificacion_datos = $tipificacion_datos . 

					  '\b Tipificación: \b0'. utf8_decode($result->nombre) . '\par ' .

		              '\b Tipo: \b0' . utf8_decode($result->tipo_falta) . '\par ' . 

		              '\b Nivel: \b0'. utf8_decode($result->nivel) . '\par ' .

		              '\b Normatividad: \b0' . utf8_decode($result->reglamento_aplicado) . '\par\par ';

		}

		

		//DATOS DE APRENDIZ

		$aprendiz        		  = $caso->aprendiz;

		$aprendiz_nombre 		  = utf8_decode($aprendiz->nombre);

		$aprendiz_correo 		  = $aprendiz->correo;

		$aprendiz_id_tipo  		  = $aprendiz->id_tipo;

		$aprendiz_identificacion  = $aprendiz->identificacion;

		

		//DATOS DE QUEJOSO

		$quejoso 		= $caso->quejoso;

		$quejoso_nombre = utf8_decode($quejoso->nombre);

		$quejoso_correo = $quejoso->correo;



		

		

		$cuerpo =  'Cordial saludo aprendiz,\par '.$aprendiz_nombre.' '.$aprendiz_id_tipo.' '.$aprendiz_identificacion. 

		'\par '.$grupo_nombre.' '.$grupo_codigo.' \par\par '.

		'Formalmente le comunico el caso en el cual está presuntamente involucrado(a). Presentado por el quejoso: ' . $quejoso_nombre . 

		' el día ' . $caso_fecha . '. El cual establece: \par\par ' . $caso_descripcion . '\par\par ' . 

		'Una vez analizado dicho caso, le aclaramos que la(s) falta(s) que describe es (son):\par\par' . $tipificacion_datos .

		'Por lo ya expuesto, me permito citar a usted al comité de evaluación y seguimiento que ' . 

		'se realizará el día ' .$comite_fecha . ', a las ' . $comite_hora . ' horas,' .

		' en el ' . $programa_lugar . ' del ' . $programa_nombre . ', con el fin de que pueda ejercer su derecho ' .

		'como aprendiz, realizando los respectivos descargos. Frente a ésta situación le asiste a ' .

		'usted el derecho de controvertir las pruebas que se alleguen en su contra y ' .

		'aportar y/o solicitar las pruebas que considere pertinentes.' . 

		'\par\par Muchas gracias por su atención y esperamos su puntual asistencia. \par\par '  . 

		'Cordialmente,\par\par ' . $programa_coordinador_nombre . '\par Coordinador Académico \par ' . 'SENA, ' . $programa_nombre . '\par\par ' .

		'Copias enviadas: Director de grupo, quejoso, integrantes del comite.';

					  		

			

		$correos = $correos . '"' . $aprendiz_nombre . '" <' . $aprendiz_correo . '>,';

		$correos = $correos . '"' . $quejoso_nombre  . '" <' . $quejoso_correo . '>,';

		

		

		

		//PARA QUE NO INGRESEN CORREOS DUPLICADOS

		$pos = strpos($correos, $grupo->director_correo);

		if ($pos === false)

				$correos = $correos . '"' . utf8_decode($grupo->director_nombre) . '" <' . $grupo->director_correo . '>,';

				



				

		$result = IntegrantesRecord::finder()->findAll('programa_id = ?', htmlspecialchars($this->Application->User->Roles[1]));

		foreach ($result as $integrante)

		{

			//PARA QUE NO INGRESEN CORREOS DUPLICADOS

			$pos = strpos($correos, $integrante->correo);

			if ($pos === false)

					$correos = $correos . '"' . utf8_decode($integrante->nombre) . '" <' . $integrante->correo . '>,';

		}		

				

		

		

		$nombreArchivo = do_generar_nombre_archivo("citacion_correo_caso_") . 'doc';

		$plantilla = file_get_contents('doc_guias/citacion_correo_caso.rtf');

		

		$plantilla = str_replace('#correos#',$correos,$plantilla);

		$plantilla = str_replace('#cuerpo#',$cuerpo,$plantilla);

		

		

		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO

		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 

		if(!is_dir($nombre_carpeta)){ 

		  mkdir($nombre_carpeta, 0755); 

		}

		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);

		descargar($nombre_carpeta,$nombreArchivo);

	    //eliminar_archivo($nombreArchivo);

		



		$this->cargar_programacion();

		

		return false;

		

	}

	

	



	

	

	

	

	

	public function invitar()

    {

		$this->mensajes->Text = '';

	    $this->alertas->Text = '';

		

		$correos = '';

		

		

		//DATOS DE SESION 

		$sesion = SesionesRecord::finder()->findByPk(htmlspecialchars($this->sesion_id->Text));

		$comite_fecha 					= fechalarga($sesion->fecha);

		

		

		//DATOS PROGRAMA

		$programa 						= $sesion->programa;

		$programa_lugar 				= utf8_decode($programa->ambiente_comites);

		$programa_nombre 				= utf8_decode($programa->nombre);

		$programa_coordinador_nombre	= utf8_decode($programa->coordinador_nombre);

		$programa_correo_envio      	= $programa->correo_envio;

		$programa_correo_envio_pass 	= $programa->correo_envio_pass;

		$programa_correo_host       	= $programa->correo_host;

		$programa_correo_auth       	= $programa->correo_auth;

		

		

		

		

	    //DATOS DE PROGRAMACIONES DE SESION

		

		$result = ProgramacionesRecord::finder()->findAllBySql('

		SELECT programaciones.id, hora, caso, informe, grupo_id, sesion_id

		FROM `programaciones` 

		WHERE programaciones.sesion_id =' . htmlspecialchars($this->sesion_id->Text) . ' 

		ORDER BY hora, grupo_id');	

		

				

		

		$cuerpo = 'Cordial saludo,\par Integrantes del comité de Evaluación y Seguimiento, instructores, voceros de grupo, quejosos y aprendices. \par\par '.

		'Oficialmente les informo que el día ' . $comite_fecha . ', se desarrollará  una sesión de comité. '. 

		'El lugar de reunión es: ' .  $programa_lugar . '. La cual está programada de la siguiente manera: \par\par';



		

		

		

		$cuerpo = $cuerpo . '\trowd\trgaph70\trleft-108\trrh266\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10'. 

		'\trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3'.

		'\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10'.

		'\brdrs \cellx2093\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs'.

		'\clbrdrb\brdrw10\brdrs \cellx5113\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr'.

		'\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8736\pard\intbl\nowidctlpar\qc\tx1418\lang9226'.

		'\b Hora\cell Grupo\cell Caso\cell\row\pard\nowidctlpar\tx1418\b0';

		

		

		

		foreach ($result as $programacion)

		{

		     

			 $grupo = GruposRecord::finder()->findByPk($programacion->grupo_id);

			 $titulacion = $grupo->titulacion;

		

				//PARA QUE NO INGRESEN CORREOS DUPLICADOS

		        $pos = strpos($correos, $grupo->director_correo);

				if ($pos === false)

						$correos = $correos . '"' . utf8_decode($grupo->director_nombre) . '" <' . $grupo->director_correo . '>,';

				

				

				//VERIFICAMOS SI EL GRUPO ESTA EN ETAPA LECTIVA

				if($grupo->estado == 1)

				{

					//PARA QUE NO INGRESEN CORREOS DUPLICADOS

					$pos = strpos($correos, $grupo->vocero_correo);

					if ($pos === false)

							$correos = $correos . '"' . utf8_decode($grupo->vocero_nombre) . '" <' . $grupo->vocero_correo . '>,';				

				}



		

			    if($programacion->caso == 0 AND $programacion->informe==0)

				{

				    $hora  =  $programacion->hora;

					$grupo =  utf8_decode($titulacion->nombre) . ' ' .  $grupo->codigo;

					$caso  =  'Pendiente por envío de casos o informe general.';	

				}	

				elseif($programacion->caso == 0)

				{

					$informe = InformesRecord::finder()->findByPk($programacion->informe);

				

				    $hora  =  $programacion->hora;

					$grupo =  utf8_decode($titulacion->nombre) . ' ' .  $grupo->codigo;

					$caso  =  'Informe general de grupo enviado por ' . utf8_decode($informe->nombre);

					

					

					//PARA QUE NO INGRESEN CORREOS DUPLICADOS

					$pos = strpos($correos, $informe->correo);

					if ($pos === false)

							$correos = $correos . '"' . utf8_decode($informe->nombre) . '" <' . $informe->correo . '>,';	

					

					

				}

				else

				{

					$caso  	  		 = CasosRecord::finder()->findByPk($programacion->caso);

					

					$aprendiz 		 = $caso->aprendiz;

					$quejoso 		 = $caso->quejoso;

					

					$aprendiz_nombre = $aprendiz->nombre; 

					

					

				    $hora  =  $programacion->hora;

					$grupo =  utf8_decode($titulacion->nombre) . ' ' .  $grupo->codigo;

					$caso  =  'Caso a tratar del aprendiz ' . utf8_decode($aprendiz_nombre) . '.';

					

					

					//PARA QUE NO INGRESEN CORREOS DUPLICADOS

					$pos = strpos($correos, $aprendiz->correo);

					if ($pos === false)

							$correos = $correos . '"' . utf8_decode($aprendiz->nombre) . '" <' . $aprendiz->correo . '>,';

					

					

					//PARA QUE NO INGRESEN CORREOS DUPLICADOS

					$pos = strpos($correos, $quejoso->correo);

					if ($pos === false)

							$correos = $correos . '"' . utf8_decode($quejoso->nombre) . '" <' . $quejoso->correo . '>,';

				

				}		

			

					$cuerpo = $cuerpo . '\f0\fs22'.

					'\trowd\trgaph70\trleft-108\trrh266\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs'.

					'\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70'.

					'\trpaddr70\trpaddfl3\trpaddfr3'.

					'\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr'.

					'\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2093\clbrdrl\brdrw10'.

					'\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10'.

					'\brdrs \cellx5113\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr'.

					'\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8736\pard\intbl\nowidctlpar'.

					'\tx1418\f1\fs24 '. $hora .'\cell ' . $grupo . '\cell ' . $caso . '\cell\row\pard\nowidctlpar\tx1418'.

					'\b0';

		

		}

		

		

		$cuerpo =  $cuerpo . '\par\par\pard\nowidctlpar\qj\tx1418 Espero su puntual asistencia y agradezco la atención prestada. \par\par ' . 

		'\par\par Atentamente, \par\par '. $programa_coordinador_nombre . 

		' \par Coordinador Académico\par' . ' SENA, ' . $programa_nombre . '\par';

		

			

        $result = IntegrantesRecord::finder()->findAll('programa_id = ?', htmlspecialchars($this->Application->User->Roles[1]));

		foreach ($result as $integrante)

		{

			//PARA QUE NO INGRESEN CORREOS DUPLICADOS

			$pos = strpos($correos, $integrante->correo);

			if ($pos === false)

					$correos = $correos . '"' . utf8_decode($integrante->nombre) . '" <' . $integrante->correo . '>,';

		}

		

		

	    $nombreArchivo = do_generar_nombre_archivo("citacion_correo_sesion_") . 'doc';

		$plantilla = file_get_contents('doc_guias/citacion_correo_sesion.rtf');

		

		$plantilla = str_replace('#correos#',$correos,$plantilla);

		$plantilla = str_replace('#cuerpo#',$cuerpo,$plantilla);

		

		

		

		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO

		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 

		if(!is_dir($nombre_carpeta)){ 

		  mkdir($nombre_carpeta, 0755); 

		}

		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);

		descargar($nombre_carpeta,$nombreArchivo);

		//eliminar_archivo($nombreArchivo);

		

		$this->cargar_programacion();

		

		return false;

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