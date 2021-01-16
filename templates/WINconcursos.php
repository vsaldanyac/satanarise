<?php

switch ($page->concurs)
{
case 'riotofviolence':
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
				$subject='Sorteig Riot Of Violence';
				$message="Concurs Riot OF Violence<br />enviat per: $name \r\n amb el mail $email";
				mail('sorteo_riotofviolence@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo discografía Riot Of Violence</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig discografía Riot Of Violence</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/logos/riotofviolence.jpg" width="400"  alt="Riot Of Violence" /></div>
	
				
	
				<p class="cc">
				Riot Of Violence acaban de estrenar disco, Planet Of The Rapes, para celebrarlo vamos a sortear una copia firmada por la banda y otra de su anterior Waiting For Death.<br /><br />
	
	
				<div class="centrar">
                <img src="pics/band/riotofviolence.jpg" width="450" align="middle"/><br /><br />
                <img src="pics/covers/riotofviolence_planetoftherapes.jpg" width="200" align="middle"/>
                <img src="pics/covers/riotofviolence_waitingfordeath.jpg" width="200" align="middle"/>

                </div>

                
	
	</p>          <p  class="cc">Desde Satan Arise os ofrecemos la oportunidad de obtener la discografía de Riot Of Violence por la cara. Así pues escribenos a <a class="linkk" href="mailto:sorteo_riotofviolence@satanarise.com" >sorteo_riotofviolence@satanarise.com</a> indicando tu nombre completo y tu e-mail y entrarás en el sorteo... o rellena el siguiente formulario.</p>
        <p  class="cc">El concurso se cerrará el 30 de noviembre a las 0.00 horas.</p>

				
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/logos/riotofviolence.jpg" width="400"  alt="Riot Of Violence" /></div>
	
				
	
				<p class="cc">
				Riot Of Violence acaban d'estrenar disc, Planet Of The Rapes, per celebrar-ho srotegem una copia dignada per la banda i una del seu anterior disc Waiting For Death.<br /><br />
	
	
				<div class="centrar">
                <img src="pics/covers/riotofviolence_planetoftherapes.jpg" width="200" align="middle"/>
                <img src="pics/covers/riotofviolence_waitingfordeath.jpg" width="200" align="middle"/>

                </div>

                
	
	</p>          <p  class="cc">Desde Satan Arise us oferim l'oportunitat d'obtenir la discografia de Riot Of Violence per la cara. Així docncs escriu-nos a <a class="linkk" href="mailto:sorteo_riotofviolence@satanarise.com" >sorteo_riotofviolence@satanarise.com</a> indicant el teu nom i e-mail i entrarás en el sorteig... o omple el següent formulari.</p>
        <p  class="cc">El concurso se tancará el 30 de novembre a les 0.00 hores.</p>

				
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
case 'voces':
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
				$subject='Sorteig Anima Sacra';
				$message="Concurs Anima Sacra<br />enviat per: $name \r\n amb el mail $email";
				mail('animasacra@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Voces del Rock</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Voces del Rock</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/conc/20140409104946.jpg" width="300"  alt="Voces del Rock" /></div>
	
				
	
				<p class="cc">
				Los ganadores del sorteo para ver Voces del Rock en Salamandra 1 hoy día 11 de Abril del 2014 son: <br /><br />
				· Javier Martinez Andreo<br />
				· Lluis F. Bayona Villarroya<br />
				· Juan Antonio Arboledas Ruiz<br />
				· Marce Roldan<br />
				· María Martínez Saavedra<br /><br />
				ENHORABUENA!!!!<br />
				Podréis recoger vuestra entrada en taquilla, mostrando vuestro DNI.
	
	
				<div class="centrar">
                <iframe width="420" height="315" src="//www.youtube.com/embed/b8pA9XEBN90" frameborder="0" allowfullscreen></iframe>
                </div>
                </p>
                
	           
</div>
				
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/conc/20140409104946.jpg" width="300"  alt="Voces del Rock" /></div>
	
				
	
				<p class="cc">
				Els guanyadors del sorteig per veure a Voces del Rock a Salamandra 1 avui dia 11 d'Abril del 2014, són: <br /><br />
				· Javier Martinez Andreo<br />
				· Lluis F. Bayona Villarroya<br />
				· Juan Antonio Arboledas Ruiz<br />
				· Marce Roldan<br />
				· María Martínez Saavedra<br /><br />
				ENHORABONA!!!!<br />
				Podreu recollir la vostra entrada a la guixeta, ensenyant el vostre DNI.
	
	
				<div class="centrar">
                    <iframe width="420" height="315" src="//www.youtube.com/embed/b8pA9XEBN90" frameborder="0" allowfullscreen></iframe>
                </div>
                </p>
                
	      </div>
        
		<?php
		}
		
	}
	
break;
}
?>