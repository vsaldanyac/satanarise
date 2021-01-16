<?php

switch ($page->concurs)
{
case 'bajopresion_old':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));
			$videoclip=strip_tags(rtrim($_POST['videoclip']));
			if (strlen($name) == 0) {
				$correcte=0;
				$error[0]=1;
			}
			if (strlen($videoclip) == 0) {
				$correcte=0;
				$error[2]=1;
			}
			if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))) {
				$error[1]=1;
				$correcte=0;
			}
			if ($correcte == 0) {
				$error_detall=array();
				if ($error[0]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido ningún nombre.<br />';
					$error_detall[1] = $error_detall[1].'No has introduït cap nom.<br />';
				}
				if ($error[1]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido un mail correcto.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït un mail correcte.<br />';						
				}
				if ($error[2]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido el nombre del videoclip.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït el nom d\'un videoclip.<br />';						
				}
				
				switch ($page->leng)
				{
					case 'ES':
						print '<p class="error">'.$error_detall[0].'</p>';
					break;
					case 'CAT':
						print '<p class="error">'.$error_detall[1].'</p>';
					break;
				}
			}
			if ($correcte==1) {
				switch ($page->leng) 
				{
					case 'ES':
					print '<p class="error">Gracias por participar.</p>';
					break;
					case 'CAT':
						print '<p class="error">Gracies per participar.</p>';
					break;
					
				}
				$subject='Sorteig BajopresióN';
				$message="Concurs BajopresióN<br />enviat per: $name \r\n amb el mail $email \r\n Títol del videoclip: $videoclip";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo BajopresióN en Bcn</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig BajopresióN a Bcn</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				<div class="centrar"><img src="pics/conc/20181227173140.jpg" width="315"  alt="BajopresióN" /></div>
	
				
	
				<p class="cc">
				BajopresióN se presenta en Barcelona en la sala Monasterio el próximo día 2 de Febrero a presentar su nuevo trabajo llamado La Máquina de Sueños. Lo hará junto a la banda Emboque y no queremos que te lo pierdas!<br /><br />
				Para ello, sorteamos 4 entradas sencillas para que puedas asistir, y disfrutar de este evento tan especial.<br /><br />
				
				Puedes mandarnos un e-mail a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre, tu correo electrónico y el título del último videoclip publicado por la banda, o rellena el siguiente formulario.
				<br /><br />
				Tienes tiempo para participar, pues el sorteo se cerrará el próximo día 15 de Enero a las 0:00h!!!<br /> <br />
				Mucha suerte!!!!
				</p>
               
				
				<div id="formulari">
		<?php
		
		
		$name='';
		$email='';
		$videoclip='';
		$correcte = 0;
	}
	if ($correcte == 0) {
		
	
	
		print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>";
		print '<table class="form" cellpadding="2" cellspacing="3">';
		print '<tr onmouseover="posarDescripcioNom(';
		switch ($page->leng)

		{
			case 'ES':
				print "'Escribe tu nombre'";
			break;
			case 'CAT':
				print "'Escriu el teu nom'";
			break;
		}
		print ')" onmouseout="borrarDescripcioNom()">';
		print '<td class="celdaesq">';
		switch ($page->leng)
		{
			case 'ES':
				print "Nombre:";
			break;
			case 'CAT':
				print "Nom:";
			break;
		}
		print '</td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="name" size="35" maxlength="200" value="'.$name.'" /></td>';
		print '<td class="celdadreta"><span id="descripcioNom"></span></td>';
		print '</tr><tr onmouseover="posarDescripcioMail(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe tu e-mail'";
			break;
			case 'CAT':
				print "'Escriu el teu e-mail'";
			break;
		}
		print ')" onmouseout="borrarDescripcioMail()">';
		print '<td class="celdaesq">e-mail: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="email" size="35" maxlength="200" value="'.$email.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioMail"></span></td>';
		print '</tr><tr onmouseover="posarDescripcioVideoclip(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe el título del videoclip'";
			break;
			case 'CAT':
				print "'Escriu el nom del videoclip'";
			break;
		}
		print ')" onmouseout="borrarDescripcioVideoclip()">';
		print '<td class="celdaesq">videoclip: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="videoclip" size="35" maxlength="200" value="'.$videoclip.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioVideoclip"></span></td>';
		print '</tr>';
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div>
		<div class="centrar">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/OxlxuhN00TQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/k8RXjVrPwIc" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		<iframe width="560" height="315" src="https://www.youtube.com/embed/laLyiZK7E24" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		</div>';
		
	}
