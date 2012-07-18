<?php

/* 

 * Generado por el Ingeniero:

 * Andr?Augusto Garc?Pineda.

 * Proyecto SENACOMITES con prado framework.

 */

Prado::using('System.Web.UI.ActiveControls.*');





class Procesar_caso_acta extends TPage

{

   

    

    public function onPreInit($param){

        $this->MasterClass="Application.layouts.MainLayout";

		$this->Title="Procesar Caso";		

    } 

   

       

	public function onLoad($param)

    {

        parent::onLoad($param);

		
		//MODIFIQUE LA OCULTACION DE LOS DATOS
		//PORQUE YA NO SE NECESITAN PERO NO BORRE NADA SIMLLEMENTE
		//LOS OCULTE PERO TODFA LA LOGIA Y LA BASE DE DATOS ESTAN LISTOS.
		//$this->duracion->setVisible(false);
		$this->reglamentos->setVisible(false);
		
		

		   if(!$this->getPage()->getIsPostBack())

		   {



				$decision = DecisionesRecord::finder()->findByPk(array($this->request['proceso_id']));

				

				if(!count($decision))

				{

					$datos = new DecisionesRecord();

									

					$datos->id 		 		= $this->request['proceso_id'];

					$datos->descargo 		= '';

					$datos->existencia 		= 'Si hubo';

					$datos->constituye 		= 'Si';

					$datos->probable 		= 'Esta probado';

					$datos->responsabilidad = 'Alto';

					$datos->danos 			= 'Su formacion';

					$datos->participacion 	= 'Alto';

					$datos->antecedente 	= 'Anotaciones en libro de seguimiento';

					$datos->rendimiento 	= 'Regular';

					$datos->confeso 		= 'Si';

					$datos->procuro		 	= 'No';

					$datos->reparo		 	= 'No aplica';

					$datos->calificacion    = 'Grave';

					$datos->incluir		 	= 'Si';

					$datos->amerita		 	= 'Si';

					$datos->responsable	    = 'Instructor';

					$datos->reglamentos	 	= 'a:0:{}';

					$datos->duracion	 	= '6 Meses';



					$this->agregar_mensajes_unicode($datos->save(),'Agregar desicion',false);	

				}



					$decision = DecisionesRecord::finder()->findByPk(array($this->request['proceso_id']));

				

					$this->decision_id->Text 	 = $decision->id;

					$this->descargo->Text 		 = $decision->descargo; 		

					$this->existencia->Text 	 = $decision->existencia; 		

					$this->constituye->Text 	 = $decision->constituye; 		

					$this->probable->Text 		 = $decision->probable; 			

					$this->responsabilidad->Text = $decision->responsabilidad; 	

					$this->danos->Text 			 = $decision->danos; 				

					$this->participacion->Text 	 = $decision->participacion; 		

					$this->antecedente->Text 	 = $decision->antecedente; 		

					$this->rendimiento->Text 	 = $decision->rendimiento; 

					$this->confeso->Text 		 = $decision->confeso; 		

					$this->procuro->Text 		 = $decision->procuro;	

					$this->reparo->Text 		 = $decision->reparo;	

					$this->calificacion->Text 	 = $decision->calificacion;    

					$this->incluir->Text 		 = $decision->incluir;	

					$this->amerita->Text 		 = $decision->amerita;	

					$this->responsable->Text 	 = $decision->responsable;

					$this->duracion->Text 	     = $decision->duracion;



					



					$criteria = new TActiveRecordCriteria;

					$criteria->OrdersBy['id'] = 'asc';

					$finder = SancionesRecord::finder();

					$this->sancion_id->DataSource=$finder->findAll($criteria);

					$this->sancion_id->DataTextField='nombre';

					$this->sancion_id->DataValueField='id';

					$this->sancion_id->Selectedvalue = $decision->sancion_id;

					$this->sancion_id->dataBind();

					

					

					

					

					//CONTRUIR EL ARRAY DE REGLAMENTOS 

					$datos = ReglamentosRecord::finder()->findAll();

									   

					if(count($datos))

					{

					  foreach ($datos as $reglamento)

					   {

						   $reglamentos[] = array( 'id' 	=> $reglamento->id, 

												   'nombre' => $reglamento->nombre);

					   }

					}

					else

					  $reglamentos = Null;

					

					

					

					$this->reglamentos->DataSource = $reglamentos;

					$this->reglamentos->SelectedValues = unserialize($decision->reglamentos);						

					$this->reglamentos->dataBind();

					

					

		

         }				  

	}

	

	

	

	public function guardar($sender,$param)

    {

	    $this->mensajes->Text = '';

		$this->alertas->Text = '';

	

		$datos = DecisionesRecord::finder()->findByPk($this->decision_id->Text);

		

		$datos->id 		 		= TPropertyValue::ensureInteger($this->decision_id->Text);		

		$datos->descargo    	= TPropertyValue::ensureString($this->descargo->Text);

		$datos->existencia  	= TPropertyValue::ensureString($this->existencia->Text);

		$datos->constituye  	= TPropertyValue::ensureString($this->constituye->Text);

		$datos->probable  		= TPropertyValue::ensureString($this->probable->Text);

		$datos->responsabilidad = TPropertyValue::ensureString($this->responsabilidad->Text);

		$datos->danos 			= TPropertyValue::ensureString($this->danos->Text);

		$datos->participacion 	= TPropertyValue::ensureString($this->participacion->Text);

		$datos->antecedente 	= TPropertyValue::ensureString($this->antecedente->Text);

		$datos->rendimiento 	= TPropertyValue::ensureString($this->rendimiento->Text);

		$datos->confeso 		= TPropertyValue::ensureString($this->confeso->Text);

		$datos->procuro 		= TPropertyValue::ensureString($this->procuro->Text);

		$datos->reparo 			= TPropertyValue::ensureString($this->reparo->Text);

		$datos->calificacion 	= TPropertyValue::ensureString($this->calificacion->Text);

		$datos->incluir 		= TPropertyValue::ensureString($this->incluir->Text);

		$datos->amerita 		= TPropertyValue::ensureString($this->amerita->Text);

		$datos->responsable 	= TPropertyValue::ensureString($this->responsable->Text);

		//$datos->reglamentos 	= serialize($this->reglamentos->getSelectedValues());
		//$datos->duracion	 	= TPropertyValue::ensureString($this->duracion->Text);
		
		$datos->reglamentos	 	= 'a:0:{}';

		$datos->duracion	 	= TPropertyValue::ensureString($this->duracion->Text);
					
		$datos->sancion_id	 	= TPropertyValue::ensureInteger($this->sancion_id->Text);

		

		

		

		if($datos->save())

		{

		   $this->agregar_mensajes_unicode(true,'Editar desicion',false); 

		   $datos2 = ProcesosRecord::finder()->findByPk($this->decision_id->Text);

		   $datos2->estado = TPropertyValue::ensureInteger($this->sancion_id->Text);

		   $this->agregar_mensajes_unicode($datos2->save(),'Editar proceso',false); 

		}    

		else

		   $this->agregar_mensajes_unicode(false,'Editar decisión',false);  

			

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