<?php



/* 



 * Generado por el Ingeniero:



 * Andr�s Augusto Garc�a Pineda.



 * Proyecto SENACOMITES con prado framework.



 */



Prado::using('System.Web.UI.ActiveControls.*');



Prado::using('Application.libraries.funciones');



















class Generar_acta extends TPage



{



    



	var $acta_numero;



    



   



    	public function onPreInit($param){



        $this->MasterClass="Application.layouts.MainLayout";



		$this->Title="Generar Acta Codigo " . $this->request['sesion'] . '-' . $this->request['grupo'];



		} 



   



       



	public function onLoad($param)



    {



        parent::onLoad($param);



			



					$this->acta_numero = $this->request['sesion'] . '-' . $this->request['grupo'];



				  											



					 $this->mensajes->Text = '';



					 $this->alertas->Text = '';



					



					



			if(!$this->IsPostBack)



			{		



					 $result = Null;



					 $asistentes_correos = Null;



					



					



					$result = ProgramacionesRecord::finder()->findAllBySql('							



					SELECT programaciones.id, hora, caso, informe, grupo_id, sesion_id



					FROM `programaciones`



					INNER JOIN `grupos` ON programaciones.grupo_id = grupos.id		



					WHERE programaciones.sesion_id =' . $this->request['sesion'] . ' 



					AND grupos.id='. $this->request['grupo'] . ' 



					ORDER BY hora');



					



				



					foreach ($result as $item) 



					{ 	



							$grupo 		 		= $item->grupo;



							$titulacion  		= $grupo->titulacion; 



							$sesion 	 		= $item->sesion; 



							$programa 	 		= $sesion->programa; 



							



							



							$datos = ActasRecord::finder()->findByPk($this->acta_numero);



															



							if(!count($datos))



							{



								$datos = new ActasRecord();



									



								$datos->id 			 = $this->acta_numero;



								$datos->hora 		 = $item->hora;



								



								$hora1               = explode(":",$datos->hora); 



								$hora1[1]            = $hora1[1]+15;



								



								if($hora1[1] == 60)



									$hora1[1] = $hora1[1]-1;



								



								$datos->horafin 	 = $hora1[0] . ':' . $hora1[1] . ':' . $hora1[2];



								



								$datos->fecha 		 = $sesion->fecha;



								$datos->lugar 		 = $programa->ambiente_comites;



								$datos->responsable  = $programa->coordinador_nombre;



								$datos->introduccion = ' ';







								if($datos->save())



								{



								   $this->agregar_mensajes_unicode(true,'Agregar acta',false);



									



								   $integrantes = IntegrantesRecord::finder()->findAll('programa_id = ?', array($this->Application->User->Roles[1]));	



										



									   foreach ($integrantes as $item2) 



									   { 	



											$asistente = new AsistentesRecord();



											$asistente->nombre 		= $item2->nombre;



											$asistente->rol    		= $item2->rol;		



											$asistente->correo 		= $item2->correo;



											$asistente->entidad     = $item2->entidad;



											$asistente->numero		= $item2->numero;



											



											$asistente->acta_id = $this->acta_numero;



											



											if($asistente->save())



											     $asistentes_correos = $asistentes_correos.' #'.$item2->correo.'#'; 



											else											



											     $this->agregar_mensajes_unicode(false,'Agregar asistente',false);



									   }







											//PARA QUE NO INGRESEN ASISTENTES DUPLICADOS



											$pos = strpos($asistentes_correos, '#'.$grupo->director_correo.'#');



											



											if ($pos === false)



											{



												$asistentes_correos = $asistentes_correos.' #'.$grupo->director_correo.'#';



											



												$asistente	= new AsistentesRecord();



												$asistente->nombre 		= $grupo->director_nombre;



												$asistente->rol    		= 'Director de grupo';		



												$asistente->correo 		= $grupo->director_correo;



												$asistente->entidad     = 'Sena';



												$asistente->numero		= '';



												$asistente->acta_id 	= $this->acta_numero;



												$asistente->save();



											}	



											



											//PARA QUE NO INGRESEN ASISTENTES DUPLICADOS



											$pos = strpos($asistentes_correos, '#'.$grupo->vocero_correo.'#');



											



											if ($pos === false)



											{



												$asistentes_correos = $asistentes_correos.' #'.$grupo->vocero_correo.'#';



											



												$asistente	= new AsistentesRecord();



												$asistente->nombre 		= $grupo->vocero_nombre;



												$asistente->rol    		= 'Vocero de grupo';		



												$asistente->correo 		= $grupo->vocero_correo;



												$asistente->entidad     = 'Sena';



												$asistente->numero		= '';



												$asistente->acta_id 	= $this->acta_numero;



												$asistente->save();



											}												



																					



								}



								else



								   $this->agregar_mensajes_unicode(false,'Agregar acta',false);











							}







							    //SE DETERMINA SI ES CASO O INFORME Y SE ACTUALIZA EL MISMO



								if($item->caso != 0)



								{



									$id 	= $item->caso;



									$tipo 	= 'caso'; 



								}



								else



								{



									$id = $item->informe;



									$tipo 	= 'informe';						



								}



									







								$proceso = ProcesosRecord::finder()->findAll('programacion_id = ?', array($item->id));



									



								if(!count($proceso))



								{



										//ACTUALIZAMOS EL ESTADO DEL CASO O INFORME



										if($tipo == 'informe')



										{



											$informe = InformesRecord::finder()->findByPk($id);



											$informe->estado = 3;



											$this->agregar_mensajes_unicode($informe->save(),'Actualizar informe',false);



											



											//PARA QUE NO INGRESEN ASISTENTES DUPLICADOS



											$pos = strpos($asistentes_correos, '#'.$informe->correo.'#');



											



											if ($pos === false)



											{



												$asistentes_correos = $asistentes_correos.' #'.$informe->correo.'#';



											



												$asistente	= new AsistentesRecord();



												$asistente->nombre 		= $informe->nombre;



												$asistente->rol    		= 'Instructor';		



												$asistente->correo 		= $informe->correo;



												$asistente->entidad     = 'Sena';



												$asistente->numero		= '';



												$asistente->acta_id 	= $this->acta_numero;



												$asistente->save();



											}



										}



										else



										{



										    $caso = CasosRecord::finder()->findByPk($id);



											$caso->estado = 3;



											$this->agregar_mensajes_unicode($caso->save(),'Actualizar caso',false);		



										



										    $quejoso  = $caso->quejoso;



											$aprendiz = $caso->aprendiz;



										



											//PARA QUE NO INGRESEN ASISTENTES DUPLICADOS



											$pos = strpos($asistentes_correos, '#'.$quejoso->correo.'#');



											if ($pos === false)



											{



												$asistentes_correos = $asistentes_correos.' #'.$quejoso->correo.'#';



											



												$asistente	= new AsistentesRecord();



												$asistente->nombre 		= $quejoso->nombre;



												$asistente->rol    		= 'Instructor';		



												$asistente->correo 		= $quejoso->correo;



												$asistente->entidad     = 'Sena';



												$asistente->numero		= '';



												$asistente->acta_id 	= $this->acta_numero;



												$asistente->save();



											}



											



											//PARA QUE NO INGRESEN ASISTENTES DUPLICADOS



											$pos = strpos($asistentes_correos, '#'.$aprendiz->correo.'#');



											if ($pos === false)



											{



												$asistentes_correos = $asistentes_correos.' #'.$aprendiz->correo.'#';



											



												$asistente	= new AsistentesRecord();



												$asistente->nombre 		= $aprendiz->nombre;



												$asistente->rol    		= 'Aprendiz';		



												$asistente->correo 		= $aprendiz->correo;



												$asistente->entidad     = 'Sena';



												$asistente->numero		= '';



												$asistente->acta_id 	= $this->acta_numero;



												$asistente->save();



											}



										



										



										}



										



										$datos = new ProcesosRecord();



										$datos->acta_id 			= $this->request['sesion'] . '-' . $this->request['grupo'];



										$datos->programacion_id 	= $item->id;



										$datos->codigo              = $id;



										$datos->tipo                = $tipo;



										$this->agregar_mensajes_unicode($datos->save(),'Agregar procceso',false);	



								}					







							



								 $this->datos_fijos->Text = 



								 '<b>Codigo Acta: </b>'  . $this->acta_numero . ' <br/>' .



								 '<b>Usuario: </b>'  	 . $this->Application->User->Roles[7] . ' <br/>' . 



								 '<b>Rol: </b>'      	 . $this->Application->User->Roles[0] . ' <br/>' . 



								 '<b>Centro: </b>'   	 . $this->Application->User->Roles[5] . ' <br/>' . 



								 '<b>Grupo: </b>'    	 . $titulacion->nombre . ' ' . $grupo->codigo . '<br/>';	



							  



					}



								



					//llenado de grillas



					$this->listar_datos();



			}



	}







	



	



	



	



	public function getAsistentes()



    {   



		$asistentes = Null;



		$datos = Null;



					   



		$asistentes = AsistentesRecord::finder()->findAll('acta_id = ?', array($this->acta_numero));					   



    



		if(count($asistentes))



		{



			foreach ($asistentes as $item) 



			{



					$datos[] = array(



					'id' 		=> $item->id,



					'nombre' 	=> $item->nombre,



					'rol' 		=> $item->rol,



					'entidad' 	=> $item->entidad,



					'numero' 	=> $item->numero,



					'correo' 	=> $item->correo,



					'asistio' 	=> $item->asistio);			



	    	}



			



		}



	







        if($datos == Null)



		{



			$this->dl_asistentes->reset();



			$this->agregar_mensajes_unicode(true,'No se encontraron asistentes para este comite.',false);	



		}



		



		



		return $datos;	



    }







	



	



	



	



	



	public function getCompromisos()



    {   



		$compromisos = Null;



		$datos = Null;



					   



		$compromisos = CompromisosRecord::finder()->findAll('acta_id = ?', array($this->acta_numero));					   



    



		if(count($compromisos))



		{



			foreach ($compromisos as $item) 



			{



					$datos[] = array(



					'id' 			=> $item->id,



					'fecha' 		=> $item->fecha,



					'descripcion' 	=> $item->descripcion,



					'responsables' 	=> $item->responsables);			



	    	}



			



		}



	







        if($datos == Null)



		{



			$this->dl_compromisos->reset();



			$this->agregar_mensajes_unicode(true,'No se encontraron compromisos para este comite.',false);	



		}



		



		



		return $datos;	



    }



	



	



	



	



	







	



	



	



	



	



	public function listar_datos()



    {   



		$informes = Null;



		$casos = Null;



		$datos = Null;



		



		



		$finder = TiposRecord::finder();



		$this->datos_tipo->DataSource=$finder->findAll();



		$this->datos_tipo->DataTextField='nombre';



		$this->datos_tipo->DataValueField='id';



		$this->datos_tipo->dataBind();



								



		$datos = ActasRecord::finder()->findByPk($this->acta_numero);



		



		if(count($datos))



		{



			$this->datos_fecha->Date    	= $datos->fecha;



			$this->datos_hora->Text    		= $datos->hora;



			$this->datos_horafin->Text    	= $datos->horafin;



			$this->datos_lugar->Text        = $datos->lugar;



			$this->datos_responsable->Text  = $datos->responsable;



			$this->datos_tipo->Text 		= $datos->tipo_id;



			$this->datos_introduccion->Text = $datos->introduccion;



			$this->datos_estado->Text 		= $datos->estado;



			



		}		



		else



			$this->agregar_mensajes_unicode(false,'No se encontro acta.',false);



		



		



	



		$this->dl_asistentes->SelectedItemIndex=-1;



		$this->dl_asistentes->EditItemIndex=-1;



		$this->dl_asistentes->DataSource=$this->Asistentes;



		$this->dl_asistentes->dataBind();



				



		$this->dl_compromisos->SelectedItemIndex=-1;



		$this->dl_compromisos->EditItemIndex=-1;



		$this->dl_compromisos->DataSource=$this->Compromisos;



		$this->dl_compromisos->dataBind();



		



		



		$datos = ProcesosRecord::finder()->findAll('acta_id = ?', array($this->acta_numero));					   



    



		if(count($datos))

		{



			foreach ($datos as $item) 



			{



				if($item->tipo == 'caso')



				{



					$caso = CasosRecord::finder()->findByPk($item->codigo);



					$aprendiz = $caso->aprendiz;



					



					//estado: 1 -> sin desicion todavia



					//        2 -> llamado de atencion



					//        3 -> condicionamiento



					//        4 -> cancelacion



					//        5 -> llamado de atencion verbal medida formativa



					//        6 -> plan de mejoramiento medida formativa. 



					



					//OPCION POR DEFECTO



					$doc_text 	 = 'N&iacute;nguna desici&oacute;n';



					$doc_enabled = 'False';



					



					



					if($item->estado == 2)



					{



					   //$docs=	'<a href="' . $this->Service->constructUrl('secretario.Generar_documento', array('doc_id'=>$item->estado, 'proceso_id'=>$item->id)) . '" ' .



					   //			'Target="_blank" />Generar Llamado de atenci&oacute;n</a>';



					   $doc_text 	= 'Generar Llamado de atenci&oacute;n';



					   $doc_enabled = 'True';



					}



					else if($item->estado == 3)



					{



					   $doc_text 	= 'Generar Condicionamiento';



					   $doc_enabled = 'True';



					}



					else if($item->estado == 4)



					{



					   $doc_text 	= 'Generar Cancelaci&oacute;n';



					   $doc_enabled = 'True';



					}



					else if($item->estado == 5)



					{



					   $doc_text 	= 'Citar caso nuevamente';



					   $doc_enabled = 'False';



					}



								



					$casos[] = array(



					'id' 			=> $item->id,



					'proceso_id'	=> $item->codigo,



					'aprendiz' 		=> $aprendiz->nombre,



					'doc_text' 		=> $doc_text,



					'doc_enabled'	=> $doc_enabled,



					'desicion' 		=> $item->estado);			



	            }



				else if($item->tipo == 'informe')



				{



				    $informe = InformesRecord::finder()->findByPk($item->codigo);



				



				   	$informes[] = array(



					'id' 			=> $item->id,



					'proceso_id' 	=> $item->codigo,



					'nombre' 		=> $informe->nombre,



					'descripcion' 	=> $informe->descripcion);		



				}



				    



		   }



		   



		   



		   	$this->dl_informes->SelectedItemIndex=-1;



			$this->dl_informes->EditItemIndex=-1;



			$this->dl_informes->DataSource = $informes;



			$this->dl_informes->dataBind();



			



			



			$this->dl_casos->SelectedItemIndex=-1;



			$this->dl_casos->EditItemIndex=-1;



			$this->dl_casos->DataSource= $casos;



			$this->dl_casos->dataBind();



		   



		   



		}



		else



		{



			$this->dl_informes->reset();



			$this->dl_casos->reset();



			$this->agregar_mensajes_unicode(true,'No se encontraron datos para esta acta.',false);	



		}



		



    }



	







	



	



	



	public function deleteItem($sender,$param)



    {		



		$this->mensajes->Text = '';



	    $this->alertas->Text = '';



		



	    try {







				    if($sender->ID == 'dl_asistentes')



					{



						$this->agregar_mensajes_unicode(AsistentesRecord::finder()->deleteByPk($this->dl_asistentes->DataKeys[$param->Item->ItemIndex]),'Eliminar asistente',false);



						$this->dl_asistentes->reset();



					



					}



					else if ($sender->ID == 'dl_compromisos') 



					{



						$this->agregar_mensajes_unicode(CompromisosRecord::finder()->deleteByPk($this->dl_compromisos->DataKeys[$param->Item->ItemIndex]),'Eliminar compromiso',true);



						$this->dl_compromisos->reset();



					}



					else 



					{



					    



						



						$procesos = ProcesosRecord::finder()->findAll('acta_id = ?', array($this->acta_numero));



						



						



						if(count($procesos) > 1)



						{



					



							if ($sender->ID == 'dl_informes')



							{



										$proceso = ProcesosRecord::finder()->findByPk($this->dl_informes->DataKeys[$param->Item->ItemIndex]);



									



										if(ProcesosRecord::finder()->deleteByPk($this->dl_informes->DataKeys[$param->Item->ItemIndex]))



										{



											$this->agregar_mensajes_unicode(true,'Eliminar informe de acta',false);



											



											if(ProgramacionesRecord::finder()->deleteByPk($proceso->programacion_id))



											{



											   $this->agregar_mensajes_unicode(true,'Eliminar informe de programacion',false);



											



											   $informe = InformesRecord::finder()->findByPk($proceso->codigo);



											   $informe->estado = 1;



											   $this->agregar_mensajes_unicode($informe->save(),'Actualizar estado de informe',false);	



											}



											else



											   $this->agregar_mensajes_unicode(false,'Eliminar informe de programacion',false);



										}



										else



										   $this->agregar_mensajes_unicode(false,'Eliminar informe de acta',false);	



							



							  



							  $this->dl_informes->reset();



							  



							}			



							else if ($sender->ID == 'dl_casos')



							{



										$proceso = ProcesosRecord::finder()->findByPk($this->dl_casos->DataKeys[$param->Item->ItemIndex]);



									



										if(ProcesosRecord::finder()->deleteByPk($this->dl_casos->DataKeys[$param->Item->ItemIndex]))



										{



											$this->agregar_mensajes_unicode(true,'Eliminar caso de acta',false);



											



											if(ProgramacionesRecord::finder()->deleteByPk($proceso->programacion_id))



											{



											   $this->agregar_mensajes_unicode(true,'Eliminar caso de programacion',false);



											



											   $caso = CasosRecord::finder()->findByPk($proceso->codigo);



											   $caso->estado = 1;



											   $this->agregar_mensajes_unicode($caso->save(),'Actualizar estado de caso',false);	



											}



											else



											   $this->agregar_mensajes_unicode(false,'Eliminar caso de programacion',false);



																		







											



											$this->agregar_mensajes_unicode(DecisionesRecord::finder()->deleteByPk($this->dl_casos->DataKeys[$param->Item->ItemIndex]),'Eliminar decisi�n de caso',false);							



																		



										



										}



										else



										   $this->agregar_mensajes_unicode(false,'Eliminar caso de acta',false);	



							



							



							  $this->dl_casos->reset();



							  



							} 



						}



						else



							$this->agregar_mensajes_unicode(false,'Antes de eliminar este informe o caso debe agregar otro, El acta no puede quedar con 0 casos y 0 informes.',false);	



					}



		 



			} 



			catch (Exception $e) 



			{



                



				$this->agregar_mensajes_unicode(false,'Compruebe que el registro que intenta eliminar



				no se encuentra realacionado. Deber� eliminar las relaciones primero',false);	



			}	



	



		



			//llenado de grillas



			$this->listar_datos();



		



    }



	



	



	







		



	public function guardar_acta($sender,$param)



    {



	    $this->mensajes->Text = '';



		$this->alertas->Text = '';







		$acta = ActasRecord::finder()->findByPk($this->acta_numero);		



		



		



		//$this->getRequest()->ItemAt($this->datos_fecha->uniqueID



		



		$acta->fecha   	    = $this->getRequest()->ItemAt('ctl0$Main$datos_fecha$year') . '-' . 



							  ($this->getRequest()->ItemAt('ctl0$Main$datos_fecha$month') + 1) . '-' . 



							  $this->getRequest()->ItemAt('ctl0$Main$datos_fecha$day');



							  



		$acta->tipo_id 	    = htmlspecialchars($this->getRequest()->ItemAt($this->datos_tipo->uniqueID));



		$acta->hora    	    = htmlspecialchars($this->getRequest()->ItemAt($this->datos_hora->uniqueID));



		



		$acta->horafin 	    = htmlspecialchars($this->getRequest()->ItemAt($this->datos_horafin->uniqueID));



		



		$acta->lugar        = htmlspecialchars($this->getRequest()->ItemAt($this->datos_lugar->uniqueID));



		$acta->responsable  = htmlspecialchars($this->getRequest()->ItemAt($this->datos_responsable->uniqueID));



		$acta->introduccion = htmlspecialchars($this->getRequest()->ItemAt($this->datos_introduccion->uniqueID));







		$acta->estado 		= htmlspecialchars($this->getRequest()->ItemAt($this->datos_estado->uniqueID));



		



		//Prado::log(var_export($this->getRequest()->ItemAt($this->datos_fecha->uniqueID), true),TLogger::ERROR,'ANDRES');



		



		$this->agregar_mensajes_unicode($acta->save(),'Guardar acta',true);   		



	}



		



		



		



		



		



		



	//GENERACION DEL ACTA	



	public function generar_doc_acta($sender,$param)



    {



	    $this->mensajes->Text = '';



		$this->alertas->Text  = '';







		//DATOS GLOBALES



		$acta 		   = ActasRecord::finder()->findByPk($this->acta_numero);



		



		//sesion en cadena[0] y grupo cadena[1]



		$cadena 	   = explode('-',$acta->id);



		$grupo 		   = GruposRecord::finder()->findByPk($cadena[1]);



		$titulacion    = $grupo->titulacion;



		



		$tipo 		   = $acta->tipo;



		$programa      = ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);



		



		//PLANTILLA



		$nombreArchivo = do_generar_nombre_archivo($grupo->codigo . "_acta_") . 'doc';



		$plantilla     = file_get_contents('doc_guias/acta.rtf');	



		$asistentes    = Null;



		$info_firmas   = Null;



		



		



		



		//AGREGAR PARTICIPANTES



		$result = AsistentesRecord::finder()->findAll('acta_id = ?', array($this->acta_numero));



		foreach ($result as $item)



		{



			$asistentes = $asistentes . '\pard\intbl\itap2\nowidctlpar\lang1034\f2 ' . $item->nombre . '\nestcell ' . $item->rol . '\nestcell{\*\nesttableprops\trowd\trgaph70\trrh396\trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



			\cellx4886\cellx8922\nestrow}{\nonesttables\par}';



			



			$info_firmas = $info_firmas . '\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx1358\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx2822\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx4453\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx5933\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx7425\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx8946\pard\intbl\nowidctlpar ' . $item->nombre . '\cell ' . $item->rol . '\cell ' . $item->entidad . '\cell ' . $item->numero . '\cell ' . $item->correo . '\cell ' . (($item->asistio == 'No') ? 'Ausente' : '') . '\cell\row\trowd\trgaph70\trleft-284\trbrdrl\brdrs\brdrw10\brdrcf1 \trbrdrt\brdrs\brdrw10\brdrcf1 \trbrdrr\brdrs\brdrw10\brdrcf1 \trbrdrb\brdrs\brdrw10\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3';



		}



		



	



		



		//AGREGAR INFORMES



		$proceso = ProcesosRecord::finder()->findAll('acta_id = ? AND tipo = ?', array($this->acta_numero, 'informe'));



		$info_informes = Null;



		



		foreach ($proceso as $item)



		{



			$informe = InformesRecord::finder()->findByPk($item->codigo);



			



			$info_informes = $info_informes . 'Informe presentado por ' . $informe->nombre . 



			' el dia ' . fechalarga($informe->fecha) . ' el cual establece: ' . $informe->descripcion . ' \par\par ';			



		}



		







		



		



		



		//AGREGAR CASOS



		$proceso = ProcesosRecord::finder()->findAll('acta_id = ? AND tipo = ?', array($this->acta_numero, 'caso'));



		$info_compromiso = Null;



		$info_casos = Null;



		$i = 1;



		



		foreach ($proceso as $item)



		{



			  $caso     = CasosRecord::finder()->findByPk($item->codigo);



			  $aprendiz = $caso->aprendiz;



			  $quejoso  = $caso->quejoso; 



			  



			  			  



			  //REGLAMENTO APLICADO AL CASO



			  $normas_especificas = unserialize($caso->tipificaciones);



			  $normas_caso = Null;



			  $conta = 1;



			  foreach ($normas_especificas as $item2)



			  {



					$result = TipificacionesRecord::finder()->findByPk($item2);



					



					$normas_caso = $normas_caso . 



					'\b Tipificación '. $conta  .': \b0'. $result->nombre .



					'. \b Tipo: \b0' . $result->tipo_falta . 



					'. \b Nivel: \b0'. $result->nivel .



					'. \b Normatividad: \b0' . $result->reglamento_aplicado . '.';	



					



					$conta = $conta + 1;



			  }



				



			  if(!$normas_caso)



			   	$normas_caso = 'Reglamento del aprendiz sena';	



			  



			  







			  



			  



			  $decision = DecisionesRecord::finder()->findByPk($item->id);



			  



			  if(count($decision))



			  {



					  $sancion  = $decision->sancion;					  



			          $normas_numerales = 'No aplica.';



					  $normas_decision  = 'No aplica.';



					  //REGLAMENTO ESPECIFICO APLICADO A LA DESICION Y COMPROMISOS ESTANDAR



					 



					  if($decision->sancion_id == 2)



					  {



							



							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Remitir expediente al Subdirector.\nestcell Secretario de comité.\nestcell Dentro de los dos (2) dias hábiles siguientes. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';		







							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Expedir el acto sancionatorio llamado de atención y notificar al aprendiz del mismo con copia a su hoja de vida.\nestcell Subdirector del Centro.\nestcell Dentro de los cinco (5) dias hábiles siguientes a la fecha que considere tiene suficiente ilustración del caso. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';		







							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Concertar con el aprendiz un plan de mejoramiento.\nestcell Instructor: ' .$decision->responsable. '.\nestcell Dentro de los cinco (5) dias hábiles siguientes. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';		



							



							$normas_decision  = 'Reglamento del aprendiz Sena, capitulo IX Medidas formativas' . 



							' y sanciones, articulo 28 Sanciones, párrafo a. Llamado de atención escrito: ' . 



							'Medida sancionatoria que se impone a través de comunicación escrita dirigida por el coordinador académico o de formación del Centro al Aprendiz, con copia a la hoja de vida, como resultado del procedimiento establecido en este reglamento, por la falta académica o disciplinaria cometida por un aprendiz. Los llamados de atención escritos implican compromisos escritos por parte del aprendiz en el proceso de formación.';





					  }



					  elseif($decision->sancion_id == 3)



					  {



							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Remitir expediente al Subdirector.\nestcell Secretario de comité.\nestcell Dentro de los dos (2) dias hábiles siguientes. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';







							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Expedir el acto sancionatorio condicionamiento de la matricula y notificar al aprendiz del mismo.\nestcell Subdirector del Centro.\nestcell Dentro de los cinco (5) dias hábiles siguientes a la fecha que considere tiene suficiente ilustración del caso. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';







							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Concertar con el aprendiz un plan de mejoramiento.\nestcell ' .$decision->responsable. '.\nestcell Dentro de los cinco (5) dias hábiles siguientes. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';	



							



							$normas_decision  = 'Reglamento del aprendiz Sena, capitulo IX Medidas formativas y ' . 



							'sanciones, Articulo 28 de las sanciones, párrafo b. Condicionamiento de la matricula: ' . 



							'Acto académico sancionatorio que se impone al aprendiz  que incurra en una falta académica ' .



							'o disciplinaria previo agotamiento del procedimiento establecido en este Reglamento. El condicionamiento de matricula cesa cuando el Aprendiz cumple el plan de mejoramiento concertado y/o compromisos escritos. Una vez quede en firme el condicionamiento de la matricula, el Subdirector del Centro debe generar la pérdida de estimulos e incentivos que esté recibiendo el aprendiz, si los tuviere. Esta decisión será determinada en el acto académico que ordene el condicionamiento de matricula';



					  



							



							$normas_numerales   = 'Articulo 28 de las sanciones, párrafo b. Condicionamiento de la matricula, ';



							



					  



					  }



					  elseif($decision->sancion_id == 4)



					  {



							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Remitir expediente al Subdirector.\nestcell Secretario de comité.\nestcell Dentro de los dos (2) dias hábiles siguientes. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';







							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Expedir el acto sancionatorio cancelación de la matricula con duración de ' . $decision->duracion .' y notificar al aprendiz del mismo.\nestcell Subdirector del Centro.\nestcell Dentro de los cinco (5) dias hábiles siguientes a la fecha que considere tiene suficiente ilustración del caso. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';



		 



							$normas_decision  = 'Reglamento del aprendiz Sena, capitulo IX Medidas formativas y ' . 



							'sanciones, articulo 28 de las sanciones, párrafo c, cancelación de la matricula: ' .





							'Acto administrativo que se origina cuando persisten en el aprendiz las causales que originaron el condicionamiento de matricula o por faltas catalogadas como graves de acuerdo a la clasificación determinada en los articulos 25 y 26 del reglamento, en las etapas lectiva y productiva. Implica que la persona sancionada pierde la condición de aprendiz y no puede participar en procesos de ingreso a la institución por periodo entre 6 y 12 meses cuando es de indole académico y entre 12 y 24 meses cuando es de indole disciplinaria, de acuerdo a las recomendaciones del comité de evaluación y seguimiento. Una vez en firme la sanción, debe entregar de manera inmediata el carne institucional y ponerse a paz y salvo por todo concepto.';



					  



							$normas_numerales   = 'Articulo 28 de las sanciones, párrafo c. Cancelación de la matricula, ';



					  



					  }



					  elseif($decision->sancion_id == 5)



					  {



							$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Para el Caso ' . $i . ': Citar caso nuevamente.\nestcell Secretario de comité.\nestcell Proxima sesión de comites. \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



							\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';







							$normas_decision  = 'Reglamento del aprendiz Sena, capitulo X Procedimiento para la aplicación de sanciones, articulo 34. Sesión del comité de evaluación y seguimiento';



					  }



					  else



					  {



					      $normas_numerales = 'No aplica.';



					      $normas_decision  = 'No aplica.';



					  



					  }







					  



					  



							



						



									



					  //PARRAFOS DEL REGLAMENTO ESPECIFICO APLICADO A LA DESICION



					  $normas_especificas = unserialize($decision->reglamentos);



					  foreach ($normas_especificas as $item)



					  {



							$result = ReglamentosRecord::finder()->findByPk($item);



							$normas_numerales = $normas_numerales . $result->texto . '. ';



					  }



							



							



					



					 if($decision->incluir == 'Si')



					 {



						  $analisis = 'El comité determina que ' . strtolower($decision->existencia) . ' hubo existencia de la conducta. ' . 



						  $decision->constituye . ' constituye una falta. ' .



						  $decision->probable . ' está probado el probable autor de la falta. ' .



						  'El grado de responsabilidad es ' . strtolower($decision->responsabilidad) . '. ' . 



						  'Los daños causados y sus efectos aplican a ' . mb_strtolower($decision->danos,"UTF-8") . '. ' . 



						  'El grado de participación del aprendiz es ' . strtolower($decision->participacion) . '. ' . 



						  'Los antecedentes del aprendiz son: ' . strtolower($decision->antecedente) . '. ' . 



						  'El rendimiento del aprendiz en su proceso de formación es (fue) ' . strtolower($decision->rendimiento) . '. ' . 



						  'El aprendiz ' . strtolower($decision->confeso) . ' confesó las faltas. ' . 



						  'El aprendiz ' . strtolower($decision->procuro) . ' procuró por iniciativa propia, resarcir el daño causado o compensar el perjuicio causado. ' . 



						  'El comité determina que la conducta de restituir, devolver o reparar el bien afectado: ' . mb_strtolower($decision->reparo,"UTF-8") . '. ' . 



						  'Por lo anterior el comité concluye que el grado de calificación de la falta es ' . mb_strtolower($decision->calificacion,"UTF-8") . 



						  ' y ' . strtolower($decision->amerita) . ' recomienda una sanción';



					 }



					 else



					 {



						  $analisis = 'Se discute y se desglosa la información';



					 } 



					  



					  $info_casos = $info_casos . '\par\par\b Caso ' . $i . ': \b0 A continuación se explica '. 



					  'la normatividad del comité y los hechos en que presuntamente está relacionado el aprendiz. '.



					  'Se recogen las pruebas y los descargos para el esclarecimiento del caso. \b Aprendiz: \b0 '. $aprendiz->nombre 



					  . ' con identificación: ' . $aprendiz->id_tipo . ' ' . $aprendiz->identificacion



					  . '. \b Fecha de Informe: \b0 ' . $caso->fecha 



					  . '. \b Quejoso: \b0' . $quejoso->nombre



					  . '. \b Pruebas Aportadas: \b0' . $caso->pruebas 



					  . '. \b Descripción de Informe: \b0' . $caso->descripcion



					  . '. ' . $normas_caso



					  .	'. \b Descargos del aprendiz: \b0' . $decision->descargo 



					  . '. \b El comité delibera sobre los hechos, en el cual se hace el siguiente análisis: \b0' . $analisis



					  . '. \b Después de analizar el caso el comité hace la siguiente recomendación: \b0' . $sancion->nombre



					  . '. \b Según normatividad: \b0' . $normas_decision;



					  //. '. \b Caso(s) aplicado(s): \b0' . $normas_numerales;



			    }



			    else



				{



					  $info_casos = $info_casos . '\par\par\b Caso ' . $i . ': \b0 A continuación se explica '. 



					  'la normatividad del comité y los hechos en que presuntamente está relacionado el aprendiz. '.



					  'Se recogen las pruebas y los descargos para el esclarecimiento del caso. \b Aprendiz: \b0 '. $aprendiz->nombre 



					  . ' con identificación: ' . $aprendiz->id_tipo . ' ' . $aprendiz->identificacion



					  . '. \b Fecha de Informe: \b0 ' . $caso->fecha 



					  . '. \b Quejoso: \b0' . $quejoso->nombre



					  . '. \b Pruebas Aportadas: \b0' . $caso->pruebas 



					  . '. \b Descripción de Informe: \b0' . $caso->descripcion



					  . '. ' . $normas_caso . '.';



				}



				



				



			  



			  //CONTADOR DE CASOS



		      $i = $i+1;



		}



		



		



		



		



		//COMPROMISOS EXTRAS



		$compromisos = CompromisosRecord::finder()->findAll('acta_id = ?', array($this->acta_numero));



		foreach ($compromisos as $item)



		{



			$info_compromiso = $info_compromiso . '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 ' . $item->descripcion . '\nestcell ' . $item->responsables . '.\nestcell ' . $item->fecha . '.\nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



			\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';	



		}



		



		//VALORES POR DEFECTO



		if(!$info_compromiso)



			$info_compromiso = '\pard\intbl\itap2\nowidctlpar\sa200\sl276\slmult1\ql\b0 Ningún compromiso.\nestcell  \nestcell   \nestcell{\*\nesttableprops\trowd\trgaph70\trleft5\trrh407\trbrdrl\brdrs\brdrw10 \trbrdrt\brdrs\brdrw10 \trbrdrr\brdrs\brdrw10 \trbrdrb\brdrs\brdrw10 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



			\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx2903\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx6306\clbrdrl\brdrw10\brdrs\clbrdrt\brdrw10\brdrs\clbrdrr\brdrw10\brdrs\clbrdrb\brdrw10\brdrs \cellx8994\nestrow}{\nonesttables\par}';



			 



		



