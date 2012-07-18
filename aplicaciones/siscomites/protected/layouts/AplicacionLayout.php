<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
Prado::using('Application.libraries.funciones');
 
class AplicacionLayout extends TTemplateControl
{
	

    public function onLoad($param)
    {
        parent::onLoad($param);

			date_default_timezone_set("America/Bogota");
				
			if($this->Application->User->IsGuest)
			{		
				$this->subMenu->Text =
				'<ul class="sidemenu">' . 
				'<li><a href="index.php?page=usuarios.Usuario_login">Iniciar Sesi&oacute;n</a></li>'.
				'<li><a href="index.php?page=inicio.Pagina_principal">P&aacute;gina Principal</a></li>'.
				'</ul>';	
			}
			elseif($this->Application->User->Name == 'Instructor')
            {		
				$this->subMenu->Text =
				'<ul class="sidemenu">' . 
				'<li><a href="index.php?page=instructor.Enviar_caso">Enviar caso</a></li>'.
				'<li><a href="index.php?page=instructor.Enviar_informe">Enviar Informe General</a></li>'.
				'<li><a href="index.php?page=instructor.Consultar_casos_informes">Consultar Por Quejoso</a></li>'.
				'<li><a href="index.php?page=instructor.Consultar_grupo">Consultar Por Grupo</a></li>'.
				'<li><a href="index.php?page=instructor.Consultar_programacion">Consultar Programaci&oacute;n</a></li>'.
				/*'<li><a target="_blank" href="index.php?page=usuarios.Usuario_reglamento_sancion">Reglamento Sanciones</a></li>'.*/
				'<li><a target="_blank" href="index.php?page=usuarios.Usuario_reglamento_tipificacion">Reglamento Tipificaciones</a></li>'.
				'<li><a target="_blank" href="http://revisor.com.ar">Abrir Corrector Ortogr&aacute;fico</a></li>'.
				'<li><a href="index.php?page=usuarios.Usuario_cerrar">Cerrar Sesi&oacute;n</a></li>'.
				'</ul>';    
			}			
			elseif($this->Application->User->Name == 'Secretario')
            {		
				$this->subMenu->Text =
				'<ul class="sidemenu">' .
                '<li><a href="index.php?page=secretario.Modificar_usuario">Cambiar Contrase&ntilde;as</a></li>'.				
				'<li><a href="index.php?page=secretario.Datos_centro">Datos Centro</a></li>'.
				'<li><a href="index.php?page=secretario.Datos_coordinacion">Datos Coordinaci&oacute;n</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_integrante">Asistentes por reglamento</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_grupo">Grupos</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_caso">Casos</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_informe">Informes</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_trimestres">Trimestres</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_sesion">Sesiones</a></li>'.
				'<li><a href="index.php?page=secretario.Programar_sesion">Programar Sesi&oacute;n</a></li>'.
				'<li><a href="index.php?page=secretario.Ejecutar_sesion">Ejecutar Sesi&oacute;n</a></li>'.
				'<li><a href="index.php?page=secretario.Casos_pendientes">Casos Pendientes</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_titulaciones">Titulaciones</a></li>'.
				'<li><a href="index.php?page=secretario.Crud_tipificaciones">Tipificaciones</a></li>'.
				'<li><a href="index.php?page=secretario.Datos_administracion">Datos Secretario</a></li>'.
				'<li><a target="_blank" href="index.php?page=secretario.Compartir_info">Documento Compartido</a></li>'.
				/*'<li><a target="_blank" href="index.php?page=usuarios.Usuario_reglamento_sancion">Reglamento Sanciones</a></li>'.*/
				'<li><a target="_blank" href="index.php?page=usuarios.Usuario_reglamento_tipificacion">Reglamento Tipificaciones</a></li>'.
				'<li><a href="index.php?page=instructor.Enviar_caso">Enviar caso</a></li>'.
				'<li><a href="index.php?page=instructor.Enviar_informe">Enviar Informe General</a></li>'.
				'<li><a href="index.php?page=instructor.Consultar_casos_informes">Consultar Por Quejoso</a></li>'.
				'<li><a href="index.php?page=instructor.Consultar_grupo">Consultar Por Grupo</a></li>'.
				'<li><a target="_blank" href="http://revisor.com.ar">Abrir Corrector Ortogr&aacute;fico</a></li>'.
				'<li><a href="index.php?page=usuarios.Usuario_cerrar">Cerrar Sesi&oacute;n</a></li>'.

				'</ul>';    
			}

   }
   
	
}
?>
