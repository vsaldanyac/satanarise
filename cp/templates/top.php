<?php
 /* segons seccio afegim css de seccio, keywords i descripcio. */
	switch ($page->section) {		
		case ('inicio'):
			$page->description = 'Heavy Metal, críticas, entrevistas e información de todos los estilos de metal.';
			$page->title = 'Noticias - Panel de Control de Satan Arise';
			/*$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/index.css" />');
			$page->add_css('<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />');
			$page->scripts = array('<script type="text/javascript" src="js/prototype.js"></script>','<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>','<script type="text/javascript" src="js/lightbox.js"></script>');*/
		break;
		case ('criticas'):
			$page->description = '';
			// $page->words = $page->words;
			$page->title = 'Reviews - Panel de Control de Satan Arise';
			
		break;

		case ('conciertos'):
			$page->description = '';
			$page->words = 'concerts, gigs, '.$page->words;
			$page->title = 'Conciertos / Giras / Festivales - Panel de Control de Satan Arise';

		break;

		case ('cronicas'):
			$page->description = '--';
			$page->words = 'review, live, report, interview, press, '.$page->words;
			$page->title = 'Crónicas - Panel de Control de Satan Arise';
		break;

		case ('entrevistas'):
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Entrevistas - Panel de Control de Satan Arise';
			
		break;
        case ('entrevistasn'):
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Entrevistas nuevas - Panel de Control de Satan Arise';
			
		break;

		case ('noticias'):
			//$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Noticias - Panel de Control de Satan Arise';
		break;
  		case ('opinion'):
			//$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Opinion - Panel de Control de Satan Arise';
		break;
        case ('carta'):
			//$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Cartas Del Lector - Panel de Control de Satan Arise';
		break;
        case ('colaboradores'):
			//$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Colaboradores - Panel de Control de Satan Arise';
		break;        
        case ('usuarios'):
			//$page->add_css('<link type="text/css" rel="stylesheet" media="all" href="css/contact.css" />');
			$page->description = '';
			$page->words = ''.$page->words;
			$page->title = 'Usuarios - Panel de Control de Satan Arise';
		break;
	}
	/* Impresió de capçalera */
	$page->print_heads();
	
?>
</head>
<body>
<!-- Carrega d'imatges -->
<div id="off">
		<img src="../pics/containers/logo_cp.jpg" />
	}

</div> 

<div id="contenidor"> <!-- Contenidor principal -->
    <div id="logo">
    	<?php
			$alt='Satan Arise, Lanzamientos, entrevistas y discografias de Heavy Metal!';
			$sec='inicio';
		
    		print '<a href="home_cp.php?ln=&sec='.$sec.'" title="Satan Arise"><img class="logosatan" src="../pics/containers/logo_cp.jpg" width="1000" height="100" alt="'.$alt.'" /></a>';
		?>
        <h1 id="logout"><a class="linkk" href="home_cp.php?sec=logout" title="Cerrar Sesión">Cerrar sesión</a></h1>
    </div>
    
	<div id="contenidor_columnes">
	    <div id="columna_menu">	 <!-- -------------------------------------------------- M E N U --------------------------------------------------- -->    

<?php
			
	$cad_menu = array ('inicio','noticias','criticas','conciertos','cronicas','entrevistas','entrevistasn','opinion','carta','colaboradores','usuarios');
	$contmax = count($cad_menu); 
	$cont=0;
	
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
				case 'opinion':
					$tit = 'Opinion - Satan Arise';
					$texte = 'Opinion';
				break;
                case 'carta':
					$tit = 'Cartas Del Lector - Satan Arise';
					$texte = 'Cartas Del Lector';
				break;
                case 'entrevistas':
					$tit = 'Entrevistas - Satan Arise';
					$texte = 'Entrevistas';
				break;
                case 'entrevistasn':
					$tit = 'Entrevistas nuevas - Satan Arise';
					$texte = 'Entrevistas nuevas';
				break;
                case ('colaboradores'):			        
					$tit = 'Colaboradores - Satan Arise';
					$texte = 'Colaboradores';
					$page->title = 'Colaboradores - Panel de Control de Satan Arise';
                break;                case ('usuarios'):			        
					$tit = 'Usuarios - Satan Arise';
					$texte = 'Usuarios';
					$page->title = 'Usuarios - Panel de Control de Satan Arise';
                break;
				}
			
			print '<p class="linkmenu"><a class="men" href="home_cp.php?&sec='.$cad_menu[$cont].'&action=main" title="'.$tit.'">';
			if ($page->section == $cad_menu[$cont]) print '<span class="on">';
			print $texte;
			if ($page->section == $cad_menu[$cont]) print '</span>';
			print '</a></p>'."\n";
			if ($cad_menu[$cont] !='inicio') {
				print '<p class="submenu"><a class="men" href="home_cp.php?sec='.$cad_menu[$cont].'&action=add" title="'.$tit.'">Añadir</a></p>'."\n";
				print '<p class="submenu"><a class="men" href="home_cp.php?sec='.$cad_menu[$cont].'&action=edit" title="'.$tit.'">Editar</a></p>'."\n";
				print '<p class="submenu"><a class="men" href="home_cp.php?sec='.$cad_menu[$cont].'&action=del" title="'.$tit.'">Eliminar</a></p>'."\n";									
			}
			if ($cad_menu[$cont] == 'conciertos') print '<p class="submenu"><a class="men" href="home_cp.php?&sec='.$cad_menu[$cont].'&action=borrar_fora_de_data" title="'.$tit.'">Eliminar antiguos</a></p>'."\n";								
			$cont=$cont+1;
		}
	
?>
        </div>
		    
             <!-- FI TOP --------------------------------------------------------------------------------------------------------------- -->
    
    