break;
case 'fournoses':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			if (strlen($name) == 0) {
				$correcte=0;
				$error[0]=1;
			}
			if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))) {
				$error[1]=1;
				$correcte=0;
			}
			if ($correcte == 0) {
				$error_detall=array();
				if ($error[0]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido ningún nombre.<br />';
					$error_detall[1] = $error_detall[1].'No has introduït cap nom.<br />';
				}
				if ($error[1]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido un mail correcto.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït un mail correcte.<br />';						
				}
				
				switch ($page->leng)
				{
					case 'ES':
						print '<p class="error">'.$error_detall[0].'</p>';
					break;
					case 'CAT':
						print '<p class="error">'.$error_detall[1].'</p>';
					break;
				}
			}
			if ($correcte==1) {
				switch ($page->leng) 
				{
					case 'ES':
					print '<p class="error">Gracias por participar.</p>';
					break;
					case 'CAT':
						print '<p class="error">Gracies per participar.</p>';
					break;
					
				}
				$subject='Sorteig Four Noses';
				$message="Concurs Four Noses<br />enviat per: $name \r\n amb el mail $email \r\n ";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Four Noses</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Four Noses</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/conc/20190409000352.jpg" width="300"  alt="four noses" /></div>
	
				
	
				<p class="cc">
				La banda Four Noses ha publicado su nuevo trabajo llamado Inmortal. Además lo presentará en vivo en la sala Monasterio de Barcelona el próximo 17 de Mayo.<br /><br />
				Hemos sorteado una entrada + CD para asistir y disfrutar de su nuevo trabajo tanto en directo como en casa, en el coche,...<br /><br />
				y ya tenemos el ganador!!!!<br /><br />
				
·	Albert Medrano<br /><br />
				E N H O R A B U E N A   ! ! ! 
				<br /><br />
				Te hemos mandado un correo electrónico con las instrucciones para que puedas recoger tu entrada y CD en taquilla!

</p>	
	
				<div class="centrar">
                    <img src="pics/covers/fournoses_inmortal.jpg" width="375" align="middle" /><br />
					<img src="pics/sorteig/fournoses_tracklist.jpg" width="300" align="middle" />
                </div>
                </p>
                

			</div>
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/conc/20190409000352.jpg" width="300"  alt="four noses" /></div>
	
				
	
				<p class="cc">
				La banda Four Noses ha publicat el seu nou treball que porta per nom Inmortal. A més el presentarà en viu a la sala Monasterio de Barcelona el proper 17 de Maig.<br /><br />
				Així que gràcies a la banda, hem sortegejat una entrada + CD per assistir i gaudir del seu nou treball tant en directe como a casa, al cotxe,...<br /><br />
				i ja tenim guanyador!<br /><br />

	· Albert Medrano
	<br /><br />
				E N H O R A B O N A   ! ! ! 
				<br /><br />
				T'hem enviat un correu electrónic amb les instruccions per a que puguis recollir la teva entrada i CD a la guixeta!
</p>


<div class="centrar">
                    <img src="pics/covers/fournoses_inmortal.jpg" width="375" align="middle" /><br />
					<img src="pics/sorteig/fournoses_tracklist.jpg" width="300" align="middle" />
                </div>
                </p>
        
        


			</div>
		<?php
		}
		
		
	
	}
