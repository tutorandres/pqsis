<%@ MasterClass="Application.layouts.MainLayout" %>

<com:TContent ID="Main">


<div id="wrap">


	<div id="header">
		<div id="header-content" style="position:absolute;left:255px;">
			
			<h1 id="logo">
			<img src="themes/Basic/logo_siscomites.png" href="index.php?page=inicio.Pagina_principal" alt="logo" border="0" width="134" height="125"/>
			</h1>
			<h2 id="slogan">SISComit&eacute;s [VERSI&Oacute;N.7.0.JUNIO.2012] - [Aplica Reglamento Versi&oacute;n Febrero de 2012]</h2>
			<ul>
				<li><a href="index.php?page=inicio.Pagina_principal">P&aacute;gina Principal</a></li>
				<li><a href="index.php?page=inicio.Informar_contacto">Contacto</a></li>
				<li><a href="index.php?page=inicio.Informar_ayuda">Ayuda</a></li>
				<li><a href="index.php?page=inicio.Informar_cronica">Cr&oacute;nica</a></li>
			</ul>
		</div>
	</div>

	<div class="headerphoto">
		<!--
		<object type="application/x-shockwave-flash" data="themes/Basic/banner.swf" width="600" height="400">
        <param name="movie" value="themes/Basic/banner.swf" />
        <param name="loop" value="true" />
        alt : <a href="themes/Basic/banner.swf"></a>
        </object> 
		-->
        <img src="themes/Basic/headers/<%% echo $_POST["img"]; %>.jpg" alt="Mensaje" width="748" height="300"/>
    </div>
	
	
	
	<div id="content-wrap"><div id="content">

		<div id="sidebar" >


			<div class="sidebox">
			<h1 class="clear">Men&uacute;</h1>
                        <com:TLabel ID="subMenu"  Text="" />
			</div>

            <div class="sidebox">
            <span class="date_reloj"><%% date_default_timezone_set("America/Bogota"); echo date("d/m/y, g:i a"); %></span>
			</div>
			
			<div class="sidebox" align="left">
                 
				 <com:TContentPlaceHolder ID="informacion" />
				 
			</div>

		</div>

		<div id="main">

			<div class="post">

                        <com:TContentPlaceHolder ID="contenido" />

			</div>

		</div>


	</div></div>

	<div id="footer"><div id="footer-content" 	style="position:absolute;left:235px;">

		<div class="col float-left">
			<h1>Colaboraciones De Terceros</h1>
			<ul>
				<li><a title="Powered by PRADO" target="_blank" href="http://www.pradosoft.com/" ><strong>PRADO Framework </strong><img src="themes/Basic/powered2.gif" style="border-width:0px;" alt="Powered by PRADO" /></a></li>
				<li><a href="http://www.styleshout.com/" target="_blank"><strong>PixelGreen 1.2 - styleshout.com</strong> - Is a free, W3C-compliant, CSS-based website template</a></li>
				<li><%% echo visitas(); %></li>	
			</ul>
		</div>



		<div class="col float-left">
			<h1>Enlaces Institucionales</h1>
			<ul>
				<li><a href="http://www.senasofiaplus.edu.co" target="_blank">Abrir Sofia Plus</a></li>
				<li><a href="http://www.sena.edu.co" target="_blank">P&aacute;gina Principal SENA</a></li>
				<li><a href="http://www.senavirtual.edu.co" target="_blank">Formaci&oacute;n Virtual</a></li>
				<li><a href="http://www.misena.edu.co" target="_blank">Correo Misena</a></li>
			</ul>
		</div>

		<div class="col2 float-right">
		<p>
		&copy; 2009 - 2011 Licencia
        <a rel="license" href="http://creativecommons.org/licenses/by-sa/2.5/co/"><img alt="Licencia de Creative Commons" style="border-width:0" src="themes/Basic/88x31.png" /></a><br />Esta obra est&aacute; bajo una <a rel="license" href="http://creativecommons.org/licenses/by-sa/2.5/co/">licencia de Creative Commons Attribution-ShareAlike 2.5 Colombia</a>.

        <strong>Ingeniero Andr&eacute;s A. Garc&iacute;a Pineda. <br />Instructor Centro de Comercio y Turismo Armenia Quind&iacute;o.</strong>
		<a href="mailto:andresgarcia@misena.edu.co">-Clic Aqu&iacute; para contactar-</a>
		</p>

		<ul>
			<li><a href="index.php?page=inicio.Pagina_principal"><strong>P&aacute;gina Principal</strong></a></li>
			<li><a href="index.php?page=inicio.Informar_mapa"><strong>Mapa del sitio</strong></a></li>
		</ul>
		</div>
</div></div>

</div>

</com:TContent>



