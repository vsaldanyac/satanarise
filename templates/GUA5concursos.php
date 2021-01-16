<?php

switch ($page->concurs)
{
case 'bajopresion':
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
				$subject='Sorteig Bajo Presión';
				$message="Concurs Bajo Presión<br />enviat per: $name \r\n amb el mail $email";
				mail('info@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Desafiando El Caos de Bajo Presión</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Desafiando El Caos de Bajo Presión</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				<div class="centrar"><img src="pics/covers/bajopresion_desafiandoelcaos.jpg" width="500"  alt="Desafiando El Caos de Bajo Presión" /></div>
	
				
	
				<p class="cc">
				Mientras no se hace realidad el segundo trabajo de Bajo Presión, proyecto personal de Javier Canseco, acompañado de lo mejor del rock y metal nacional, tenemos cuatro copias de sy primer trabajo para vosotros.<br /><br />
				Cuatro ejemplares de Desafiando El Caos para sortear entre los que participeis. ¿A Qué estás es<br /><br />
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
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div>';
		
	}
break;
case 'operasaurom':
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
				$subject='Sorteig Tyr';
				$message="Concurs Tyr<br />enviat per: $name \r\n amb el mail $email";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo entradas Opera Magna + Saurom</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig entrades Opera Magna + Saurom</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/conc/20161126212825.jpg" width="400"  alt="Opera Magna + Saurom" /></div>
	
				
	
				<p class="cc">
				Los ganadores del sorteo de dos entradas para ver el próximo 28 de Enero a Saurom junto a Opera Magna son: <br /><br />
				· Eduar Felipe Arias Sánchez<br />
				· Xavi Cao<br /><br />
				
				ENHORABUENA!!!!<br />
				Podréis recoger vuestra entrada en taquilla, mostrando vuestro DNI.
	
	
			<div class="centrar">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/kpWFWO3Qre4" frameborder="0" allowfullscreen></iframe>
				<br />
				<iframe width="560" height="315" src="https://www.youtube.com/embed/rb5wf2OXdDU" frameborder="0" allowfullscreen></iframe>
				</div>
                </p>
                
	           
</div>
				
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/conc/20161126212825.jpg" width="400"  alt="Opera Magna + Saurom" /></div>
	
				
	
				<p class="cc">
					Els guanyadors del sorteig de dues entrades per veure a Saurom juntament amb Opera Magna el proper 28 de Gener són: <br /><br />
				· Eduar Felipe Arias Sánchez<br />
				· Xavi Cao<br /><br />
				ENHORABONA!!!!<br />
				Podreu recollir la vostra entrada a guixeta, mostrant el vostre DNI.
	
	
			<div class="centrar">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/kpWFWO3Qre4" frameborder="0" allowfullscreen></iframe>
				<br />
				<iframe width="560" height="315" src="https://www.youtube.com/embed/rb5wf2OXdDU" frameborder="0" allowfullscreen></iframe>
				</div>
                </p>
                
	      </div>
        
		<?php
		}
		
	}
	
