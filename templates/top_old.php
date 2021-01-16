<?php
 /* segons seccio afegim css de seccio, keywords i descripcio. */
	switch ($page->section)
	{
		case ('inici'):
			$page->description = 'Satan Arise - Heavy Metal, crítiques, entrevistes i informació de tots els estils de metal.';
			$page->title = 'Satan Arise - Novetats, discografies, entrevistes i molt més, heavy, folk, power, gothic, death, trash, black... metal!';
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/conciertos.css" />');					
		break;
		case ('inicio'):
			$page->description = 'Satan Arise - Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->title = 'Satan Arise - Novedades, discografias, entrevistas y mas, heavy, folk, power, gothic, death, trash... metal!';
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/conciertos.css" />');			
		break;
		case ('critiques'):
			$page->description = $page->review_descripcio.'... - Satan Arise - Heavy Metal, crítiques, entrevistes i informació de tots els estils de metal.';
			$page->words = 'crítica, review, '.$page->words;
			$page->title = $page->review_titol.' - Satan Arise';
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/discog.css" />');                
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/disc.css" />');
      $page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
		break;
		case ('criticas'):
			$page->description = $page->review_descripcio.'... - Satan Arise - Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->words = 'crítica, review, '.$page->words;
			$page->title = $page->review_titol.' - Satan Arise';
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/discog.css" />');                
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/disc.css" />');
      $page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
		break;
		case ('concerts'):	
			$page->words = 'conciertos, '.$page->words;
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/conciertos.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="js/prototype.js"></script>','<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>','<script type="text/javascript" src="js/lightbox.js"></script>');			
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');
			if ($page->concerts_titol=='')
			{
				$page->description = 'Informació sobre el propers concerts de metal.';
				$page->title = 'Propers concerts - Satan Arise - Novetats, entrevistes i més, heavy, folk, power, gothic, death, trash... metal! ';
			}
			else
			{
				$page->description = 'Informació sobre el proper concert: '.$page->concerts_titol;
				$page->title = 'Concert: '.$page->concerts_titol.' - Satan Arise - Novetats, entrevistes i més, heavy, folk, power, gothic, death, trash... metal! ';
			}
		break;
		case ('conciertos'):
			$page->words = 'concerts, gigs, '.$page->words;
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/conciertos.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="js/prototype.js"></script>','<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>','<script type="text/javascript" src="js/lightbox.js"></script>');			
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');
			if ($page->concerts_titol=='')
			{
				$page->description = 'Satan Arise - Información de los próximos concierto de Metal.';
				$page->title = 'Próximos conciertos - Satan Arise - Novedades, discografias, entrevistas y más, heavy, folk, power, gothic, death, trash... metal!';
			}
			else 
			{
				$page->description = 'Satan Arise - Información sobre el próximo concierto: '.$page->concerts_titol;
				$page->title = 'Concierto: '.$page->concerts_titol.' - Satan Arise - Novedades, discografias, entrevistas y más, heavy, folk, power, gothic, death, trash... metal! ';
			}
		break;
    case ('croniques'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/disc.css" />');
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/imgs.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
      $page->description = $page->cronica_descripcio.'... - Satan Arise - Heavy Metal, crítiques, entrevistes i informació de tots els estils de metal.';
			$page->words = 'crítica, review, '.$page->words;
			$page->title = $page->cronica_titol.' - Satan Arise';
		break;
		case ('cronicas'):
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/disc.css" />');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/imgs.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
			$page->description = $page->cronica_descripcio.'... - Satan Arise - Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->words = 'crítica, review, '.$page->words;
			$page->title = $page->cronica_titol.' - Satan Arise';
		break;
		case ('entrevistes'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/imgs.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
      $page->description = $page->entrevista_descripcio.'... - Satan Arise - Heavy Metal, crítiques, entrevistes i informació de tots els estils de metal.';
			$page->words = 'entrevista, '.$page->words;
			$page->title = $page->entrevista_titol.' - Satan Arise';
		break;
		case ('entrevistas'):
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/imgs.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
			$page->description = $page->entrevista_descripcio.'... - Satan Arise - Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->words = 'entresita, '.$page->words;
			$page->title = $page->entrevista_titol.' - Satan Arise';
		break;
    case ('opinion'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/imgs.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
      $page->description = $page->opinio_descripcio.'... - Satan Arise - Heavy Metal, crítiques, entrevistes i informació de tots els estils de metal.';
			$page->words = $page->words;
			$page->title = $page->opinio_titol.' - Satan Arise';
		break;
		case ('opinio'):
      $page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/imgs.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
      $page->add_scripts('<script type="text/javascript" src="http://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4da62dec5b48fd17"></script>');
      $page->add_scripts("<script type=\"text/javascript\" src=\"https://apis.google.com/js/plusone.js\">{lang: 'es'}</script>");
			$page->description = $page->opinio_descripcio.'... - Satan Arise - Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->words =$page->words;
			$page->title = $page->opinio_titol.' - Satan Arise';
		break;
		case ('contacte'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->description = "Contacte Satan Arise - El nostre Staff, redactors i col·laboradors i la forma de contactar amb l'equip de  Satan Arise.";
			$page->words = 'contacto, '.$page->words;
			$page->title = 'Contacte Satan Arise';
		break;
		case ('contacto'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->description = 'Contacto Satan Arise - Nuestro Staff, redactores y colaboradores y la forma de contactar con el equipo de Satan Arise.';
			$page->words = 'contact, '.$page->words;
			$page->title = 'Contacto Satan Arise';
		break;
		case ('noticies'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/noticias.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');		
			$page->words = 'noticies, videoclips '.$page->words;
			if ($page->noticia!='') 
			{
				$page->title = $page->noticia_titol.' - Noticies Satan Arise - Noticies del metal';
				$page->description = $page->noticia_descripcio.' - Noticies de metal de Satan Arise';
			}
			else
			{
				$page->title = 'Noticies Satan Arise - Noticies del metal';
				$page->description = 'Noticies de metal de Satan Arise';
			}
		break;
		case ('noticias'):
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/noticias.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');
			$page->words = 'noticias, videoclips, '.$page->words;
			if ($page->noticia!='') 
			{
				$page->title = $page->noticia_titol.' - Noticias Satan Arise - Noticias del metal';
				$page->description = $page->noticia_descripcio.' - Noticias de metal de Satan Arise';
			}
			else
			{
				$page->title = 'Noticias Satan Arise - Noticias del metal';
				$page->description = 'Noticias de metal de Satan Arise';
			}
		break;
		case ('concurso'):
			$page->description = 'Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->title = 'Sorteos - Satan Arise - Novedades, discografias, entrevistas y mas, heavy, folk, power, gothic, death, trash... metal!';
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');
			$page->add_scripts('<script type="text/javascript" src="css/control_form.js"></script>');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/concurs.css" />');
		break;
		case ('concurs'):
			$page->description = 'Heavy Metal, crítiques, entrevistes i informació de tots els estils de metal.';
			$page->title = 'Sortejos  - Satan Arise - Novetats, discografies, entrevistes i molt més, heavy, folk, power, gothic, death, trash, black... metal!';
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/control_form.js"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/concurs.css" />');
		break;
    case ('pagina'):
			$page->description = 'Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->title = 'Satan Arise - Novedades, discografias, entrevistas y mas, heavy, folk, power, gothic, death, trash... metal!';
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->add_scripts('<script type="text/javascript" src="css/lightbox.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="css/jquery-1.7.2.min.js"></script>');
			$page->add_scripts('<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4eb01bb17187f779"></script>');
			$page->add_scripts('<script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>');
			$page->add_scripts('<script type="text/javascript" src="css/control_form.js"></script>');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/ent.css" />');
			$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/concurs.css" />');
		break;
	}
	/* Impresió de capçalera */
	$page->print_heads();
	
?>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-22367410-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<!-- Carrega d'imatges -->
<div id="off">
<?php
	if ($page->leng == 'CAT')
	{
?>
		<img src="pics/containers/logo.gif" />
<?php
	}
	else
	{
?>
		<img src="pics/containers/logo.gif" />

<?php

	}
?>
</div> 

<div id="contenedor"> <!-- Contenidor principal -->
	<div id="top_left"> <!-- Cantonada equerra superior -->
		<?php

			if ($page->leng == 'ES')
			{
				require('templates/banners/top_left_es.php');
			}
			else
			{
				require('templates/banners/top_left_cat.php');				
			}
		?>    
    </div>
    <div id="logo">
    	<?php
		if ($page->leng == 'CAT')
		{
				$alt='Satan Arise, Novetats, entrevistes i discografies de Heavy Metal!';
				$sec='inici';
		}
		else
		{
				$alt='Satan Arise, Lanzamientos, entrevistas y discografias de Heavy Metal!';
				$sec='inicio';
		}
		
    		print '<a href="index.php?ln='.$page->leng.'&sec='.$sec.'" title="Satan Arise"><img class="logosatan" src="pics/containers/logo.gif" width="600" height="100" alt="'.$alt.'" /></a>';
		?>
    </div>
    <div id="top_right"> <!-- Cantonada equerra superior -->
		<?php

			if ($page->leng == 'ES')
			{
				require('templates/banners/top_right_es.php');
			}
			else
			{
				require('templates/banners/top_right_cat.php');				
			}
		?>    
    </div>
    
    <div id="barramanu">	 <!-- -------------------------------------------------- M E N U --------------------------------------------------- -->    
    	<div id="menu">
<?php
			
	if ($page->leng == 'ES')
	{
		$cad_menu = array ('inicio','noticias','conciertos','criticas','cronicas','entrevistas','opinion','contacto'); /* afegir concerts!!! */
	}
	else
	{
		$cad_menu = array ('inici','noticies','concerts','critiques','croniques','entrevistes','opinio','contacte');
	}
	$contmax = count($cad_menu); 
	$cont=0;
	if ($page->leng == 'ES')
	{
		while ($cont<=($contmax-1)) 
		{
			switch ($cad_menu[$cont]) 
			{
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
        case 'opinion':
					$tit = 'Opinión - Satan Arise';
					$texte = 'Opinión';
				break;
				case 'contacto':
					$tit = 'Contacto - Satan Arise';
					$texte = 'Satan Arise';
				break;				
				}
			
			print '<p class="linkmenu"><a class="men" href="index.php?ln='.$page->leng.'&sec='.$cad_menu[$cont].'" title="'.$tit.'">';
			if ($page->section == $cad_menu[$cont]) print '<span class="on">';
			print $texte;
			if ($page->section == $cad_menu[$cont]) print '</span>';
			print '</a></p>'."\n";
			$cont=$cont+1;
		}
	}
	else 
	{
		while ($cont<=($contmax-1))
		{
			switch ($cad_menu[$cont])
			{
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
				case 'opinio':
					$tit = 'Opinió - Satan Arise';
					$texte = 'Opinió';
				break;
                case 'contacte':
					$tit = 'Contacte - Satan Arise';
					$texte = 'Satan Arise';
				break;				

			}
			print '<p class="linkmenu"><a class="men" href="index.php?ln='.$page->leng.'&sec='.$cad_menu[$cont].'" title="'.$tit.'">';
			if ($page->section == $cad_menu[$cont]) print '<span class="on">';
			print $texte;
			if ($page->section == $cad_menu[$cont]) print '</span>';
			print '</a></p>'."\n";
			$cont=$cont+1;
		}
	}	

?>
    </div>
		<div id="ilike">
		<script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script>

        	<fb:like href="http://www.facebook.com/Satanarisemetal" layout="button_count" show_faces="true" width="100" font="arial"></fb:like>
    </div>
    <div id="banderes">
<?php
		if ($page->traduccio) 
		{
			$newurl = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
			$newurl=$page->translate_url($newurl);
			switch ($page->section)
			{
				case 'inici':
					$tit = 'Metal, críticas, conciertos, crónicas y entrevistas - Satan Arise';
				break;
				case 'noticies':
					$tit = 'Noticias del metal - Satan Arise';
				break;
				case 'critiques':
					$tit = 'Críticas, reviews, novedades metal, discos, critica y tracklist - Satan Arise';
				break;					
				case 'concerts':
					$tit = 'Conciertos, fechas, salas, bandas y carteles - Satan Arise';
				break;
				case 'croniques':
					$tit = 'Crónicas de conciertos - Satan Arise';
				break;
				case 'entrevistes':
					$tit = 'Entrevistas - Satan Arise';
				break;
				case 'contacte':
					$tit = 'Contacto - Satan Arise';
				break;
        case 'opinio':
					$tit = 'Opinion - Satan Arise';
				break;
				case 'inicio':
					$tit = 'Metal, crítiques, concerts, cròniques i entrevistes - Satan Arise';
				break;
				case 'noticias':
					$tit = 'Noticies del metal';
				break;
				case 'criticas':
					$tit = 'Crítiques, reviews, novetats de metal, discos, crítica i tracklist - Satan Arise';
				break;					
				case 'conciertos':
					$tit = 'Concerts, datas, sales, bandes i cartells - Satan Arise';
				break;
				case 'cronicas':
					$tit = 'Cròniques de concerts - Satan Arise';
				break;
				case 'entrevistas':
					$tit = 'Entrevistes - Satan Arise';
				break;
				case 'contacto':
					$tit = 'Contacte - Satan Arise';
				break;
        case 'opinion':
					$tit = 'Opinio - Satan Arise';
				break;
			}
			if ($page->leng == 'ES')
			{
				$bandera='cat';
			}
			else
			{
				$bandera='es';
			}
			print '<a href="'.$newurl.'" title="'.$tit.'"><img class="uk" src="pics/containers/'.$bandera.'.jpg"  height="21"  width="30 "alt="'.$tit.'" /></a>';
		}
?>        
        	
    	</div>
    </div>
	<div id="col_left">			<!-- Columan de discografies -->
<?php
		require('templates/banners/col_left.php');

?>    	
    </div>
    <div id="col_center">    
             <!-- FI TOP --------------------------------------------------------------------------------------------------------------- -->