break;
case 'madmax':
	
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Mad Max</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Mad Max</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				
	<div class="centrar"><img src="pics/sorteig/madmax.png" width="350"  alt="Mad Max" /></div>
				
	
				<p class="cc">
					Ya tenemos ganadores del sorteo de dos entradas sencillas para ver el próximo 12 de Septiembre a la banda alemana Mad Max, formada en 1981.
				Nos presentarán su último trabajo "35" así como sus grandes clásicos. Puedes verlos en vivo en gira, en la sala Monasterio de Barcelona, la cual ha tenido el detalle junto a Kivents de darnos para sortear 2 entradas individuales.<br /><br />
				Los ganadores han sido: <br /><br />
				· Matilde Sebastián Pérez<br />
				· Francisco Ramos Gómez
				<br /><br />
				Hemos contactado con vosotros vía email, para que podáis recoger vuestra entrada en taquilla!!<br /><br />
				Gracias por confiar en Satan Arise!!!!
				</p>
        
        <div class="centrar"><iframe width="420" height="315" src="//www.youtube.com/embed/7mP7LIFhBKs" frameborder="0" allowfullscreen></iframe></div>       
			</div>
		<?php
		
		
break;
case 'soto':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			$ciutat=strip_tags(rtrim($_POST['ciutat']));		
			if (strlen($name) == 0) {
				$correcte=0;
				$error[0]=1;
			}
			if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))) {
				$error[1]=1;
				$correcte=0;
			}
			if (strlen($ciutat) == 0) {
				$correcte=0;
				$error[2]=1;
			}
			if ($correcte == 0) {
				$error_detall=array();
				if ($error[0]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido ningún nombre.<br />';
					$error_detall[1] = $error_detall[1].'No has introduït cap nom.<br />';
				}
				if ($error[1]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido un mail correcto.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït un mail correcte.<br />';						
				}
				if ($error[2]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido la ciudad a la que quieres asistir.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït la ciutat a la que vols assistir.<br />';						
				}
				
				switch ($page->leng)
				{
					case 'ES':
						print '<p class="error">'.$error_detall[0].'</p>';
					break;
					case 'CAT':
						print '<p class="error">'.$error_detall[1].'</p>';
					break;
				}
			}
			if ($correcte==1) {
				switch ($page->leng) 
				{
					case 'ES':
					print '<p class="error">Gracias por participar.</p>';
					break;
					case 'CAT':
						print '<p class="error">Gracies per participar.</p>';
					break;
					
				}
				$subject='Sorteig SOTO';
				$message="Concurs SOTO<br />enviat per: $name \r\n amb el mail $email  \r\n per la ciutat $ciutat";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo 2 entradas SOTO</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig 2 entrades SOTO</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				<div class="centrar"><img src="pics/conc/20190916123851.png" width="350"  alt="Gira SOTO" /></div>
	
				
	
				<p class="cc">
				La próxima semana, Jeff Scott Soto se encontrará inmerso en la gira Origami con su banda, visitando las principales ciudades de la península .<br /><br />
				Así que desde Satan Arise sorteamos dos entradas sencillas para sus conciertos de Madrid, Barcelona y Vitoria, para que puedas disfrutar de esta leyenda del rock!<br /><br />
				Para participar debes mandarnos un e-mail a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre, tu correo electrónico y la ciudad a la que quieres asistir: Barcelona, Madrid o Vitoria, además de dar like a las páginas de <a class="linkk" href="https://www.facebook.com/scienceofnoise/" target="_blank">Science of Noise</a> y a la de <a class="linkk" href="https://www.facebook.com/rmconcertpromotions" target="_blank">R.M. Concert Promotions</a><br /><br /> ...o rellena el siguiente formulario:
				
				<br /><br />
				Tienes poco tiempo para participar, pues el sorteo se cerrará el próximo día 20 de Septiembre a las 23:59h!!!<br /> <br />
				Mucha suerte!!!!
				</p>
               
				</p>
               
				
				<div id="formulari">
		<?php
		
		
		$name='';
		$email='';
		$correcte = 0;
	}
	if ($correcte == 0) {
		
	
	
		print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>";
		print '<table class="form" cellpadding="2" cellspacing="3">';
		print '<tr onmouseover="posarDescripcioNom(';
		switch ($page->leng)

		{
			case 'ES':
				print "'Escribe tu nombre'";
			break;
			case 'CAT':
				print "'Escriu el teu nom'";
			break;
		}
		print ')" onmouseout="borrarDescripcioNom()">';
		print '<td class="celdaesq">';
		switch ($page->leng)
		{
			case 'ES':
				print "Nombre:";
			break;
			case 'CAT':
				print "Nom:";
			break;
		}
		print '</td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="name" size="35" maxlength="200" value="'.$name.'" /></td>';
		print '<td class="celdadreta"><span id="descripcioNom"></span></td>';
		print '</tr><tr onmouseover="posarDescripcioMail(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe tu e-mail'";
			break;
			case 'CAT':
				print "'Escriu el teu e-mail'";
			break;
		}
		print ')" onmouseout="borrarDescripcioMail()">';
		print '<td class="celdaesq">e-mail: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="email" size="35" maxlength="200" value="'.$email.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioMail"></span></td>';
		print '</tr>';
 print '</tr><tr onmouseover="posarDescripcioCiutat(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe la ciudad'";
			break;
			case 'CAT':
				print "'Escriu la ciutat'";
			break;
		}
		print ')" onmouseout="borrarDescripcioCiutat()">';
		print '<td class="celdaesq">Ciudad: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="ciutat" size="35" maxlength="200" value="'.$ciutat.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioCiutat"></span></td>';
		print '</tr>';
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form>
		<div class="centrar">
		<iframe width="560" height="315" src="https://www.youtube.com/embed/x0hA9b-MuhQ" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
		</div>
		</div></div>';
		
	}
