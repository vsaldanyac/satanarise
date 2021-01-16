<?php

switch ($page->concurs)
{
	case 'nudo':
	if (isset($_POST['enviat'])) {
		if ($_POST['enviat']='si') {
			$correcte=1;
			$error=array(0, 0, 0);
			$name=strip_tags(rtrim($_POST['name']));
			$email=strip_tags(rtrim($_POST['email']));		
			$tema=strip_tags(rtrim($_POST['ciutat']));		
			if (strlen($name) == 0) {
				$correcte=0;
				$error[0]=1;
			}
			if (!(preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$email))) {
				$error[1]=1;
				$correcte=0;
			}
			if (strlen($tema) == 0) {
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
					$error_detall[0] = $error_detall[0].'No has puesto ninguna canción.<br />';						
					$error_detall[1] = $error_detall[1].'No has posat cap cançó.<br />';						
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
				$subject='Sorteig CD Nudo';
				$message="Concurs CD Nudo<br />enviat per: $name <br />\r\nEmail: $email <br />\r\nCançó preferida és: $tema";
				mail('sorteo_nudo@satanarise.com',$subject,$message,"Content-type: text/html; charset=utf-8\r\nFrom: $name <$email>\r\nReply-To: $email \r\n");	
			}
		}
	
	} else {
		if ($page->leng == 'ES') {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteo de un CD de Nudo</p>
			</div>
		<?php
		} else {
		?>
			<div class="titdiscos"> <!-- Titol de discos -->
				<p>Sorteig de un CD de Nudo</p>
			</div>
		<?php		
		}
		if ($page->leng == 'ES') {
		?>
		<div id="cos">     
				<div class="centrar"><img src="pics/sorteig/nudoLogo.png" width="400"  alt="Nudo" /><br />
					<a class="linkk" href="http://www.satanarise.com/index.php?ln=ES&sec=criticas&type=entrada&id=706&cont=nudo_juiciofinal" target="_blank" >
					<img src="pics/sorteig/portadaNudo.jpg" width="400"  alt="Nudo" />
					</a>
				</div>
	
				
	
				<p class="cc">
				Ya tenemos ganador del sorteo del disco de Nudo!!
				<br /><br />
				Se trata de Tino Muñoz Sánchez!
				<br /><br /><br />
				ENHORABUENA y gracias por confiar en SatanArise!!!!!
	</p>
</div>
				
			
		<?php
		} else {
		?>
			<div id="cos">     
				<div class="centrar">img src="pics/sorteig/nudoLogo.png" width="400"  alt="Nudo" /><br />
					<img src="pics/sorteig/portadaNudo.jpg" width="400"  alt="Nudo" /></div>
	
				
	
				<p class="cc">
				Ja tenim guanyador del sorteig del disc de Nudo!!
				<br /><br /><br />
				Es tracta de Tino Muñoz Sánchez!
				<br /><br />
				Enhorabona i gràcies per confiar en SatanArise!!!
	
	</p>          
				  </div>
        
		<?php
		}
		
	}
	
break;
}
?>