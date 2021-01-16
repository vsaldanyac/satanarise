<?php

switch ($page->concurs)
{
case 'menzia':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0);
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
				$subject='Sorteig Menzia';
				$message="Concurs Menzia<br />enviat per: $name \r\n amb el mail $email";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo 4 entradas y CDs Unveil de Menzia</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig 4 entrades i CDs Unveil de Menzia</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/banner/unveil_menzia.jpg" width="700"  alt="Menzia" /></div>
	
				
	
				<p class="cc">
				Sorteamos cuatro entradas con su correspondiente CD Unveil para la fiesta-concierto presentación de la banda Menzia en la sala Boca Nord de Barcelona el próximo 16 de Abril.
				<br /><br />


Una gran oportunidad para vivir una auténtica fiesta con el directo de esta joven banda y obtener su CD Unveil.<br /><br />
	
	
				<div class="centrar">
                    <img src="pics/covers/menzia_unveil.jpg" width="375" align="middle" /><br />
                    <iframe width="420" height="315" src="//www.youtube.com/embed/o80hO4rCm2I" frameborder="0" allowfullscreen></iframe><br />
                </div>
                </p>
                
	           <p  class="cc">¿Qué hay que hacer? Es muy sencillo, escribenos a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre completo y tu e-mail y entrarás en el sorteo... o rellena el siguiente formulario.</p>
        <p  class="cc">El concurso se cerrará el viernes 8 de abril a las 0.00 horas.<br />
        	Observación: El CD premiado solo se entregará junto a la entrada en taquilla...no es válido a posteriori.</p>

				
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/banner/unveil_menzia.jpg" width="700"  alt="Menzia" /></div>
	
				
	
				<p class="cc">
				Sortegem quatre entrades amb el seu corresponent CD Unveil per a la festa-concert presentació de la banda Menzia a la sala Boca Nord de Barcelona el proper 16 d'Abril.
				<br /><br />


Una gran oportunitat per viure una auténtica festa amb el directe d'aquesta jove banda i obtenir el seu CD Unveil.<br /><br />
	
	
				<div class="centrar">
                    <img src="pics/covers/menzia_unveil.jpg" width="375" align="middle" /><br />
                    <iframe width="420" height="315" src="//www.youtube.com/embed/o80hO4rCm2I" frameborder="0" allowfullscreen></iframe><br />
                </div>
                </p>
                
	           <p  class="cc">Què cal fer? És molt sencill, escriu-nos a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicant el teu nom complet i el teu e-mail i entraràs al sorteig... o emplena el següent formulari.</p>
        <p  class="cc">El concurso se cerrará el divendres 8 de abril a las 0.00 horas.<br />
        	Observació: El CD premiat només s'entregarà amb l'entrada a taquilla...no és vàlid a posteriori.</p>
        
				<div id="formulari">
		<?php
		}
		
		$name='';
		$email='';
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
		print '</tr>';
		

 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>';
	}
break;
}
?>