break;
case 'metallica':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			$ciutat=strip_tags(rtrim($_POST['ciutat']));
			$edad=strip_tags(rtrim($_POST['edad']));
			if (strlen($name) == 0) {
				$correcte=0;
				$error[0]=1;
			}
			if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))) {
				$error[1]=1;
				$correcte=0;
			}
			if (strlen($ciutat) == 0) {
				$correcte=0;
				$error[2]=1;
			}
			if (strlen($edad) == 0) {
				$correcte=0;
				$error[3]=1;
			}
			if ($correcte == 0) {
				$error_detall=array();
				if ($error[0]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido ningún nombre.<br />';
					$error_detall[1] = $error_detall[1].'No has introduït cap nom.<br />';
				}
				if ($error[1]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido un mail correcto.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït un mail correcte.<br />';						
				}
				if ($error[2]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido el cine/ciudad a la que quieres asistir.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït el cinema/ciutat a la que vols assistir.<br />';						
				}
				if ($error[3]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido tu DNI.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït el teu DNI.<br />';						
				}
				
				switch ($page->leng)
				{
					case 'ES':
						print '<p class="error">'.$error_detall[0].'</p>';
					break;
					case 'CAT':
						print '<p class="error">'.$error_detall[1].'</p>';
					break;
				}
			}
			if ($correcte==1) {
				switch ($page->leng) 
				{
					case 'ES':
					print '<p class="error">Gracias por participar.</p>';
					break;
					case 'CAT':
						print '<p class="error">Gracies per participar.</p>';
					break;
					
				}
				$subject='Sorteig Metallica';
				$message="Concurs Metallica<br />enviat per: $name \r\n amb el mail $email  \r\n per al cinema/ciutat $ciutat \r\n  amb el DNI $edad";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo 2 entradas dobles para Metallica</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig 2 entrades dobles per a Metallica</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				<div class="centrar"><img src="pics/banner/metallica.jpg" width="350"  alt="Metallica" /></div>
	
				
	
				<p class="cc">
				Metallitarium Spain Local Chapter #351 , Ricard Altadill y Versión Digital distribuidora nacional de S&M², y 140 salas españolas representadas por Cinesa , Yelmo , Kinepolis y Grup Balaña, 
te invitan el 9 de octubre a ver el estreno mundial de El concierto sinfónico de Metallica junto a la San Francisco Symphony Orchestra !!
<br /><br />
				Como participar en el sorteo de 2 invitaciones dobles:<br /><br />
				Dale un me gusta al club de fans de
Metallica (Metallitarium Spain Local Chapter #351)<br /><br />
<a href="http://www.facebook.com/MetallitariuM/" class="linkk" target="_blank">www.facebook.com/MetallitariuM/</a><br />
<a href="http://www.facebook.com/versiondigital" class="linkk" target="_blank">www.facebook.com/versiondigital</a><br />
                                      <a href="http://www.facebook.com/YelmoCines/" class="linkk" target="_blank">www.facebook.com/YelmoCines/</a><br /><br />

				y además debes mandarnos un e-mail a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre, tu correo electrónico, tu DNI y el cine/ciudad al que quieres asistir (ver lista al final)...o rellena el siguiente formulario:
				
				<br /><br />
				Tienes poco tiempo para participar, pues el sorteo se cerrará el próximo lunes día 30 de Septiembre a las 10:00h!!!<br /> <br />
				Mucha suerte!!!!
				</p>
               
				</p>
               
				
				<div id="formulari">
		<?php
		
		
		$name='';
		$email='';
		$ciutat='';
		$edad='';
		$correcte = 0;
	}
	if ($correcte == 0) {
		
	
	
		print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">";
		print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>";
		print '<table class="form" cellpadding="2" cellspacing="3">';
		print '<tr onmouseover="posarDescripcioNom(';
		switch ($page->leng)

		{
			case 'ES':
				print "'Escribe tu nombre'";
			break;
			case 'CAT':
				print "'Escriu el teu nom'";
			break;
		}
		print ')" onmouseout="borrarDescripcioNom()">';
		print '<td class="celdaesq">';
		switch ($page->leng)
		{
			case 'ES':
				print "Nombre:";
			break;
			case 'CAT':
				print "Nom:";
			break;
		}
		print '</td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="name" size="35" maxlength="200" value="'.$name.'" /></td>';
		print '<td class="celdadreta"><span id="descripcioNom"></span></td>';
		print '</tr><tr onmouseover="posarDescripcioMail(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe tu e-mail'";
			break;
			case 'CAT':
				print "'Escriu el teu e-mail'";
			break;
		}
		print ')" onmouseout="borrarDescripcioMail()">';
		print '<td class="celdaesq">e-mail: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="email" size="35" maxlength="200" value="'.$email.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioMail"></span></td>';
		print '</tr>';
 print '</tr><tr onmouseover="posarDescripcioCiutat(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe el cine/ciudad'";
			break;
			case 'CAT':
				print "'Escriu el cinema/ciutat'";
			break;
		}
		print ')" onmouseout="borrarDescripcioCiutat()">';
		print '<td class="celdaesq">Ciudad: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="ciutat" size="35" maxlength="200" value="'.$ciutat.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioCiutat"></span></td>';
		print '</tr>';
		
		print '</tr><tr onmouseover="posarDescripcioEdat(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe tu DNI'";
			break;
			case 'CAT':
				print "'Escriu el teu DNI'";
			break;
		}
		print ')" onmouseout="borrarDescripcioEdat()">';
		print '<td class="celdaesq">DNI: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="edad" size="35" maxlength="200" value="'.$edad.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioEdad"></span></td>';
		print '</tr>';
		
		
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>
		<div class="centrar"><p class="cc">
		<span class="cursiva">Listado de cines</span><br /><br />
		ANDALUCÍA<br />
