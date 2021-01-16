	</div>
    <div id="col_right">
<?php
        
            require('templates/banners/col_right.php');
        
?>		
   	</div>
    <div id="final">
    
<?php
			
	if ($page->leng == 'ES') {
		$cad_menu = array ('inicio','noticias','criticas','conciertos','cronicas','entrevistas','contacto');
	} else {
		$cad_menu = array ('inici','noticies','critiques','concerts','croniques','entrevistes','contacte');
	}
	$contmax = count($cad_menu); 
	$cont=0;
	if ($page->leng == 'ES') {
		
		while ($cont<=($contmax-1)) {
			switch ($cad_menu[$cont]) {
				case 'inicio':
					$tit = 'Metal, críticas, conciertos, crónicas y entrevistas - Satan Arise';
					$texte = 'Inicio';
				break;
				case 'noticias':
					$tit = 'Noticias del metal - Satan Arise';
					$texte = 'Noticias';
				break;
				case 'criticas':
					$tit = 'Críticas, reviews, novedades metal, discos, critica y tracklist - Satan Arise';
					$texte = 'Críticas';
				break;					
				case 'conciertos':
					$tit = 'Conciertos, fechas, salas, bandas y carteles - Satan Arise';
					$texte = 'Conciertos';
				break;
				case 'cronicas':
					$tit = 'Crónicas de conciertos - Satan Arise';
					$texte = 'Crónicas';
				break;
				case 'entrevistas':
					$tit = 'Entrevistas - Satan Arise';
					$texte = 'Entrevistas';
				break;
				case 'contacto':
					$tit = 'Contacto - Satan Arise';
					$texte = 'Satan Arise';
				break;				

				}
			
			print '<a class="linkblanc" href="index.php?ln='.$page->leng.'&sec='.$cad_menu[$cont].'" title="'.$tit.'">';
			if ($page->section == $cad_menu[$cont]) print '<span class="on">';
			print $texte;
			if ($page->section == $cad_menu[$cont]) print '</span>';
			print '</a>'."\n";
			$cont=$cont+1;
		}
	} else {
		while ($cont<=($contmax-1)) {
			switch ($cad_menu[$cont]) {
				case 'inici':
					$tit = 'Metal, crítiques, concerts, cròniques i entrevistes - Satan Arise';
					$texte = 'Inici';
				break;
				case 'noticies':
					$tit = 'Noticies del metal';
					$texte = 'Noticies';
				break;
				case 'critiques':
					$tit = 'Crítiques, reviews, novetats de metal, discos, crítica i tracklist - Satan Arise';
					$texte = 'Crítiques';
				break;					
				case 'concerts':
					$tit = 'Concerts, datas, sales, bandes i cartells - Satan Arise';
					$texte = 'Concerts';
				break;
				case 'croniques':
					$tit = 'Cròniques de concerts - Satan Arise';
					$texte = 'Crónicas';
				break;
				case 'entrevistes':
					$tit = 'Entrevistes - Satan Arise';
					$texte = 'Entrevistes';
				break;
				case 'contacto':
					$tit = 'Contacte - Satan Arise';
					$texte = 'Satan Arise';
				break;				

				}
			print '<a class="linkblanc" href="index.php?ln='.$page->leng.'&sec='.$cad_menu[$cont].'" title="'.$tit.'">';
			if ($page->section == $cad_menu[$cont]) print '<span class="on">';
			print $texte;
			if ($page->section == $cad_menu[$cont]) print '</span>';
			print '</a>'."\n";
			$cont=$cont+1;
		}
	}	

?>
        
        <br />
        <a rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/"><img alt="Licencia Creative Commons" style="border-width:0" src="http://i.creativecommons.org/l/by-nc-nd/3.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" href="http://purl.org/dc/dcmitype/Text" property="dct:title" rel="dct:type">Satan Arise</span> por <a class="linkblanc" xmlns:cc="http://creativecommons.org/ns#" href="www.satanarise.com" property="cc:attributionName" rel="cc:attributionURL">www.satanarise.com</a> se encuentra bajo una Licencia <a class="linkblanc" rel="license" href="http://creativecommons.org/licenses/by-nc-nd/3.0/">Creative Commons Reconocimiento-NoComercial-SinObraDerivada 3.0 Unported</a>.
    </div>
</div>



</body>
</html>