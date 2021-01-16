<?php
switch ($page->concurs)
{
/*case '2oaniversario':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			$texte=($_POST['texte']);
			if (strlen($name) == 0) {
				$correcte=0;
				$error[0]=1;
			}
			if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))) {
				$error[1]=1;
				$correcte=0;
			}
			if (strlen($name) == 0) {
				$error[2]=1;
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
					$error_detall[0] = $error_detall[0].'No has introducido ningún comentario.<br />';						
					$error_detall[1] = $error_detall[1].'No has introduït cap comentari.<br />';						
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
				$texte=nl2br(htmlspecialchars($texte));
				$subject='Sorteig 2on Aniversari';
				$message="Concurs del 2on aniversari <br />enviat per: $name \r\n amb el mail $email <br /> amb el següent missatge: <br />$texte";
				mail('sorteo_aniversario@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo 2o Aniversario</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig 2on Aniversari</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<p class="cc">Para celebrar que Satan Arise cumple su segundo aniversario os hemos preparado un sorteo muy especial, con el paso de los días iremos anunciando diferentes bandas que han colaborado para la ocasión para poder preparar unos lotes de cd's y camisetas que sortearemos para vosotros que os gusta el metal, que sois el verdadero sentido de esta web.</p>
                
                <p class="cc">Cada día actualizaremos los lotes para ir añadiendoles nuevos contenidos. Cada día una banda, cada día los lotes irán aumentando de tamaño, no te lo puedes perder.</p>
                
                <p class="cc">Para participar sólo tienes que rellenar el formulario de abajo o enviar un mail a <a class="linkk" href="mailto:sorteo_aniversario@satanarise.com" >sorteo_aniversario@satanarise.com</a> contando que es lo que más os gusta de la web.</p>

				<div class="centrar"><a href="pics/sorteig/pic_28.jpg" rel="lightbox" title="Sorteo 2o Aniversario"><img src="pics/sorteig/pic_28.jpg" width="450"  alt="Sorteo 2o Aniversario" /></a><br /><br />
                
                <a class="linkk" href="https://www.facebook.com/amadeustheband"><img src="pics/logos/amadeus.png" width="150" align="middle" alt="Amadeus" /></a>
                <a class="linkk" href="https://www.facebook.com/Asfaltika"><img src="pics/logos/asfaltika.jpg" width="150" align="middle" alt="Asfaltika" /></a>
                <a class="linkk" href="https://www.facebook.com/metalastralgrupo"><img src="pics/logos/astral.jpg" width="150" align="middle" alt="Astral" /></a>
                <a class="linkk" href="https://www.facebook.com/pages/A-Tempered-Heart/250392907029"><img src="pics/logos/atemperedheart.jpg" width="150" align="middle" alt="A Tempered Heart" /></a>
                <a class="linkk" href="https://www.facebook.com/crownless.metal"><img src="pics/logos/crownless.jpg" width="150" align="middle" alt="Crownless" /></a>
                <a class="linkk" href="https://www.facebook.com/cyanbloodbane95"><img src="pics/logos/cyanbloodbane.jpg" width="150" align="middle" alt="Cyan Bloodbane" /></a>
                <a class="linkk" href="https://www.facebook.com/DORIAOFICIAL"><img src="pics/logos/doria.jpg" width="150" align="middle" alt="Döria" /></a>
                <a class="linkk" href="https://www.facebook.com/DragonflyOficial"><img src="pics/logos/dragonfly.gif" width="150" align="middle" alt="Dragonfly" /></a>
                <a class="linkk" href="https://www.facebook.com/Drakumband"><img src="pics/logos/drakum.jpg" width="150" align="middle" alt="Drakum" /></a>
                <a class="linkk" href="https://www.facebook.com/DryRiverCS"><img src="pics/logos/dryriver.jpg" width="150" align="middle" alt="Dry River" /></a>
                <a class="linkk" href="https://www.facebook.com/Edhellenband"><img src="pics/logos/edhellen.jpg" width="150" align="middle" alt="Edhellen" /></a>
                <a class="linkk" href="https://www.facebook.com/Icestormbcn"><img src="pics/logos/icestorm.jpg" width="150" align="middle" alt="Icestorm" /></a>
                <a class="linkk" href="https://www.facebook.com/insightafterdoomsday"><img src="pics/logos/insightafterdoomsday.jpg" width="150" align="middle" alt="Insight After Doomsday" /></a>
                <a class="linkk" href="https://www.facebook.com/IncursedOfficial"><img src="pics/logos/incursed.jpg" width="150" align="middle" alt="Incursed" /></a>
                <a class="linkk" href="https://www.facebook.com/invainmetal"><img src="pics/logos/invain.jpg" width="150" align="middle" alt="In Vain" /></a>
                <a class="linkk" href="https://www.facebook.com/joserubionovaera"><img src="pics/logos/joserubiosnovaera.jpg" width="140" align="middle" alt="José Rubio'Nova Era" /></a>
                <a class="linkk" href="https://www.facebook.com/LeithianOficial"><img src="pics/logos/leithian.jpg" width="150" align="middle" alt="Leithian" /></a>
                <a class="linkk" href="https://www.facebook.com/maleekmetalband"><img src="pics/logos/maleek.jpg" width="150" align="middle" alt="Maleek" /></a>
                <a class="linkk" href="https://www.facebook.com/masterly2011"><img src="pics/logos/masterly.jpg" width="150" align="middle" alt="Masterly" /></a>
                <a class="linkk" href="https://www.facebook.com/menziaband"><img src="pics/logos/menzia.jpg" width="150" align="middle" alt="Menzia" /></a>
                <a class="linkk" href="https://www.facebook.com/moonshide"><img src="pics/logos/moonshide.jpg" width="150" align="middle" alt="Moonshide" /></a>
                <a class="linkk" href="https://www.facebook.com/Pareidolian"><img src="pics/logos/pareidolian.jpg" width="150" align="middle" alt="Pareidolian" /></a>
                <a class="linkk" href="https://www.facebook.com/Perfect.Smile.Oficial"><img src="pics/logos/perfectsmile.jpg" width="150" align="middle" alt="Perfect Smile" /></a>
                <a class="linkk" href="https://www.facebook.com/queloniometal"><img src="pics/logos/quelonio.jpg" width="150" align="middle" alt="Quelonio" /></a>
                <a class="linkk" href="https://www.facebook.com/Ravenbloodmetal"><img src="pics/logos/ravenblood.jpg" width="150" align="middle" alt="Ravenblood" /></a>
                <a class="linkk" href="https://www.facebook.com/sylvaniametal"><img src="pics/logos/sylvania.jpg" width="150" align="middle" alt="Sylvania" /></a>
                <a class="linkk" href="https://www.facebook.com/TaoPerfilOficial"><img src="pics/logos/tao.jpg" width="150" align="middle" alt="Tao" /></a>
                <a class="linkk" href="https://www.facebook.com/TheZenMetal"><img src="pics/logos/thezen.jpg" width="150" align="middle" alt="The Zen" /></a>
                
                </div>   
	
				<p class="cc">Contenidos:</p>
                <p class="cc"><span class="cursiva">Lote 1</span>:<br /> CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Amadeüs - Black Jack<br />
                Amadeüs - Caminos Del Alma<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                A Tempered Heart - An Eerie Sense Of Calm<br />
                Crownless - Dark Evolution<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Döria - Despertar<br />
                Dragonfly - Non Requiem<br />
				Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
                Edhellen - Sombra y Anhelo<br />
                Icestorm - Contes De La Vall De Glaç<br />
                Incursed - Fimbulwinter<br />
                In Vain - In Death We Trust<br />
                Inside - The Son Of A New Spirit<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Leithian - Sin Limites<br />
                Maleek - Rosas De Rarajevo<br />
                Maleek - Tras El Mito De La Caverna<br />
                Maleek - Olvidados Por La Historia<br />
                Masterly - Sin Identidad<br />
                Menzia - Way To Nowhere<br />
                Pareidolian - Jardín De Ébano<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Ravenblood - Beyond The Ghost's Pride<br />
                Sylvania - Lazos de sangre<br />
                The Zen - Somewhere On Earth<br />
                <br />Camisetas:<br /> 
                Icestorm (L)<br />
                Döria (L)<br />
                Drakum (L)<br />
                In Vain (XL)<br />
                Masterly (XL)<br />
                Moonshide (L)<br />
                The Zen (S)<br />
                Tao (L)
                
</p>
                <p class="cc"><span class="cursiva">Lote 2</span>:<br /> CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Döria - Despertar<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
                Icestorm - Contes De La Vall De Glaç<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Masterly - Sin Identidad<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Sylvania - Lazos de sangre<br />
				<br />Camisetas:<br /> 
                Amadeüs(L)<br />
                Drakum (L)(Mujer)<br />
                Icestorm (L)<br />
                Maleek(L)
</p>
                <p class="cc"><span class="cursiva">Lote 3</span>:<br /> CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Döria - Despertar<br />
                Dragonfly - Non Requiem<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
                Icestorm - Contes De La Vall De Glaç<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
				<br />Camisetas:<br /> Icestorm (L)<br />
                Maleek(L)
                Pareidolian(L)<br />
                The Zen (S)</p>
                
                
                <p class="cc"><span class="cursiva">Lote 4</span>:<br /> CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Döria - Despertar<br />
                Dragonfly - Non Requiem<br />
                Dry River - El Circo De La Tierra<br />
                Edhellen - Sombra y Anhelo<br />
                Icestorm - Contes De La Vall De Glaç<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Sylvania - Lazos de sangre<br />
				<br />Camisetas:<br /> 
                Döria (XL)<br /> 
                Icestorm (L)<br />
                Maleek(L)<br />
                Tao (L)</p>
                
                <p class="cc"><span class="cursiva">Lote 5</span>:<br /> CD's:<br /> 
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Crownless - Dark Evolution<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
                In Vain - In Death We Trust<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Masterly - Sin Identidad<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Sylvania - Lazos de sangre<br />
                Camisetas<br />
                In Vain (XL)<br />
                Moonshide (L)

</p>
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<p class="cc">Per celebrar que Satan Arise cumpleix el seu segon aniversari us hem preparat un sorteig molt especial, amb el pas dels dies anirem anunciant diferents bandes que han col·laborat en aquest sorteig per poder preparar uns lots de cd's i samarretes que sortejarem per a vosaltres que us agrada el metal i que sou l'essència d'aquesta web.</p>
                
                <p class="cc">Cada día actualitzarem els lots per anar afegint nous contingus. Cada dia una banda, cada dia els lots aniran creixent de tamany, no t'ho pots perdre.</p>
                
                <p class="cc">Per participar només has d'omplir el formulari de sota o enviar un mail a <a class="linkk" href="mailto:sorteo_aniversario@satanarise.com" >sorteo_aniversario@satanarise.com</a> dient que és el que més t'agrada de la web.</p>

				<div class="centrar"><a href="pics/sorteig/pic_28.jpg" rel="lightbox" title="Sorteo 2o Aniversario"><img src="pics/sorteig/pic_28.jpg" width="450"  alt="Sorteo 2o Aniversario" /></a><br /><br />
                <a class="linkk" href="https://www.facebook.com/amadeustheband"><img src="pics/logos/amadeus.png" width="150" align="middle" alt="Amadeus" /></a>
                <a class="linkk" href="https://www.facebook.com/Asfaltika"><img src="pics/logos/asfaltika.jpg" width="150" align="middle" alt="Asfaltika" /></a>
                <a class="linkk" href="https://www.facebook.com/metalastralgrupo"><img src="pics/logos/astral.jpg" width="150" align="middle" alt="Astral" /></a>
                <a class="linkk" href="https://www.facebook.com/pages/A-Tempered-Heart/250392907029"><img src="pics/logos/atemperedheart.jpg" width="150" align="middle" alt="A Tempered Heart" /></a>
                <a class="linkk" href="https://www.facebook.com/crownless.metal"><img src="pics/logos/crownless.jpg" width="150" align="middle" alt="Crownless" /></a>
                <a class="linkk" href="https://www.facebook.com/cyanbloodbane95"><img src="pics/logos/cyanbloodbane.jpg" width="150" align="middle" alt="Cyan Bloodbane" /></a>
                <a class="linkk" href="https://www.facebook.com/DORIAOFICIAL"><img src="pics/logos/doria.jpg" width="150" align="middle" alt="Döria" /></a>
                <a class="linkk" href="https://www.facebook.com/DragonflyOficial"><img src="pics/logos/dragonfly.gif" width="150" align="middle" alt="Dragonfly" /></a>
                <a class="linkk" href="https://www.facebook.com/Drakumband"><img src="pics/logos/drakum.jpg" width="150" align="middle" alt="Drakum" /></a>
                <a class="linkk" href="https://www.facebook.com/DryRiverCS"><img src="pics/logos/dryriver.jpg" width="150" align="middle" alt="Dry River" /></a>
                <a class="linkk" href="https://www.facebook.com/Edhellenband"><img src="pics/logos/edhellen.jpg" width="150" align="middle" alt="Edhellen" /></a>
                <a class="linkk" href="https://www.facebook.com/Icestormbcn"><img src="pics/logos/icestorm.jpg" width="150" align="middle" alt="Icestorm" /></a>
                <a class="linkk" href="https://www.facebook.com/insightafterdoomsday"><img src="pics/logos/insightafterdoomsday.jpg" width="150" align="middle" alt="Insight After Doomsday" /></a>
                <a class="linkk" href="https://www.facebook.com/IncursedOfficial"><img src="pics/logos/incursed.jpg" width="150" align="middle" alt="Incursed" /></a>
                <a class="linkk" href="https://www.facebook.com/invainmetal"><img src="pics/logos/invain.jpg" width="150" align="middle" alt="In Vain" /></a>
                <a class="linkk" href="https://www.facebook.com/joserubionovaera"><img src="pics/logos/joserubiosnovaera.jpg" width="140" align="middle" alt="José Rubio'Nova Era" /></a>
                <a class="linkk" href="https://www.facebook.com/LeithianOficial"><img src="pics/logos/leithian.jpg" width="150" align="middle" alt="Leithian" /></a>
                <a class="linkk" href="https://www.facebook.com/maleekmetalband"><img src="pics/logos/maleek.jpg" width="150" align="middle" alt="Maleek" /></a>
                <a class="linkk" href="https://www.facebook.com/masterly2011"><img src="pics/logos/masterly.jpg" width="150" align="middle" alt="Masterly" /></a>
                <a class="linkk" href="https://www.facebook.com/menziaband"><img src="pics/logos/menzia.jpg" width="150" align="middle" alt="Menzia" /></a>
                <a class="linkk" href="https://www.facebook.com/moonshide"><img src="pics/logos/moonshide.jpg" width="150" align="middle" alt="Moonshide" /></a>
                <a class="linkk" href="https://www.facebook.com/Pareidolian"><img src="pics/logos/pareidolian.jpg" width="150" align="middle" alt="Pareidolian" /></a>
                <a class="linkk" href="https://www.facebook.com/Perfect.Smile.Oficial"><img src="pics/logos/perfectsmile.jpg" width="150" align="middle" alt="Perfect Smile" /></a>
                <a class="linkk" href="https://www.facebook.com/queloniometal"><img src="pics/logos/quelonio.jpg" width="150" align="middle" alt="Quelonio" /></a>
                <a class="linkk" href="https://www.facebook.com/Ravenbloodmetal"><img src="pics/logos/ravenblood.jpg" width="150" align="middle" alt="Ravenblood" /></a>
                <a class="linkk" href="https://www.facebook.com/sylvaniametal"><img src="pics/logos/sylvania.jpg" width="150" align="middle" alt="Sylvania" /></a>
                <a class="linkk" href="https://www.facebook.com/TaoPerfilOficial"><img src="pics/logos/tao.jpg" width="150" align="middle" alt="Tao" /></a>
                <a class="linkk" href="https://www.facebook.com/TheZenMetal"><img src="pics/logos/thezen.jpg" width="150" align="middle" alt="The Zen" /></a>
                </div>   
	
				<p class="cc">Continguts:</p>
                <p class="cc"><span class="cursiva">Lot 1</span>:<br />CD's:<br />
                Amadeüs - Black Jack<br />
                Amadeüs - Caminos Del Alma<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                A Tempered Heart - An Eerie Sense Of Calm<br />
                Crownless - Dark Evolution<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Döria - Despertar<br />
                Dragonfly - Non Requiem<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
                Edhellen - Sombra y Anhelo<br />
				Icestorm - Contes De La Vall De Glaç<br />
                Incursed - Fimbulwinter<br />
                In Vain - In Death We Trust<br />                
                Inside - The Son Of A New Spirit<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Leithian - Sin Limites<br />
                Maleek - Rosas De Rarajevo<br />
                Maleek - Tras El Mito De La Caverna<br />
                Maleek - Olvidados Por La Historia<br />
                Menzia - Way To Nowhere<br />
                Masterly - Sin Identidad<br />
                Pareidolian - Jardín De Ébano<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Ravenblood - Beyond The Ghost's Pride<br />
                Sylvania - Lazos de sangre<br />
                The Zen - Somewhere On Earth<br />
                Samarretes:<br />
                Döria (L)<br /> 
                Icestorm (L)<br />
                Drakum (L)<br />
                In Vain (XL)<br />
                Masterly (XL)<br />
                Moonshide (L)<br />
                The Zen (S)<br />
                Tao (L)
                </p>
                <p class="cc"><span class="cursiva">Lot 2</span>:<br />CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Döria - Despertar<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
				Icestorm - Contes De La Vall De Glaç<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Masterly - Sin Identidad<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Sylvania - Lazos de sangre<br />
                Samarretes:<br /> 
                Amadeüs(L)<br />
                Drakum (L)(Mujer)<br />
                Icestorm (L)<br />
				Maleek(L)</p>
                
                <p class="cc"><span class="cursiva">Lot 3</span>:<br />CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Döria - Despertar<br />
                Dragonfly - Non Requiem<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
				Icestorm - Contes De La Vall De Glaç<br />
                Inside After Doomsday - Aware<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Samarretes:<br /> 
                Icestorm (L)<br />
                Maleek(L)
                Pareidolian(L)<br />
                The Zen (S)</p>
                
                <p class="cc"><span class="cursiva">Lot 4</span>:<br />CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Döria - Despertar<br />
                Dragonfly - Non Requiem<br />
                Dry River - El Circo De La Tierra<br />
                Edhellen - Sombra y Anhelo<br />
				Icestorm - Contes De La Vall De Glaç<br />
                Jose Rubio's Nava Era - Nova Era<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Sylvania - Lazos de sangre<br />
                Samarretes:<br />
                Döria (XL)<br /> 
                Icestorm (L)<br />
                Maleek<br />
                Tao(L)</p>
                <p class="cc"><span class="cursiva">Lot 5</span>:<br />CD's:<br />
                Asfaltika - Mundo De Cristal<br />
                Astral - Mundo Perdido, Mundo Prohibido<br />
                Crownless - Dark Evolution<br />
                Cyan Bloodbane - Nuevos Tiempos<br />
                Drakum - Arround The Oak<br />
                Dry River - El Circo De La Tierra<br />
                In Vain - In Death We Trust<br />
                Inside After Doomsday - Aware<br />                
                Jose Rubio's Nava Era - Nova Era<br />
                Masterly - Sin Identidad<br />
                Perfect Smile - Mañana Puede Ser Peor<br />
                Quelonio - Rebelión<br />
                Sylvania - Lazos de sangre<br />
                Samarretes:<br />
                In Vain (XL)<br />
                Moonshide (L)</p>
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
				print "Nombre y apellidos:";
			break;
			case 'CAT':
				print "Nom i cognoms:";
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
		print '</tr><tr>';
		print '<td class="doble">';
		switch ($page->leng)
		{
			case 'ES':
				print "¿Que es lo que más te gusta de Satan Arise?";
			break;
			case 'CAT':
				print "Qué és el que més t'agrada de Satan Arise?";
			break;
		}
		print '</td><td class="doble">';
		print '<textarea name="texte"></textarea></td></tr>'; 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>';
	}
		switch ($page->leng)
		{
			case 'ES':
				print '<p class="cc">Sólo participantes de la península.</p>';
			break;
			case 'CAT':
				print '<p class="cc">Només participnats de la península.</p>';
			break;
		}
break;*/

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
case 'zenobia':
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
				$subject='Sorteig Zenobia';
				$message="Concurs Zenobia<br />enviat per: $name \r\n amb el mail $email";
				mail('zenobia@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo Zenobia</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig Zenobia</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/logos/zenobia.jpg" width="400"  alt="zenobia" /></div>
	
				
	
				<p class="cc">
				Los riojanos Zenobia visitan la Ciudad Condal el próximo 30 de noviembre en una parada más de su gira Unidos Por El Metal junto a Dünedain en la centrica sala Music Hall. <br /><br />
	
	
				<div class="centrar">
                    <img src="pics/conc/13_11_30_zen.jpg" width="450" align="middle"/><br /><br />
                </div>
                </p>
                
	           <p  class="cc">No podíamos sino celebrarlo junto a Zenobia.<br />
               Las entradas anticipadas para el concierto se pueden comprar con descuento aportando la entrada de nuestro segundo aniversario, costando 8€. Así que ya puedes aprovecharte de eso sin esperar a comprarla el día del concierto.</p>
               <p  class="cc">Y por si eso no fuera poco, arrancamos un nuevo sorteo de material de Zenobia compusto por:<br />
               <br />
               - Camisetas de Zenobia<br />
               - Cd's de Armageddon<br />
               - 1 Dvd de Unidos Por El Metal</p>
	               
               <p  class="cc">¿Qué hay que hacer? Es muy sencillo, primero tener la entrada para el concierto y asistir, dado que los premios se sortearan en el mismo concierto. <br />
               En segundo lugar tienes dos opciones a elegir, Facebook o Twitter, por que los ganadores deberán tener Me Gusta a Zenobia y Satan Arise en Facebook o ser seguidores de ambos en Twitter.</p>
       <p  class="cc">Para participar escribenos a <a class="linkk" href="mailto:zenobia@satanarise.com" >zenobia@satanarise.com</a> indicando tu nombre completo, nombre de facebook/twitter y tu e-mail y entrarás en el sorteo... o rellena el siguiente formulario.</p>
        <p  class="cc">El concurso se cerrará el jueves 28 de noviembre a las 0.00 horas.</p>

				
				<div id="formulari">
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar"><img src="pics/logos/zenobia.jpg" width="400"  alt="zenobia" /></div>
	
				
	
				<p class="cc">
				Zenobia visiten la Ciutat Comtal el proper 30 de novembre en una parada més de la seva gira Unidos Por El Metal juntament amb Dünedain a la céntrica sala Music Hall. <br /><br />
	
	
				<div class="centrar">
                    <img src="pics/conc/13_11_30_zen.jpg" width="450" align="middle"/><br /><br />
                </div>
                </p>
                
	           <p  class="cc">No podieos sino celebrar-ho juntament amb Zenobia.<br />
               Les entrades anticipades pel concert es poden comprar amb descompte portant l'entrada del nuestre segon aniversari, costat 8€. Així que ja pots aprofitar-te d'això sense esperar a compar-la el día del concert.</p>
               <p  class="cc">I per si això no fos poc, arrenquem un nou sorteig de material de Zenobia format per:<br />
               <br />
               - Samarretes de Zenobia<br />
               - Cd's de Armageddon<br />
               - 1 Dvd de Unidos Por El Metal</p>
	               
               <p  class="cc">Qué s'ha de fer? Es molt senzill, primer tenir l'entrada pel concert i anar-hi, perque els premis s'entregaran al mateix concert.<br />
               En segon lloc tens dos opcions a escollir, Facebook o Twitter, perque els guanyadors hauran de tenir Me Gusta a Zenobia i Satan Arise a Facebook o ser seguidors dels dos a Twitter.</p>
       <p  class="cc">Per participar escriu-nos a <a class="linkk" href="mailto:zenobia@satanarise.com" >zenobia@satanarise.com</a> posant el teu nom complet, nom  a facebook/twitter i el teu e-mail i participaràs al concurs... o omplir el següent formulari.</p>
        <p  class="cc">El concurso es tancarà el dijous 28 de novembre a les 0.00 hores.</p>

				
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
 
		print '</table><p class="botons"><input type="submit" value="Enviar" name="enviar" /></p></form></div></div>';
	}
break;
}
?>


            
        