break;
case 'guadana':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0, 0, 0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			$ciutat=strip_tags(rtrim($_POST['ciutat']));		
			$youtube=strip_tags(rtrim($_POST['youtube']));	
			$edad=strip_tags(rtrim($_POST['edad']));	
			$obs=strip_tags(rtrim($_POST['obser']));
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
			if (strlen($youtube) == 0) {
				$correcte=0;
				$error[3]=1;
			}
			if (!(preg_match('/^[0-9]+$/',$edad))) {
				$correcte=0;
				$error[4]=1;
			}
			if (strlen($obs) == 0) {
				$correcte=0;
				$error[5]=1;
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
					$error_detall[0] = $error_detall[0].'No has introducido de qué ciudad eres.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït de quina ciutat ets.<br />';						
				}
				if ($error[3]==1) {
					$error_detall[0] = $error_detall[0].'Debes poner tu usuario de youtube o de gmail.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït el teu usuari de youtube o de gmail.<br />';						
				}
				if ($error[4]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido tu edad.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït la teva edat.<br />';						
				}
				if ($error[5]==1) {
					$error_detall[0] = $error_detall[0].'No has introducido tus canciones favoritas de Guadaña.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït les teves cançons preferides de Guadaña.<br />';						
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
				$subject='Sorteig Guadaña';
				$message="Concurs Guadaña<br />enviat per: $name \r\n amb el mail $email \r\n per la ciutat $ciutat \r\n amb youtube $youtube \r\n edat $edad \r\n 3 canciones favoritas: $obs";
				mail('info@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Guadaña</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Guadaña</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar">
					<img src="pics/sorteig/sorteo_guadana.jpg" width="600"  alt="Guadaña" /></div>
	
				
	
				<p class="cc">
				Sorteamos cuatro packs de merchandising de Guadaña ante la inminente salida de su nuevo trabajo llamado "Karma".<br /><br />
				Los packs están compuestos por:<br /><br />
				PACK 1:<br />
				1 Camiseta Soy La Ley<br />
				1 Single suite<br />
				1 Muñequera<br />
				1 Mochila<br /><br />
				
				PACK 2:<br />
				1 Camiseta H<br />
				1 Muñequera<br />
				1 Mochila<br /><br />
				
				PACK 3:<br />
				1 Camiseta H<br />
				1 Single suite<br /><br />
				
				PACK 4:<br />
				1 Camiseta H<br />
				1 Colgante<br /><br />
			Como pre-requisitos para participar debes dar Like a su <a class="linkk" href="https://www.facebook.com/grupoguadana" target="_blank"> página de facebook</a> y estar suscrito a su <a class="linkk" href="https://www.youtube.com/channel/UCtJ3MRFWD1mSpltc6UtAz5A" target="_blank">canal de youtube</a>.
			
	
	
				<div class="centrar">
                    <img src="pics/not/20160905155645_2.jpg" width="375" align="middle" /><br /><br />
                </div>
                </p>
                
	           <p  class="cc">¿Qué más hay que hacer? Es muy sencillo, escríbenos a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre completo, tu e-mail, tu nombre de usuario de youtube (es el mismo de gmail (lo que hay delante de la arroba de tu correo electrónico)), de qué ciudad eres, cuales son tus tres canciones favoritas de Guadaña y tu edad y entrarás en el sorteo... o rellena el siguiente formulario.</p>
        <p  class="cc">El concurso se cerrará el 30 de diciembre a las 0.00 horas.</p>

				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar">
					<img src="pics/sorteig/sorteo_guadana.jpg" width="600"  alt="Guadaña" /></div>
	
				
	
				<p class="cc">
				Sortegem dos packs de merchandising de Guadaña davant de la inminent sortida del seu nou treball titolat "Karma".<br /><br />
				Els packs estan composats per:<br /><br />
				PACK 1:<br />
				1 Samarreta Soy La Ley<br />
				1 Single suite<br />
				1 Canellera<br />
				1 Motxil·la<br /><br />
				
				PACK 2:<br />
				1 Samarreta H<br />
				1 Canellera<br />
				1 Motxil·la<br /><br />
				
				PACK 3:<br />
				1 Samarreta H<br />
				1 Single suite<br /><br />
				
				PACK 4:<br />
				1 Samarreta H<br />
				1 Penjoll<br /><br />
			Com a pre-requisits per participar has de fer like a la seva <a class="linkk" href="https://www.facebook.com/grupoguadana" target="_blank"> pàgina de facebook</a> i estar subscrit al seu <a class="linkk" href="https://www.youtube.com/channel/UCtJ3MRFWD1mSpltc6UtAz5A" target="_blank">canal de youtube</a>.

	
				<div class="centrar">
                    <img src="pics/not/20160905155645_2.jpg" width="375" align="middle" /><br /><br />
                </div>
                </p>
                
	           <p  class="cc">¿Qué s'ha de fer? És molt senzill, escriu-nos a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicant el teu tu nom, el teu e-mail, el teu nom d'usuari de youtube (és el mateix de gmail (el que hi ha davant de l'arroba del teu mail)), la ciutat d'on ets, quines són les teves 3 cançons preferides de Guadaña i la teva edat i entraràs al sorteig... o omple el següent formulari.</p>
        <p  class="cc">El concurs es tancarà el 30 de desembre a les 0.00 hores.</p>
        
				<div id="formulari">
		<?php
		}
		
		$name='';
		$email='';
    $ciutat='';
		$youtube='';
		$edad='';
		$obs='';

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
		
		
		print '</tr><tr onmouseover="posarDescripcioYouTube(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe tu usuario de youtube/gmail'";
			break;
			case 'CAT':
				print "'Escriu el teu usuari de youtube/gmail'";
			break;
		}
		print ')" onmouseout="borrarDescripcioYouTube()">';
		print '<td class="celdaesq">Youtube/gmail: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="youtube" size="35" maxlength="200" value="'.$youtube.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioYoutube"></span></td>';
		print '</tr>';
		
		
		print '</tr><tr onmouseover="posarDescripcioEdat(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe tu edad'";
			break;
			case 'CAT':
				print "'Escriu la teva edat'";
			break;
		}
		print ')" onmouseout="borrarDescripcioEdat()">';
		print '<td class="celdaesq">Edad: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="edad" size="35" maxlength="200" value="'.$edad.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioEdad"></span></td>';
		print '</tr>';
		
		
		
		print '</tr><tr onmouseover="posarDescripcioObs(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Pon tus 3 canciones favoritas de Guadaña'";
			break;
			case 'CAT':
				print "'Les teves 3 cançons preferides de Guadaña'";
			break;
		}
		print ')" onmouseout="borrarDescripcioObs()">';
		print '<td class="celdaesq">Tus 3 Canciones favoritas de Guadaña: </td>';
		print '<td class="celdadreta"><textarea name="obser" style="width:270px;height:150px;" ></textarea></td>';
		print '<td class="celdadreta"><span id="descripcioObs"></span></td>';
		print '</tr>';

 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div><div class="centrar"><img src="pics/not/20160905155645_1.jpg" width="375" align="middle" /><br /><iframe width="420" height="315" src="//www.youtube.com/embed/Un0KqU3jtAc" frameborder="0" allowfullscreen></iframe><iframe width="420" height="315" src="//www.youtube.com/embed/d7FYAIA_DIU" frameborder="0" allowfullscreen></iframe></div></div>';
	}
break;
}
?>