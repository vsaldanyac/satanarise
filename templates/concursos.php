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
case 'debler':
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
				$subject='Sorteig Debler';
				$message="Concurs Debler<br />enviat per: $name \r\n amb el mail $email";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Entradas Concierto Debler</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Entrades Concert Debler</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/sorteig/debler.jpg" width="500"  alt="Hard Buds" /></div>
	
				
	
				<p class="cc">
				Este sábado, Débler nos ofrecen un concierto inédito en streaming. <br /><br />
				Desde Satan Arise, hemos sorteado dos entradas sencillas para poder asistir y disfrutar en estos tiempos difíciles de la música en directo de la banda.
				<br /><br />
				Y ya tenemos los ganadores!!! ENHORABUENA y gracias a todos por participar!!!
				<br /><br />
				Los ganadores son:<br /><br />
				· Maria Pilar Munera Fernández<br />
				· Miguel Ángel González Rueda<br /><br />

				Os hemos mandado un mail con instrucciones, para que podáis disfrutar de este evento tan especial!
				</p>
				<div class="centrar">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/mrSNjG_0m0k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>

                
                </div>
		<?php
		} else {
		?>
			<div id="cos">     
				<div id="cos">     
				<div class="centrar"><img src="pics/sorteig/debler.jpg" width="500"  alt="Hard Buds" /></div>
	
				
	
				<p class="cc">
				Este sábado, Débler nos ofrecen un concierto inédito en streaming. <br /><br />
				Desde Satan Arise, hemos sorteado dos entradas sencillas para poder asistir y disfrutar en estos tiempos difíciles de la música en directo de la banda.
				<br /><br />
				Y ya tenemos los ganadores!!! ENHORABUENA y gracias a todos por participar!!!
				<br /><br />
				Los ganadores son:<br /><br />
				· Maria Pilar Munera Fernández<br />
				· Miguel Ángel González Rueda<br /><br />

				Os hemos mandado un mail con instrucciones, para que podáis disfrutar de este evento tan especial!
				</p>
				<div class="centrar">
					<iframe width="560" height="315" src="https://www.youtube.com/embed/mrSNjG_0m0k" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
</div>
				
	
		<?php
		}
		
	}
break;
}
?>