Algeciras – Yelmo Cines Puerta Europa<br />
Almería – Yelmo Torrecárdenas<br />
Coín – CINE PIXEL COIN, CC La Trocha<br />
Córdoba - Cine sur El Tablero<br />
Fuengirola – Cine Alfil - Fuengirola<br />
Granada – Kinepolis Granada<br />
Granada – Kinépolis Nevada<br />
Huelva - Cines Aqualon<br />
Jerez de la Frontera – Yelmo Area Sur<br />
Los Barrios – Odeon Bahía Plaza<br />
Mairena de Aljarafe – Metromar Cinemas Cineciudad<br />
Málaga – Yelmo Plaza Mayor<br />
Málaga – Yelmo Vialia Málaga<br />
Marbella – Cinesa La Cañada<br />
Puerto de Santa María – Multicines Bahía Mar UCC<br />
Rincón de la Victoria – Yelmo Rincón de la Victoria<br />
Roquetas de Mar – Yelmo Roquetas<br />
Sevilla – Cinesa Camas<br />
Sevilla – Odeón Plaza de Armas<br />
Sevilla - Cinesur Nervión Plaza<br /><br />
ARAGÓN<br />
Zaragoza – Cinesa Grancasa<br />
Zaragoza – Cinesa Puerto Venecia<br />
Zaragoza – Yelmo Plaza Imperial<br />
Zaragoza – Cines Aragonia<br />
Zaragoza - Cine Palafox Independencia<br /><br />
ASTURIAS<br />
Gijón – Yelmo Ocimax<br />
Oviedo – Cinesa Intu Asturias<br />
Oviedo – Yelmo Los Prados<br />
Trasona – Odeón Parque Astur<br /><br />
CANTABRIA<br />
Santander - Peñacastillo Cinemas-12 3D<br />
Santander – Cinesa Bahía de Santander<br /><br />
CASTILLA LA MANCHA<br />
Albacete – Yelmo Vialia Albacete<br /><br />
CASTILLA Y LEÓN<br />
Valladolid – Cinesa Zaratán<br />
Valladolid – Yelmo Vallsur<br />
Valladolid – Cines Broadway Valladolid<br /><br />
CATALUÑA<br />
Abrera – Yelmo Abrera<br />
Barberà del Vallés – Yelmo Baricentro<br />
Barcelona – Arenas de Barcelona<br />
Barcelona – Balmes Multicines<br />
Barcelona – Bosque Multicines<br />
Barcelona – Glòries Multicines Grup Balañá<br />
Barcelona – Cinesa Diagonal<br />
Barcelona – Cinesa Diagonal Mar<br />
Barcelona – Cinesa SOM Multiespai<br />
Barcelona – Cinesa La Maquinista<br />
Barcelona – Yelmo Comedia<br />
Barcelona – Yelmo Icaria<br />
Barcelona – Cinemes Girona<br />
Cornellà – Kinepolis Full HD<br />
Cornellà – Cinesa Cornellà Centre<br />
El Masnou – Cinema "La Calàndria"<br />
Gavà – Cinesa Barnasud<br />
Hospitalet de Llobregat – Cinesa La Farga<br />
Lleida - JCA Teatre Principal<br />
Lleida - JCA Cinemes Lleida - Alpicat<br />
Mataró – Cinesa Mataró Parc<br />
Montcada i Reixach – Cines Montcada<br />
Reus – Cines Axión Reus<br />
Tarragona – Yelmo Parc Central<br />
Terrassa - Cinema Catalunya<br />
Terrassa – Cinesa Parc Vallès<br />
Tremp - Espai Cultural La Lira<br />
Valls - JCA Cinemes Valls<br />
Vic – Multicines Sucre<br />
Vilallonga del Camp – Cinema Recreatiu de Vilallonga del Camp (10/10)<br /><br />
COMUNIDAD VALENCIANA<br />
Aldaia – Cinesa Bonaire<br />
Alicante – Yelmo Puerta de Alicante<br />
Alicante – Kinépolis Alicante Plaza Mar 2<br />
Alicante – Odeón Alicante<br />
Alcoy – Cines Axión Alcoy<br />
Alzira – Kinépolis Alzira<br />
Castellón – Cinesa La Salera<br />
Orihuela – Cines Axión Orihuela<br />
Paterna – Kinepolis Valencia<br />
Petrer – Yelmo Vinalopó<br />
Sagunto – Yelmo Vidanova Parc<br />
Valencia – Cines Lys Valencia<br />
Valencia – Yelmo Campanar<br />
Vila-real – Multicines Sucre Vila-real<br />
Xàtiva – Cines Axión Plaza Mayor<br /><br />
GALICIA<br />
Coruña – Cinesa Marineda<br />
Coruña – Yelmo Los Rosales<br />
Lugo - Yelmo As Termas<br />
Santiago de Compostela – Cinesa As Cancelas<br />
Vigo – Yelmo Vigo<br /><br />
ISLAS BALEARES<br />
Ciutadella de Menorca - Cinemes canal salat<br />
Ibiza – Cines Eivissa Aficine<br />
Palma de Mallorca – Ocimax Palma<br />
Palma de Mallorca – Cinesa Festival Park<br /><br />
ISLAS CANARIAS<br />
Caleta de Fuste – Yelmo Fuerteventura<br />
La Orotava – Yelmo Villa La Orotava<br />
Las Palmas de Gran Canaria – Cinesa El Muelle<br />
Las Palmas de Gran Canaria – Cinesa Siete Palmas<br />
Las Palmas de Gran Canaria – Yelmo Alisios<br />
Las Palmas de Gran Canaria – Yelmo Las Arenas<br />
Las Palmas de Gran Canaria - Yelmo Vecindario<br />
Santa Cruz de Tenerife – Yelmo Meridiano<br />
Santa Cruz de Tenerife – Multicines Tenerife<br /><br />
LA RIOJA<br />
Logroño – Cine 7 Infantes<br />
Logroño – Yelmo Berceo<br />
Logroño – Cines Moderno<br /><br />
MADRID<br />
Alcorcón - Yelmo 3 Aguas<br />
Arroyomolinos – Cinesa Xanadú<br />
Collado Villalba – Yelmo Planetocio<br />
Getafe – Cinesa Nassica<br />
La Moraleja – Cinesa La Moraleja<br />
Las Rozas – Cinesa Heron City Las Rozas<br />
Leganés – Cinesa Parquesur<br />
Madrid – Palacio de la Prensa<br />
Madrid – Kinépolis Madrid Ciudad de la Imagen<br />
Madrid – Kinepolis Diversia<br />
Madrid – Cinesa Equinoccio<br />
Madrid – Cinesa La Gavia<br />
Madrid – Cinesa Las Rosas<br />
Madrid – Cinesa Manoteras<br />
Madrid – Cinesa Méndez Álvaro<br />
Madrid – Cinesa Parque Corredor<br />
Madrid – Cinesa Plaza Loranca<br />
Madrid – Cinesa Príncipe Pío<br />
Madrid – Cinesa Proyecciones<br />
Madrid – Yelmo Ideal<br />
Madrid – Yelmo Islazul<br />
Madrid – Yelmo Plaza Norte<br />
Madrid – Yelmo Plenilunio<br />
Madrid – Yelmo Rivas Futura<br />
Madrid – Odeón Sambil<br />
Madrid - mk2 Palacio de Hielo<br /><br />
MURCIA<br />
Cartagena – Neocine Mandarache<br />
Churra – Cinesa Nueva Condomina<br />
Murcia – Neocine Thader<br />
Murcia – Multicines El Hornillo<br />
San Javier – Neocine Dos Mares<br /><br />
NAVARRA<br />
Pamplona – Yelmo Itaroa<br />
Pamplona – Golem La Morea<br /><br />
PAÍS VASCO<br />
Baracaldo – Cinesa Max Ocio<br />
Baracaldo – Yelmo Megapark<br />
Bilbao – Cinesa Zubiarte<br />
Leioa – Yelmo Artea<br />
San Sebastián – Cines SADE Príncipe<br />
Usurbil – Cinesa Urbil<br />
Vitoria-Gasteiz – Yelmo Boulevard<br />
</p>
		
		</div>';
		
	}
break;
}
?>