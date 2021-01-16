<?php

switch ($page->concurs)
{
case 'hardbuds':
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
				$subject='Sorteig Hard Buds';
				$message="Concurs Hard Buds<br />enviat per: $name \r\n amb el mail $email";
				mail('info@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo discografía Hard Buds</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig discografía Hard Buds</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/sorteig/hard.jpg" width="500"  alt="Hard Buds" /></div>
	
				
	
				<p class="cc">
				Hard Buds acaban de lanzar su nuevo trabajo Thunderstorm y han querido celebrarlo con nosotros. <br /><br />
				Nos han mandado una copia del disco para poder sortearla entre todo los que la querais... y os animeis a participar en este sorteo.<br /><br />
				</p>
                <div class="centrar">
                <img src="pics/sorteig/hard3.jpg" width="450" align="middle"/><br /><br />

                </div>
          
				<p class="cc">
				Hard Buds están de gira, ¡así que aquí os dejamos sus fechas para que podais cuadrar vuestras agendas con su gira!
				</p>          
				
                
                <div class="centrar">
                <img src="pics/sorteig/hard2.jpg" width="450" align="middle"/><br /><br />

                </div>

				
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div id="cos">     
				<div class="centrar"><img src="pics/sorteig/hard.jpg" width="500"  alt="Hard Buds" /></div>
	
				
	
				<p class="cc">
				Hard Buds acaban de treure el seu nou treball Thunderstorm i han volgut celebrar-ho amb nosaltres. <br /><br />
				Ens han enviat una copia del disc per poder sortejar-la entre tots els que la volgueu i us animeu a participar al sorteig.<br /><br />
				</p>
                <div class="centrar">
                <img src="pics/sorteig/hard3.jpg" width="450" align="middle"/><br /><br />

                </div>
          
				<p class="cc">
				Hard Buds estan de gira, així que aquí us deixem les seves date per que pogueu quadrar les dates de la vostra agenda!
				</p>          
				
                
                <div class="centrar">
                <img src="pics/sorteig/hard2.jpg" width="450" align="middle"/><br /><br />

                </div>

				
				<div id="formulari">
		<?php
		}
		
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
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>';
	}
break;
case 'darkmoor':
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
				$subject='Sorteig Dark Moor';
				$message="Concurs Dark Moor<br />enviat per: $name \r\n amb el mail $email \r\n per la ciutat $ciutat";
				mail('darkmoor@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Dark Moor</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Dark Moor</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/logos/darkmoor.jpg" width="400"  alt="darkmoor" /></div>
	
				
	
				<p class="cc">
				Sorteamos dos entradas para la gira Ars Musica en Madrid y dos más para Barcelona.<br /><br />
				La banda estará presentando en Barcelona el próximo viernes 21 de Febrero en la sala Bóveda.<br />
				El concieto de Madrid será el próximo sábado 22 de Febrero en la Sala Penélope.<br /><br />


Una gran oportunidad para ver en directo a esta gran banda en su gira que les ha llevado entre otros países, por China, Japón, Korea, Rusia, entre otros.<br /><br />
	
	
				<div class="centrar">
                    <img src="pics/covers/darkmoor_arsmusica.jpg" width="375" align="middle" /><img src="pics/not/darkmoor_tour.jpg" width="300" align="middle" /><br /><iframe width="420" height="315" src="//www.youtube.com/embed/zxAjnz2Ooio" frameborder="0" allowfullscreen></iframe><br />
                </div>
                </p>
                
	           <p  class="cc">¿Qué hay que hacer? Es muy sencillo, escribenos a <a class="linkk" href="mailto:darkmoor@satanarise.com" >darkmoor@satanarise.com</a> indicando tu nombre completo y tu e-mail y para qué ciudad quieres las entradas y entrarás en el sorteo... o rellena el siguiente formulario.</p>
        <p  class="cc">El concurso se cerrará el 16 de febrero a las 0.00 horas.</p>

				
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/logos/darkmoor.jpg" width="400"  alt="dark moor" /></div>
	
				
	
				<p class="cc">
				Sortegem dues entrades per a la gira Ars Musica a Madrid i dos més per a Barcelona. <br /> <br />
La banda estarà presentant a Barcelona el proper divendres 21 de febrer a la sala Bóveda. <br />
El Concert de Madrid serà el proper dissabte 22 de febrer a la Sala Penélope. <br /> <br />


Una gran oportunitat per veure en directe a aquesta gran banda en la seva gira que els ha portat entre altres països, per la Xina, Japó, Korea, Rússia, entre d'altres. <br /> <br />
	
	
				<div class="centrar">
                    <img src="pics/covers/darkmoor_arsmusica.jpg" width="375" align="middle" /><img src="pics/not/darkmoor_tour.jpg" width="300" align="middle" /><br /><iframe width="420" height="315" src="//www.youtube.com/embed/zxAjnz2Ooio" frameborder="0" allowfullscreen></iframe><br />
                </div>
                </p>
                
	           <p  class="cc">¿Qué s'ha de fer? És molt senzill, escriu-nos a <a class="linkk" href="mailto:darkmoor@satanarise.com" >darkmoor@satanarise.com</a> indicant el teu tu nom i e-mail i la ciutat d'on vols l' entrada i entraràs al sorteig... o omple el següent formulari.</p>
        <p  class="cc">El concurs es tancarà el 16 de febrer a les 0.00 hores.</p>
        
				<div id="formulari">
		<?php
		}
		
		$name='';
		$email='';
		$ciutat='';
        $com='';
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

 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>';
	}
break;
}
?>


            
        