		if(!$asistentes)



		{



			$asistentes  = '\pard\intbl\itap2\nowidctlpar\lang1034\f2 Ningún asistente.\nestcell  \nestcell{\*\nesttableprops\trowd\trgaph70\trrh396\trpaddl70\trpaddr70\trpaddfl3\trpaddfr3



			\cellx4886\cellx8922\nestrow}{\nonesttables\par}';



			



			$info_firmas = '\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx1358\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx2822\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx4453\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx5933\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx7425\clbrdrl\brdrw10\brdrs\brdrcf1\clbrdrt\brdrw10\brdrs\brdrcf1\clbrdrr\brdrw10\brdrs\brdrcf1\clbrdrb\brdrw10\brdrs\brdrcf1 \cellx8946\pard\intbl\nowidctlpar Ninguna firma.\cell  \cell  \cell  \cell  \cell  \cell\row\trowd\trgaph70\trleft-284\trbrdrl\brdrs\brdrw10\brdrcf1 \trbrdrt\brdrs\brdrw10\brdrcf1 \trbrdrr\brdrs\brdrw10\brdrcf1 \trbrdrb\brdrs\brdrw10\brdrcf1 \trpaddl70\trpaddr70\trpaddfl3\trpaddfr3';	 



		}



		



		if(!$info_informes)



		     $info_informes = 'Ningún informe para tratar.\par ';



		



		if(!$info_casos)



		     $info_casos = 'Ningún caso para tratar.\par ';



			 







		



		if($acta->introduccion == '' OR $acta->introduccion == ' ')



		   $introduccion = 'Ningún tema a tratar.\par ';



		else



       	   $introduccion = $acta->introduccion;



		



		



		



		//Prado::log(var_export($this->acta_numero, true),TLogger::ERROR,'ANDRES');	



		



		$plantilla = str_replace('#codAct#',$this->acta_numero,$plantilla);



		$plantilla = str_replace('#lugAct#',utf8_decode($acta->lugar),$plantilla);



		$plantilla = str_replace('#fecAct#',fechalarga($acta->fecha),$plantilla);



		$plantilla = str_replace('#horIniAct#',$acta->hora,$plantilla);



		$plantilla = str_replace('#horFinAct#',$acta->horafin,$plantilla);



		$plantilla = str_replace('#proAct#',utf8_decode($programa->nombre),$plantilla);



		$plantilla = str_replace('#tipAct#',utf8_decode($tipo->nombre),$plantilla);



		$plantilla = str_replace('#nomTit#',utf8_decode($titulacion->nombre),$plantilla);



		$plantilla = str_replace('#codTit#',$grupo->codigo,$plantilla);



		$plantilla = str_replace('#parti#',utf8_decode($asistentes),$plantilla);



		$plantilla = str_replace('#desAct#',utf8_decode(nl2br($introduccion)),$plantilla);



		$plantilla = str_replace('#infAct#',utf8_decode(nl2br($info_informes)),$plantilla);



		$plantilla = str_replace('#casAct#',utf8_decode(nl2br($info_casos)),$plantilla);



		



	



		//Prado::log(var_export($info_casos, true),TLogger::ERROR,'ANDRES');	



		



		



		$plantilla = str_replace('#comAct#',utf8_decode($info_compromiso),$plantilla);



		$plantilla = str_replace('#firAct#',utf8_decode($info_firmas),$plantilla);



		



		//cambiar los enter por espacios.



		$plantilla = str_replace('<br />','. ',$plantilla);



				



		//quitar algunas irregularidades debido a los reemplazos



		$plantilla = str_replace('..','. ',$plantilla);



		$plantilla = str_replace(':  ',': ',$plantilla);







		



		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO



		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 



		if(!is_dir($nombre_carpeta)){ 



		  mkdir($nombre_carpeta, 0755); 



		}



		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);



		descargar($nombre_carpeta,$nombreArchivo);



		eliminar_archivo($nombreArchivo);



		



		$this->listar_datos();



		return false;



	}



		



		



		



		



		



		



		



		



		



		



		



		



		



    //GENERACION DE TODOS LOS DOCUMENTOS.



	public function selectItem($sender,$param)



    {



		$item=$param->Item;



		



		$this->mensajes->Text = '';



		$this->alertas->Text = '';



	



	    //Prado::log(var_export($this->DataList->, true),TLogger::ERROR,'ANDRES');



		



		//DATOS DE LA DESICION



		$decision = DecisionesRecord::finder()->findByPk($this->dl_casos->DataKeys[$item->ItemIndex]);



		



		//DATOS GLOBALES



		$proceso    = ProcesosRecord::finder()->findByPk($this->dl_casos->DataKeys[$item->ItemIndex]);



		$caso       = CasosRecord::finder()->findByPk($proceso->codigo);



		$programa   = ProgramasRecord::finder()->findByPk($this->Application->User->Roles[1]);



		$centro     = $programa->centro;



		$aprendiz   = $caso->aprendiz;



		$quejoso    = $caso->quejoso;



		$grupo 	    = $caso->grupo;



		$titulacion = $grupo->titulacion;



		$acta 	    = $proceso->acta;	



					



			



		//DATOS DE TIPIFICACION PARA REGLAMENTO



		$tipificaciones = unserialize($caso->tipificaciones);



		$reglamento = Null;



		$tipos = Null;



		foreach ($tipificaciones as $item)



		{



			$result = TipificacionesRecord::finder()->findByPk($item);



			$reglamento = $reglamento . $result->reglamento_aplicado;



			$tipos = $tipos . ' ' . $result->tipo_falta;



		}



		



		



		$pos = strpos($tipos, 'Académica');



			



		



		if (!$pos === false)



		{



			$numeral_i = 'Académica';







			$pos = strpos($tipos, 'Disciplinaria');



			if (!$pos === false)



	            $numeral_i = $numeral_i . ' y disciplinaria';			  



		}



		else



			$numeral_i = 'Disciplinaria';



		



		



		



		







		



		



		if($decision->sancion_id==2)



	    {



			//PLANTILLA



			$nombreArchivo = do_generar_nombre_archivo($grupo->codigo . "_llamado_atencion_") . 'doc';



			$plantilla = file_get_contents('doc_guias/llamado_atencion_escrito.rtf');	



		}



		else if($decision->sancion_id==3)



		{



			//PLANTILLA



			$nombreArchivo = do_generar_nombre_archivo($grupo->codigo . "_condicionamiento_") . 'doc';



			$plantilla = file_get_contents('doc_guias/condicionamiento.rtf');



			



			$normas  = 'Articulo 23 de las sanciones, párrafo b. Condicionamiento de la matricula, ';



		}



		else if($decision->sancion_id==4)



		{



			//PLANTILLA



			$nombreArchivo = do_generar_nombre_archivo($grupo->codigo . "_cancelacion_") . 'doc';



			$plantilla = file_get_contents('doc_guias/cancelacion.rtf');



			



			$normas  = 'Articulo 23 de las sanciones, párrafo c. Cancelación de la matricula, ';



		}



	



	



	



		//REGLAMENTO ESPECIFICO APLICADO



		$normas_especificas = unserialize($decision->reglamentos);



		$normas = Null;



		foreach ($normas_especificas as $item)



		{



			$result = ReglamentosRecord::finder()->findByPk($item);



			$normas = $normas . $result->texto . '. ';



		}



		



	



	



		



		//REMPLAZOS COMUNES



		$plantilla = str_replace('#codCen#',$centro->codigo,$plantilla);



		$plantilla = str_replace('#nomApre#',utf8_decode($aprendiz->nombre),$plantilla);



		



		$plantilla = str_replace('#nomApreM#',strtoupper(utf8_decode($aprendiz->nombre)),$plantilla);



		



		$plantilla = str_replace('#nomQue#',utf8_decode($quejoso->nombre),$plantilla);



		$plantilla = str_replace('#nomCiu#',utf8_decode($centro->ciudad),$plantilla);



		$plantilla = str_replace('#codAct#',$proceso->acta_id,$plantilla);



		$plantilla = str_replace('#codTit#',$grupo->codigo,$plantilla);



		$plantilla = str_replace('#nomTit#',utf8_decode($titulacion->nombre),$plantilla);



		$plantilla = str_replace('#nomSub#',utf8_decode($centro->subdirector_nombre),$plantilla);



		$plantilla = str_replace('#nomCen#',utf8_decode($centro->nombre),$plantilla);



		$plantilla = str_replace('#reglamento#',utf8_decode($reglamento),$plantilla);



		



		//REEMPLAZOS ESPECIFICOS DE CONDICIONAMIENTOS Y CANCELACIONES



		$plantilla = str_replace('#nomReg#',utf8_decode($centro->regional),$plantilla);



		$plantilla = str_replace('#fecAct#',utf8_decode(fechalarga($acta->fecha)),$plantilla);



		$plantilla = str_replace('#descriCas#',utf8_decode(nl2br($caso->descripcion)),$plantilla);



		$plantilla = str_replace('#pruCas#',utf8_decode(nl2br($caso->pruebas)),$plantilla);



		$plantilla = str_replace('#descarCas#',utf8_decode($decision->descargo),$plantilla);



		$plantilla = str_replace('#resCas#',utf8_decode($decision->responsable),$plantilla);



		$plantilla = str_replace('#tipIdeApre#',utf8_decode($aprendiz->id_tipo),$plantilla);



		$plantilla = str_replace('#ideApre#',utf8_decode($aprendiz->identificacion),$plantilla);



		$plantilla = str_replace('#tipIdeSub#',utf8_decode($centro->subdirector_id_tipo),$plantilla);



		$plantilla = str_replace('#ideSub#',utf8_decode($centro->subdirector_id),$plantilla);



		$plantilla = str_replace('#existe#',strtolower($decision->existencia),$plantilla);



		$plantilla = str_replace('#consti#',$decision->constituye,$plantilla);



		$plantilla = str_replace('#proba#',$decision->probable,$plantilla);



		$plantilla = str_replace('#respon#',strtolower($decision->responsabilidad),$plantilla);



		$plantilla = str_replace('#danos#',strtolower(utf8_decode($decision->danos)),$plantilla);



		$plantilla = str_replace('#parti#',strtolower($decision->participacion),$plantilla);



		$plantilla = str_replace('#antece#',strtolower(utf8_decode($decision->antecedente)),$plantilla);



		$plantilla = str_replace('#rendimi#',strtolower($decision->rendimiento),$plantilla);



		$plantilla = str_replace('#confe#',strtolower($decision->confeso),$plantilla);



		$plantilla = str_replace('#procu#',strtolower($decision->procuro),$plantilla);



		$plantilla = str_replace('#reparo#',strtolower(utf8_decode($decision->reparo)),$plantilla);



		$plantilla = str_replace('#califica#',strtolower(utf8_decode($decision->calificacion)),$plantilla);



		$plantilla = str_replace('#ameri#',strtolower($decision->amerita),$plantilla);



		$plantilla = str_replace('#tipo#',utf8_decode($numeral_i),$plantilla);



		



		



		$plantilla = str_replace('#desdura#',utf8_decode($decision->duracion),$plantilla);



	



		



		$plantilla = str_replace('#casEspe#',utf8_decode($normas),$plantilla);



		



		$plantilla = str_replace('#nomPro#',utf8_decode($programa->nombre),$plantilla);



		$plantilla = str_replace('#nomCoo#',utf8_decode($programa->coordinador_nombre),$plantilla);



		$plantilla = str_replace('#ideCoo#',$programa->coordinador_id,$plantilla);



		$plantilla = str_replace('#tipIdeCoo#',$programa->coordinador_id_tipo,$plantilla);



		



		//cambiar los enter por espacios.



		$plantilla = str_replace('<br />','. ',$plantilla);



		



		//quitar algunas irregularidades debido a los reemplazos



		$plantilla = str_replace('..','. ',$plantilla);



		$plantilla = str_replace(':  ',': ',$plantilla);



	







		//FUNCION PARA INDEPENDIZAR LA CREACION Y BORRADO DE CADA CENTRO



		$nombre_carpeta = 'doc_generados/' . $this->Application->User->Roles[1] . '/'; 



		if(!is_dir($nombre_carpeta)){ 



		  mkdir($nombre_carpeta, 0755); 



		}



		file_put_contents($nombre_carpeta . $nombreArchivo,$plantilla);



		descargar($nombre_carpeta,$nombreArchivo);



		eliminar_archivo($nombreArchivo);



		



		$this->listar_datos();



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