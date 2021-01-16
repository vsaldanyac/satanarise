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
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>';
		
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
case 'rammstein':
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
				$subject='Sorteig Rammstein';
				$message="Concurs Rammstein<br />enviat per: $name \r\n amb el mail $email";
				mail('info@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo 2 Entradas dobles Rammstein VALENCIA</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig 2 Entrades dobles Rammstein VALENCIA</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				<div class="centrar"><img src="pics/sorteig/cine_rammstein.jpg" width="600"  alt="Cine Rammstein" /></div>
	
				
	
				<p class="cc">
				Amantes del metal, Yelmo Cines te lleva de concierto a París sin moverte de tu ciudad. Este 23 de marzo  no te pierdas la extraordinaria e innovadora película RAMMSTEIN: PARIS de Jonas Akerlund. Una oportunidad única para ver el directo de la mítica banda como nunca antes. <br /><br />
				Y desde Satan Arise hemos sorteado dos entradas dobles para la ciudad de Valencia en los cines Yelmo Cines VALENCIA para que pudierais disfrutar del evento.<br />
				</p>
				
				<p class="cc">Los ganadores han sido<br /><br />
					· Rodrigo Puché Tolosa <br />
					· Maria Caridad Montoya Martínez<br /><br />
					En caso de ser uno de los ganadores, te hemos mandado un e-mail pidiéndote el número de DNI para que puedas recoger en taquilla las dos entradas!<br />
				
				<div class="centrar"><iframe width="560" height="315" src="https://www.youtube.com/embed/QxtoYzkmRAk" frameborder="0" allowfullscreen></iframe></div>
				</p>
				
			</div>
		<?php
		
	}
