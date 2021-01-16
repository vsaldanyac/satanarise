<?php

switch ($page->concurs)
{
case 'talesofgaia':
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
				$subject='Sorteig Tales of Gaia';
				$message="Concurs Tales of Gaia<br />enviat per: $name \r\n amb el mail $email";
				mail('sorteo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Tales of Gaia</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Tales of Gaia</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/logos/talesofgaia.jpg" width="400"  alt="Tales of Gaia" /></div>
	
				
	
				<p class="cc">
				Tales of Gaia está de enhorabuena y tienen nuevo material de merchandising que quieren compartir contigo! Para ello sortean 2 packs individuales con la camiseta de la banda (la talla la que digan los afortunados) y por otro lado 2 packs individuales con la camiseta (la talla la que digan los afortunados) y el EP de la banda, que tan buenas críticas cosechó.<br />
	
	
				<div class="centrar">
                <img src="pics/sorteig/talesofgaia.jpg" width="450" align="middle"/><br /><br />

                </div>

                
	
	</p>          <p  class="cc">Desde Satan Arise os ofrecemos la oportunidad de obtenerlo, así pues escribenos a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicando tu nombre completo y tu e-mail y entrarás en el sorteo... o rellena el siguiente formulario.</p>
        <p  class="cc">El concurso se cerrará el proximo 8 mayo a las 0.00 horas.</p>

				
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/logos/talesofgaia.jpg" width="400"  alt="Tales of Gaia" /></div>
	
				
	
				<p class="cc">
				Tales of Gaia està d'enhorabona i tenen nou material de marxandatge que volen compartir amb tu! Per a això sortegen 2 packs individuals amb la samarreta de la banda (la talla la que diguin els afortunats) i d'altra banda 2 packs individuals amb la samarreta (la talla la que diguin els afortunats) i l'EP de la banda, que tan bones crítiques collir. <br />
	
	
				<div class="centrar">
               <img src="pics/sorteig/talesofgaia.jpg" width="450" align="middle"/><br /><br />
                </div>

                
	
	</p>          <p  class="cc">Des de Satan Arise os oferim la oportunitat d'obtenir-ho, així doncs, escriu-nos a <a class="linkk" href="mailto:sorteo@satanarise.com" >sorteo@satanarise.com</a> indicant el teu nom copmlet, i el teu e-mail i entraràs al sorteig... o emplena el següent formulari.</p>
        <p  class="cc">El concurso es tancarà el 8 de maig a les 0.00 hores.</p>

				
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
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div><br />
        	<div class="centrar"><iframe width="560" height="315" src="https://www.youtube.com/embed/mAXrWr7rpyE" frameborder="0" allowfullscreen></iframe></div></div>';
	}
break;
}
?>