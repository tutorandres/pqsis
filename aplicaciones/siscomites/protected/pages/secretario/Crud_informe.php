<?php

/* 

 * Generado por el Ingeniero:

 * Andrés Augusto García Pineda.

 * Proyecto SENACOMITES con prado framework.

 */

Prado::using('System.Web.UI.ActiveControls.*');





 

class Crud_informe extends TPage

{



    var $total_registros;

	

     

    public function onLoad($param)

    {

        parent::onLoad($param);

        if(!$this->IsPostBack)

        {

            $this->DataList->DataSource=$this->Data;

            $this->DataList->dataBind();	

		}

	

		$this->paginar();

		

			$this->usuario->Text = '<b>Usuario: </b>'  . $this->Application->User->Roles[7] . '.<br/>' . 

								   '<b>Rol: </b>'      . $this->Application->User->Roles[0] . '.<br/>' . 

								   '<b>Centro: </b>'   . $this->Application->User->Roles[5] . '.<br/>';



	

	}						   



 

 

    public function getData($limit = 0)

    {   

		$casos = Null;

		$result = Null;

		

		

		//$this->grupo->items->clear();

		

	    if($limit > 0)

			$limit  = 'LIMIT ' .  $limit;

		else

         	$limit  = ' ';	

		

		

		

		

		//CONSTRIR EL ARRAY DE GRUPOS

		$criteria->OrdersBy['id'] = 'asc';

		$criteria->Condition = 'estado=1';

			   

		$result = GruposRecord::finder()->findAll($criteria);

			   

		if(count($result))

        {

			foreach ($result as $item) {

			         $titulacion = $item->titulacion;        

					 $grupos[] = array('id'      => $item->id,

								       'nombre' =>  $item->codigo . ' ' . $titulacion->nombre);

            }			   

		}

		else

			$grupos = Null;

		

		

		$result = InformesRecord::finder()->findAllBySql('

					SELECT informes.id, grupo_id, descripcion, nombre, 

					identificacion, identificacion_tipo, correo, fecha

					FROM `informes` 

					INNER JOIN `grupos` ON informes.grupo_id = grupos.id

					WHERE informes.estado=1 AND grupos.programa_id=' . $this->Application->User->Roles[1] . ' ' . $limit);	

		

		

		//Prado::log(var_export($result, true),TLogger::ERROR,'ANDRES');

		

		if(count($result))

		{

			foreach ($result as $informe) 

			{

				  $grupo 		= 	$informe->grupo;

				  $titulacion  =    $grupo->titulacion;

				   			   

			      $casos[] = array('id' 			 		=> $informe->id,

								'descripcion' 	 		=> $informe->descripcion,

								'grupo_id' 		        => $informe->grupo_id,

								'codigo' 		        => $grupo->codigo,

								'grupo_nombre' 		    => $titulacion->nombre,

								'grupos'	 		    => $grupos,

								'identificacion' 		=> $informe->identificacion,

								'nombre' 		 		=> $informe->nombre,

								'correo' 			 	=> $informe->correo,

								'identificacion_tipo' 	=> $informe->identificacion_tipo,

								'fecha' 		 		=> $informe->fecha); 

				  	  

		    }

			

			$this->Pager->Visible = true; 

			

		}	

		else

		{

					

			$this->agregar_mensajes_unicode(true,'Ningún registro encontrado',false);

			$this->DataList->items->clear();

			$this->Pager->Visible = false;

		}



			

		$this->total_registros = count($casos);

		

		

		//ORDENA EL ARRAY

		if(count($casos) > 0)

		     usort($casos, array('Crud_informe','comparar'));



		

		return $casos;	

		

				



    }

 

     

	public function editItem($sender,$param)

    {

        $this->DataList->SelectedItemIndex=-1;

        $this->DataList->EditItemIndex=$param->Item->ItemIndex;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

		

		$this->mensajes->Text = '';

	   $this->alertas->Text = '';

		

		$this->paginar();

    }

 

	 

	public function cancelItem($sender,$param)

    {

        $this->DataList->SelectedItemIndex=-1;

        $this->DataList->EditItemIndex=-1;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

		

		$this->mensajes->Text = '';

	   $this->alertas->Text = '';

		

		$this->paginar();

    }

 

	 

	 

	 

	public function deleteItem($sender,$param)

    {

		$this->mensajes->Text = '';

	    $this->alertas->Text = '';

		

		try {



			$this->agregar_mensajes_unicode(InformesRecord::finder()->deleteByPk($this->DataList->DataKeys[$param->Item->ItemIndex]),'Eliminar informe',true);

		

		 } catch (Exception $e) {

                

				$this->agregar_mensajes_unicode(false,'Compruebe que el informe que intenta eliminar

				no se encuentra programado. Deberá eliminar las programaciones primero.',false);	

         }	

		

		

		$this->DataList->SelectedItemIndex=-1;

        $this->DataList->EditItemIndex=-1;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

		

		$this->paginar();

    }

	

	

	

	

	public function updateItem($sender,$param)

    {

        $item=$param->Item;

		

		//ACTUALIZAMOS DATOS DEL INFORME

		$InformesRecord = InformesRecord::finder()->findByPk($this->DataList->DataKeys[$item->ItemIndex]);

		$InformesRecord->descripcion = TPropertyValue::ensureString(htmlspecialchars($item->descripcion->Text));

		$InformesRecord->grupo_id = TPropertyValue::ensureString(htmlspecialchars($item->grupo->Text));		

		$InformesRecord->fecha = htmlspecialchars($item->fecha->getDate());

		$InformesRecord->identificacion = TPropertyValue::ensureString(htmlspecialchars($item->identificacion->Text));

		$InformesRecord->nombre = TPropertyValue::ensureString(mb_convert_case(htmlspecialchars($item->nombre->Text),MB_CASE_TITLE,"UTF-8"));

		$InformesRecord->correo = TPropertyValue::ensureString(htmlspecialchars($item->correo->Text));

		$InformesRecord->identificacion_tipo = TPropertyValue::ensureString(htmlspecialchars($item->identificacion_tipo->Text));

		

		$this->agregar_mensajes_unicode($InformesRecord->save(),'Editar informe',true);

		



        $this->DataList->EditItemIndex=-1;

        $this->DataList->DataSource=$this->Data;

        $this->DataList->dataBind();

		

		$this->paginar();

		

    }

	



	



	 

	public function pageChanged($sender,$param)

    {

        $this->DataList->CurrentPageIndex=$param->NewPageIndex;

        $this->populateData();

		

		$this->mensajes->Text = '';

	   $this->alertas->Text = '';

		

		return 0;

    }

 

	protected function populateData()

    {

        $offset=$this->DataList->CurrentPageIndex*$this->DataList->PageSize;

        $limit=$this->DataList->PageSize;

		

        if($offset+$limit>$this->DataList->VirtualItemCount)

            $limit=$this->DataList->VirtualItemCount-$offset;

        $data=$this->getData($limit);

        $this->DataList->DataSource=$data;

        $this->DataList->dataBind();

		

		$this->paginar($offset);

	}





	 	protected function paginar($offset = 0)

		{

			

		  if($this->total_registros > 0)

			{

				if(($offset+$this->DataList->PageSize) > $this->total_registros)

				  $this->paginacion->Text = 'Mostrando del ' . ($offset+1) . ' al ' . ($offset + ($this->total_registros - $offset)) . ' de un total de ' . $this->total_registros . ' registros.';	

				else

				  $this->paginacion->Text = 'Mostrando del ' . ($offset+1) . ' al ' . ($offset+$this->DataList->PageSize) . ' de un total de ' . $this->total_registros . ' registros.';	

			}

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

		

		

		

		 function comparar($x, $y){



				  if ( $x['codigo'] == $y['codigo'] )

					 return 0;

				  else if ( $x['codigo'] > $y['codigo'] )

					 return -1;

				  else

					 return 1;



		}



	  

}

 

?>