break;
case 'cine':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			$ciutat=strip_tags(rtrim($_POST['ciutat']));		
			$cine=strip_tags(rtrim($_POST['cine']));	
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
			if (strlen($cine) == 0) {
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
					$error_detall[0] = $error_detall[0].'No has introducido a qué ciudad/cine quieres ir.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït a quina ciutat/cinema vols anar.<br />';						
				}
				if ($error[3]==1) {
					$error_detall[0] = $error_detall[0].'Debes poner qué película quieres ver.<br />';						
					$error_detall[1] = $error_detall[1].'Has de posar quina pel·lícula vols veure.<br />';						
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
						print '<p class="error">Gràcies per participar.</p>';
					break;
					
				}
				$subject='Sorteig Cine';
				$message="Concurs Cine<br />enviat per: $name \r\n amb el mail $email \r\n per la ciutat $ciutat \r\n a la peli $cine \r\n";
				mail('info@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Entradas Cine</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Entrades Cinema</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar">
					<img src="pics/sorteig/sorteo_slipknot.jpg" width="300"  alt="Slipknot" />
					<img src="pics/sorteig/sorteo_blacksabbath.jpg" width="300"  alt="Black Sabbath" />
				</div>
	
	
				<p class="cc">
					Ya tenemos los ganadores para ir a ver <span class="cursiva">"Day Of The Gusano”</span>, documental de una de las actuaciones más históricas de <span class="cursiva">Slipknot</span>.<br /><br />

 
•         Jordi Ruiz Salvadó en BARCELONA<br />
•         Rodrigo Puché Tolos en VALENCIA<br /><br />
					Podrán recoger sus dos entradas el próximo 21 septiembre a partir de las 20.00h en taquilla.<br /><br />
<br /><br />

			Aún puedes participar en el siguiente estreno!<br /><br />
			
			SatanArise junto a Yelmo cines te invita al cine. Puedes participar en el sorteo de dos entradas:<br /><br /><br />
			
			- <span class="cursiva">"The End Of The End"</span> es el film que documenta el último concierto de la gira de despedida de la mítica banda de metal, <span class="cursiva">Black Sabbath</span>.<br /><br />
				Será el día 28 a las 20h y puedes elegir entre los siguientes cines:<br /><br />
 
•         A Coruña: YELMO CINES ESPACIO CORUÑA<br />
•         Álava: YELMO CINES BOULEVARD<br />
•         Albacete: YELMO CINES VIALIA ALBACETE<br />
•         Alicante: YELMO CINES PUERTA DE ALICANTE, YELMO CINES VINALOPO<br />
•         Almería: YELMO CINES ROQUETAS<br />
•         Asturias: YELMO CINES OCIMAX GIJON, YELMO CINES LOS PRADOS<br />
•         Barcelona: YELMO CINES ICARIA, YELMO CINES CASTELLDEFELS,YELMO CINES ABRERA, YELMO CINES COMEDIA, YELMO CINES SANT CUGAT,<br />
•         Cádiz: YELMO CINES AREA SUR<br />
•         La Rioja: YELMO CINES BERCEO<br />
•         Las Palmas: YELMO CINES LAS ARENAS, YELMO CINES FUERTEVENTURA, YELMO CINES VECINDARIO<br />
•         Madrid : YELMO CINES ISLAZUL , YELMO CINES PLANETOCIO, YELMO CINES PLENILUNIO, YELMO CINES RIVAS H2O, YELMO CINES TRESAGUAS<br />
•         Málaga: YELMO CINES PLAZA MAYOR, YELMO CINES RINCÓN DE LA VICTORIA, YELMO CINES VIALIA MÁLAGA<br />
•         Navarra: YELMO CINES ITAROA<br />
•         Pontevedra: YELMO CINES VIGO<br />
•         Santa Cruz de Tenerife: YELMO CINES LA VILLA DE OROTAVA, YELMO CINES MERIDIANO<br />
•         Tarragona: YELMO CINES PARC CENTRAL<br />
•         Valencia: YELMO CINES MERCADO DE CAMPANAR<br />
•         Vizcaya: YELMO CINES MEGAPARK<br />
•         Zaragoza: YELMO CINES PLAZA IMPERIAL<br /><br />

	
				<div class="centrar">
					Aquí puedes ver los trailers de ambas películas!!!<br />
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/2n0GRckCptQ" frameborder="0" allowfullscreen></iframe><br />
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/PbQOK0ldr9U" frameborder="0" allowfullscreen></iframe>
                </div>
                </p>
                <p  class="cc">También puedes mandarnos un email a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre completo, tu e-mail, en qué ciudad y qué cine y cual de las dos películas quieres ver (o ambas!)</p>
        <p  class="cc">El concurso se cerrará el 18 de septimebre a las 0.00 horas para Slipknot y el día 25 para Black Sabbath.</p>
	          
        </div>
        	
        	<div id="formulari">

		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar">
					<img src="pics/sorteig/sorteo_slipknot.jpg" width="300"  alt="Slipknot" />
					<img src="pics/sorteig/sorteo_blacksabbath.jpg" width="300"  alt="Black Sabbath" />
				</div>
	
				
	
				<p class="cc">
				Ja tenim els guanyadors per anar a veure <span class="cursiva">"Day Of The Gusano”</span>, documental de la actuació de <span class="cursiva">Slipknot</span>. Són:<br /><br />

 
•         Jordi Ruiz Salvadó en BARCELONA<br />
•         Rodrigo Puché Tolos en VALENCIA<br /><br />
					Poden recollir les seves dues entrades el proper 21 setembre a partir de las 20.00h a guixeta.<br /><br />

			
			- "The End Of The End" és el film que documenta l'últim concert de la gira de comiat de la mítica banda de metall, Black Sabbath. <br /> <br />
Serà el dia 28 a les 20h i pots escollir entre els següents cinemes: <br /> <br />
 
•         A Coruña: YELMO CINES ESPACIO CORUÑA<br />
•         Álava: YELMO CINES BOULEVARD<br />
•         Albacete: YELMO CINES VIALIA ALBACETE<br />
•         Alicante: YELMO CINES PUERTA DE ALICANTE, YELMO CINES VINALOPO<br />
•         Almería: YELMO CINES ROQUETAS<br />
•         Asturias: YELMO CINES OCIMAX GIJON, YELMO CINES LOS PRADOS<br />
•         Barcelona: YELMO CINES ICARIA, YELMO CINES CASTELLDEFELS,YELMO CINES ABRERA, YELMO CINES COMEDIA, YELMO CINES SANT CUGAT,<br />
•         Cádiz: YELMO CINES AREA SUR<br />
•         La Rioja: YELMO CINES BERCEO<br />
•         Las Palmas: YELMO CINES LAS ARENAS, YELMO CINES FUERTEVENTURA, YELMO CINES VECINDARIO<br />
•         Madrid : YELMO CINES ISLAZUL , YELMO CINES PLANETOCIO, YELMO CINES PLENILUNIO, YELMO CINES RIVAS H2O, YELMO CINES TRESAGUAS<br />
•         Málaga: YELMO CINES PLAZA MAYOR, YELMO CINES RINCÓN DE LA VICTORIA, YELMO CINES VIALIA MÁLAGA<br />
•         Navarra: YELMO CINES ITAROA<br />
•         Pontevedra: YELMO CINES VIGO<br />
•         Santa Cruz de Tenerife: YELMO CINES LA VILLA DE OROTAVA, YELMO CINES MERIDIANO<br />
•         Tarragona: YELMO CINES PARC CENTRAL<br />
•         Valencia: YELMO CINES MERCADO DE CAMPANAR<br />
•         Vizcaya: YELMO CINES MEGAPARK<br />
•         Zaragoza: YELMO CINES PLAZA IMPERIAL<br /><br />

	
				<div class="centrar">
					Aquí puedes ver los trailers de ambas películas!!!<br />
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/2n0GRckCptQ" frameborder="0" allowfullscreen></iframe><br />
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/PbQOK0ldr9U" frameborder="0" allowfullscreen></iframe>
                </div>
                </p>
                        <p  class="cc">També pots enviar-nos un correu electrònic a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicant el teu nom complet, el teu e-mail, en quina ciutat i quin cinema i quina de les dues pel·lícules vols veure (o ambdues!)</p>
        <p  class="cc">El concurs es tancarà el 18 de setembre a les 0.00 hores per Slipknot i el dia 25 per a Black Sabbath.</p>
	          
        </div>
        	
        	<div id="formulari">
        
		<?php
		}
		
		$name='';
		$email='';
		$ciutat='';
		$cine='';
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
		print '</tr><tr onmouseover="posarDescripcioCiutat(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe la ciudad/cine al que quieres ir'";
			break;
			case 'CAT':
				print "'Escriu la ciutat/cinema al que vols anar'";
			break;
		}
		print ')" onmouseout="borrarDescripcioCiutat()">';
		print '<td class="celdaesq">Ciudad/Cine: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="ciutat" size="35" maxlength="200" value="'.$ciutat.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioCiutat"></span></td>';
		print '</tr><tr onmouseover="posarDescripcioObs(';
		switch ($page->leng)
		{
			case 'ES':
				print "'Escribe la película que te interesa'";
			break;
			case 'CAT':
				print "'Escriu la pel·lícula que t'interessa'";
			break;
		}
		print ')" onmouseout="borrarDescripcioObs()">';
		print '<td class="celdaesq">Película: </td>';
		print '<td class="celdadreta"><input style="border: 1px solid #FFF;" type="text" name="cine" size="35" maxlength="200" value="'.$cine.'"/></td>';
		print '<td class="celdadreta"><span id="descripcioObs"></span></td>';
		print '</tr>';
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div>';
	}
break;
case 'dunedain':
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
						print '<p class="error">Gràcies per participar.</p>';
					break;
					
				}
				$subject='Sorteig Dünedain';
				$message="Concurs Dünedain<br />enviat per: $name \r\n amb el mail $email";
				mail('info@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo 2 entradas Dünedain + Tales of Gaia + Fanum Somnia</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig 2 entrades Dünedain + Tales of Gaia + Fanum Somnia</p>
			</div>
		<?php		
		}
        ?>
		<div id="cos">     
				<div class="centrar"><img src="pics/conc/20170403160035.png" width="500"  alt="Dünedain + Tales of Gaia + Fanum Somnia" /></div>
	
				
	
				<p class="cc">
				El próximo 13 de Mayo, en la sala Upload de Barcelona tenemos una cita con Dünedain presentando su nuevo trabajo Pandemonium, Tales of Gaia quienes también están de presentación y la puesta en escena de Fanum Somnia.<br /><br />
				Para ello y por cortesía de Chroma Nation, hemos sorteado dos entradas individuales para asistir y las ganadoras han sido las siguientes:<br /><br />
				· Lydia Serrano Fernández <br />
				· Sara Abad Borraz<br /><br />
				ENHORABUENA!<br />
				Muchas gracias a todos por participar y confiar en Satan Arise!!!
				
				</p>
				<div class="centrar">
				<iframe width="560" height="315" src="https://www.youtube.com/embed/ntu_Kyglthw" frameborder="0" allowfullscreen></iframe>
				</div>
				
			</div>
               
				

		<?php
	}
break;
}
?>