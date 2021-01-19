<?php

	class ob_reviews_web
	{

		public $id;
		public $resultat_consulta;
		public $resultat_consulta2;
		public $numero_resultats;
		public $noticia_individual;
		public $concert_data;
		public $dades;
		public function __construct()
		{
			$this->id='';
			$this->numero_resultats=0;
			$this->punter=1;
			$this->quantitat=10;
			$this->noticia_individual=FALSE;
		}
		public  function __get($nom) /* crea parametres */
		{
			return $this->$nom;
		}
	
		public function __set($nom,$valor) /* asigna valors al parametre */
		{
			return $this->$nom = $valor;
		}		
		
		
		public function extreure_reviews_per_data_entrada($bd,$punter,$quantitat) 
		/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$punter-1;
			
			$query= "select reviews.link, reviews.banda, reviews.disc, reviews.any, reviews.portada, estil.estil, reviews.tipus, reviews.nota, colaboradors.nom, banderes.pais, banderes.ruta from reviews left join colaboradors on reviews.idcolaboradors=colaboradors.idcolaboradors left join  banderes on reviews.idpais=banderes.idpais left join estil on reviews.idestil=estil.idestil order by reviews.data desc limit ".$inici.", ".$quantitat;
            $this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
			}
			
		}
		
		public function mostrar_reviews_per_data_entrada($bd,$leng)
		{
			$review  = new ob_reviews;
			for ($i=0;$i<$this->numero_resultats;$i++)
			{
				$review->reset_reviews();
				$resultat=$this->resultat_consulta->fetch_assoc();
				$review->banda=$resultat['banda'];
				$review->disc=$resultat['disc'];
				$review->portada=$resultat['portada'];
				$review->estil=$resultat['estil'];
				$review->tipus=$resultat['tipus'];
				$review->colaborador=$resultat['nom'];
				$review->any=$resultat['any'];
                $review->pais=$resultat['pais'];
                $review->bandera=$resultat['ruta'];
                $review->nota=$resultat['nota'];
                $review->link=$resultat['link'];
                switch ($leng)
                {
                    case 'ES':
                        $link='ln=ES&sec=criticas&'; /* per canviar */
                    break;
                    case 'CAT':
                        $link='ln=CAT&sec=critiques&'; /* per canviar */
                    break;                 
                    
                }
				/* mostrar dades */
    			print '<a class="linkk" href="index.php?'.$link.$review->link.'" title="'.$review->banda.' - '.$review->disc.' crítica"><div class="novedad">';
                print '<img class="covermini" src="pics/covers/'.$review->portada.'" width="80" height="80" alt="'.$review->banda.' - '.$review->disc.'"/>';
                print '<div class="dades"><h1>'.$review->banda.'</h1>';
                print '<h2>'.$review->disc.' ('.$review->any.')</h2>';
                print '<h3>'.$review->estil.'<br />(';
                switch ($leng)
                {
                    case 'ES':
                        print 'por ';
                    break;
                    case 'CAT':
                        print 'per ';
                    break;
                }
                print $review->colaborador.')</h3>';
                print '</div><div class="icos"><p>Puntuación<img src="pics/punt'.$review->nota.'.jpg" width="38" height="25" /><img src="pics/banderas/'.$review->bandera.'.png" height="25" alt = "'.$review->pais.'"/></p></div></div></a>';
			}
		}
		
		public function extreure_review_unica($bd,$id,$idioma) 
		/* consultar review a la bbdd a partir d'una id */
		{
			$ok=TRUE;
            switch ($idioma)
            {
                case 'ES':
                    $query= "select reviews.idreviews, reviews.link, reviews.banda, reviews.disc, reviews.logo, reviews.data, reviews.any, reviews.portada, reviews.video, reviews.media, reviews.texte_es, reviews.formacio_es, reviews.tracklist, reviews.idestil, reviews.idpais, estil.estil, estil.estil_global, reviews.tipus, reviews.nota, colaboradors.nom, banderes.pais, banderes.ruta, label.labelnom, label.labellink from reviews left join colaboradors on reviews.idcolaboradors=colaboradors.idcolaboradors left join label on reviews.idlabel=label.idlabel left join banderes on reviews.idpais=banderes.idpais left join estil on reviews.idestil=estil.idestil where reviews.idreviews=".$id;
                break;
                case 'CAT':
                    $query= "select reviews.idreviews, reviews.link, reviews.banda, reviews.disc, reviews.logo, reviews.data, reviews.any, reviews.portada, reviews.video, reviews.media, reviews.texte_cat, reviews.formacio_cat, reviews.tracklist, reviews.idestil, estil.estil, estil.estil_global, reviews.tipus, reviews.nota, colaboradors.nom, reviews.idpais, banderes.pais, banderes.ruta, label.labelnom, label.labellink from reviews left join colaboradors on reviews.idcolaboradors=colaboradors.idcolaboradors left join label on reviews.idlabel=label.idlabel left join banderes on reviews.idpais=banderes.idpais left join estil on reviews.idestil=estil.idestil where reviews.idreviews=".$id;
                break;
            }
            
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta==FALSE) 
			{
			     $ok=FALSE;
			}
			return $ok;
			
			
			
		}
		
		public function mostrar_review_unica ($idioma,$bd)
		{
            $review  = new ob_reviews;
            require('sources/basic_functions.php');
            $review->reset_reviews();            
            $resultat=$this->resultat_consulta->fetch_assoc();
			$review->id=$resultat['idreviews'];
			$review->banda=$resultat['banda'];
			$review->disc=$resultat['disc'];
			$review->portada=$resultat['portada'];
            $review->logo=$resultat['logo'];
            $review->video=$resultat['video'];
            $review->media=$resultat['media'];
			$review->estil=$resultat['estil'];
			$review->estil_global=$resultat['estil_global'];
			$review->tipus=$resultat['tipus'];
			$review->colaborador=$resultat['nom'];
			$review->any=$resultat['any'];
            $review->pais=$resultat['pais'];
            $review->bandera=$resultat['ruta'];            
            $review->label=$resultat['labelnom'];
            $review->link_label=$resultat['labellink'];
            $review->nota=$resultat['nota'];
            $review->link=$resultat['link'];
            $review->tracklist=$resultat['tracklist'];
            $review->timestamp=$resultat['data'];
			$review->idestil=$resultat['idestil'];
			$review->idpais=$resultat['idpais'];
            
            
            $tags='sddsdsds';
            switch ($idioma)
            {
                case 'ES':
                    $formacio=$resultat['formacio_es'];
                    $texte=$this->preparar_texte($resultat['texte_es'],$tags);
                    $temas='Temas';
                    $formacio_tit='Formación';
                    $link_idioma='ln=ES&sec=contacto';
                break;
                case 'CAT':
                    $formacio=$resultat['formacio_cat'];
                    $texte=$this->preparar_texte($resultat['texte_cat'],$tags);
                    $temas='Temes';
                    $formacio_tit='Formació';
                    $link_idioma='ln=CAT&sec=contacte';
                break;
            }
            
            /* impresió dades */
            print '<div class="titdiscos"><p>'.$review->banda.' - '.$review->disc.' ('.$review->any.')</p></div>';
            /* portada 325 x 325 */
            print '<div id="cover"><img src="pics/covers/'.$review->portada.'" width="325" height="325" alt="'.$review->banda.' - '.$review->disc.'" /></div>';
            
            switch ($review->video)
            {
                case '1':
                /* hi ha video */
                    print '<div id="video"><iframe width="425" height="350" src="http://www.youtube.com/embed/'.$review->media.'?rel=0" frameborder="0" allowfullscreen></iframe></div>';
                break;
                case '2':
                    $tamany=array();
						$tamany=getimagesize('pics/band/'.$review->media);
						if ($tamany[0]>=$tamany[1])
						{
							/* mes ample me alt */
							$width=425;
							$height=round((425*$tamany[1])/$tamany[0],0);
						} else {
							/* mes alt que llarg */
							$width=round((350*$tamany[0])/$tamany[1],0);
							$height=350;
						}
                        if ($height>250) {
                            $width=round((250*$tamany[0])/$tamany[1],0);
			             	$height=250;                
                        }

                    print '<div id="video"><img src="pics/band/'.$review->media.'" width="'.$width.'" height="'.$height.'" alt="'.$review->banda.'" /></div>';
                break;
            }
            print '<div id="logoband"><table><tr><td>';
            /* 370 * 250 */ 
            $tamany=array();
			$tamany=getimagesize('pics/logos/'.$review->logo);
			if ($tamany[0]>=$tamany[1])
			{
				/* mes ample me alt */
				$width=370;
				$height=round((370*$tamany[1])/$tamany[0],0);
			} else {
				/* mes alt que llarg */
				$width=round((250*$tamany[0])/$tamany[1],0);
				$height=250;
			}
            if ($height>250) {
                $width=round((250*$tamany[0])/$tamany[1],0);
				$height=250;                
            }
            print '<img src="pics/logos/'.$review->logo.'" width="'.$width.'" height="'.$height.'" alt="'.$review->banda.' logo" /></td></tr></table></div>';
            print '<div id="icosdisc"><img src="pics/puntuacio'.$review->nota.'.jpg" width="60" /><img src="pics/banderas/'.$review->bandera.'.png" height="40" alt="'.$review->pais.'" /></div>';
            print '<div id="dadesdisc">';
            print '<h1>'.$review->disc;
            switch ($review->tipus)
            {
                case 2:
                    print ' (EP) ';
                break;
                case 3:
                    print ' (Demo) ';
                break;
                case 4:
                    print '(Single)';
                break;
                case 5:
                    print '(DVD)';
                break;
            }
            print '</h1><p>'.$review->estil.'<br />';
            if ($review->link_label!='')
            {
                print '<a class="linkdisc" target="_blank" href="http://'.$review->link_label.'">'.$review->label.'</a>';
            } else {
                print $review->label;
            }
            print '<br />'.$review->any.'<br /><br /><br />';
            print '<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
<span style="margin-left:5px;"><g:plusone size="small"></g:plusone></span>

</div>


<!-- AddThis Button END -->
            	
            </p></div>';
            print '<div id="tit"><p>'.$temas.'</p></div><div id="tracklist"><p>'.nl2br(htmlspecialchars($review->tracklist)).'</p></div>';
            print '<div id="tit"><p>'.$formacio_tit.'</p></div><div id="lineup"><p>'.nl2br($formacio).'</p></div>';
            print '<div class="titdiscos"><p>Crítica</p></div><div id="critica"><p>'.$texte.'</p><h1><a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($review->colaborador).'" target="_blank">'.$review->colaborador.'</a><br />'.$this->timestamp_a_data($review->timestamp).'</h1></div>';
            $this->inserir_sugerencies($bd,$review,$idioma);
		}
		
		public function inserir_sugerencies($bd,$review,$idioma) 
		/* mostra les sugerencies de reviews que surten al final d'una review, per estil, per país i per mes visitades */
		{
			/* per mes vistes */
			
			/* extreure metak i / de l'estil */ 
			
			$query="select reviews.link, reviews.banda, reviews.disc, reviews.portada, estil.estil from reviews left join estil on reviews.idestil=estil.idestil where reviews.idreviews <> ".$review->id." and estil.estil_global = ".$review->estil_global." order by reviews.data desc limit 0, 10";
			
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta!=FALSE) 
			{
				/* mostrar resultats mes visitats */
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats>0) 
				{
					print '<div class="recomended">';
					switch ($idioma)
					{
						case 'ES':
							print '<p>'.'Últimas críticas de estilos similares:'.'</p>';
						break;
						case 'CAT':
							print '<p>'.'Darreres crítiques d\'estil similars:'.'</p>';
						break;
					}
					
				}
				for ($x=0;$x<$this->numero_resultats;$x++)
            	{
                	$resultat=$this->resultat_consulta->fetch_assoc();
					$portada=$resultat['portada'];
					$banda=$resultat['banda'];
					$disc=$resultat['disc'];
					$estil=$resultat['estil'];
					$link=$resultat['link'];
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=criticas&'.$link.'"><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=critiques&'.$link.'"><div class="recomend_item">';
						break;
					}
					print '<img src="pics/covers/'.$portada.'" width="100" height="100" alt="'.$banda.$disc.'" />';
					print '<h1>'.$banda.'</h1>';
					print '<h2>'.$disc.'</h2>';
					print '<h3>'.$estil.'</h3>';
					
					print '</div></a>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}


			/* per mes vistes */
			
			$query="select reviews.link, reviews.banda, reviews.disc, reviews.portada, estil.estil from reviews left join estil on reviews.idestil=estil.idestil where reviews.idreviews <> ".$review->id." order by reviews.vistes desc limit 0, 10";
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta!=FALSE) 
			{
				/* mostrar resultats mes visitats */
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats>0) 
				{
					print '<div class="recomended">';
					switch ($idioma)
					{
						case 'ES':
							print '<p>'.'Las más leídas:'.'</p>';
						break;
						case 'CAT':
							print '<p>'.'Les més llegides:'.'</p>';
						break;
					}
					
				}
				for ($x=0;$x<$this->numero_resultats;$x++)
            	{
                	$resultat=$this->resultat_consulta->fetch_assoc();
					$portada=$resultat['portada'];
					$banda=$resultat['banda'];
					$disc=$resultat['disc'];
					$estil=$resultat['estil'];
					$link=$resultat['link'];
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=criticas&'.$link.'"><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=critiques&'.$link.'"><div class="recomend_item">';
						break;
					}
					print '<img src="pics/covers/'.$portada.'" width="100" height="100" alt="'.$banda.$disc.'" />';
					print '<h1>'.$banda.'</h1>';
					print '<h2>'.$disc.'</h2>';
					print '<h3>'.$estil.'</h3>';
					print '</div></a>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}


            /* per mes vistes aquest any' */
			$any=date ("Y");
			$query="select reviews.link, reviews.banda, reviews.disc, reviews.portada, estil.estil from reviews left join estil on reviews.idestil=estil.idestil where reviews.idreviews <> ".$review->id." and reviews.any='".$any."' order by reviews.vistes desc limit 0, 10";
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta!=FALSE) 
			{
				/* mostrar resultats mes visitats */
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats>0) 
				{
					print '<div class="recomended">';
					switch ($idioma)
					{
						case 'ES':
							print '<p>'.'Las más leídas de '.$any.'.</p>';
						break;
						case 'CAT':
							print '<p>'.'Les més llegides de '.$any.'.</p>';
						break;
					}
					
				}
				for ($x=0;$x<$this->numero_resultats;$x++)
            	{
                	$resultat=$this->resultat_consulta->fetch_assoc();
					$portada=$resultat['portada'];
					$banda=$resultat['banda'];
					$disc=$resultat['disc'];
					$estil=$resultat['estil'];
					$link=$resultat['link'];
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=criticas&'.$link.'"><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=critiques&'.$link.'"><div class="recomend_item">';
						break;
					}
					print '<img src="pics/covers/'.$portada.'" width="100" height="100" alt="'.$banda.$disc.'" />';
					print '<h1>'.$banda.'</h1>';
					print '<h2>'.$disc.'</h2>';
					print '<h3>'.$estil.'</h3>';
					print '</div></a>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}
			/* per mes vistes aquest any' */
			$any=2021;
			$any2=2020;
			$query="select reviews.link, reviews.banda, reviews.disc, reviews.portada, estil.estil from reviews left join estil on reviews.idestil=estil.idestil where reviews.idreviews <> ".$review->id." and (reviews.any='".$any."' or reviews.any='".$any2."') order by reviews.vistes desc limit 0, 10";
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta!=FALSE) 
			{
				/* mostrar resultats mes visitats */
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats>0) 
				{
					print '<div class="recomended">';
					switch ($idioma)
					{
						case 'ES':
							print '<p>'.'Las más leídas de '.$any.'/'.$any2.'.</p>';
						break;
						case 'CAT':
							print '<p>'.'Les més llegides de '.$any.'/'.$any2.'.</p>';
						break;
					}
					
				}
				for ($x=0;$x<$this->numero_resultats;$x++)
            	{
                	$resultat=$this->resultat_consulta->fetch_assoc();
					$portada=$resultat['portada'];
					$banda=$resultat['banda'];
					$disc=$resultat['disc'];
					$estil=$resultat['estil'];
					$link=$resultat['link'];
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=criticas&'.$link.'"><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=critiques&'.$link.'"><div class="recomend_item">';
						break;
					}
					print '<img src="pics/covers/'.$portada.'" width="100" height="100" alt="'.$banda.$disc.'" />';
					print '<h1>'.$banda.'</h1>';
					print '<h2>'.$disc.'</h2>';
					print '<h3>'.$estil.'</h3>';
					print '</div></a>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}
			
			/* per origen */
			
			$query="select reviews.link, reviews.banda, reviews.disc, reviews.portada, estil.estil from reviews left join estil on reviews.idestil=estil.idestil where reviews.idpais=".$review->idpais." and reviews.idreviews <> ".$review->id." order by reviews.data desc limit 0, 10";
			
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta!=FALSE) 
			{
				/* mostrar resultats mes visitats */
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats>0) 
				{
					print '<div class="recomended">';
					switch ($idioma)
					{
						case 'ES':
							print '<p>'.'Las últimas del mismo país:'.'</p>';
						break;
						case 'CAT':
							print '<p>'.'Les darreres del mateix país:'.'</p>';
						break;
					}
				}
				for ($x=0;$x<$this->numero_resultats;$x++)
            	{
                	$resultat=$this->resultat_consulta->fetch_assoc();
					$portada=$resultat['portada'];
					$banda=$resultat['banda'];
					$disc=$resultat['disc'];
					$estil=$resultat['estil'];
					$link=$resultat['link'];
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=criticas&'.$link.'"><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=critiques&'.$link.'"><div class="recomend_item">';
						break;
					}
					
					print '<img src="pics/covers/'.$portada.'" width="100" height="100" alt="'.$banda.$disc.'" />';
					print '<h1>'.$banda.'</h1>';
					print '<h2>'.$disc.'</h2>';
					print '<h3>'.$estil.'</h3>';
					print '</div></a>';
				}
			}
			if ($this->numero_resultats>0) print '</div>';
		}

   		public function afegir_visita ($bd,$id)
		{
			$query= "select vistes, banda, disc from reviews where idreviews = $id";	
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta!=FALSE) 
			{
				$resultat=$this->resultat_consulta->fetch_assoc();
                $vistes=$resultat['vistes']+1;
                $banda=$resultat['banda'];
                $disc=$resultat['disc'];
                if (fmod($vistes, 250) == 0)        
                {
                    $tit="Nova a fita a la review : ".$banda." - ".$disc;
                    $mensaje="La review del disc $banda - $disc ha arribat a $vistes vistes!\n\n Una birra pel redactor!";
                    $cab = 'From: info@satanarise.com';
                    mail('info@satanarise.com', $tit, $mensaje, $cab);
                } 
                $query="update reviews set vistes=$vistes where idreviews=$id";
                $this->resultat_consulta=$bd->query($query);
                if ($this->resultat_consulta!=FALSE) 
			    {}
                
				
			}
		}

		public function extreure_historic($bd) 
		/* consultar review a la bbdd a partir d'una id */
		{
			$ok=TRUE;            
            $query= "select reviews.link, reviews.banda, reviews.disc, reviews.data, reviews.any, estil.estil, reviews.tipus from reviews left join estil on reviews.idestil=estil.idestil order by reviews.banda, reviews.any"; 
            $this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta==FALSE) 
			{
			     $ok=FALSE;
			} else {
                $this->numero_resultats=$this->resultat_consulta->num_rows;
            }
			return $ok;
			
			
			
		}
        public function mostrar_historic($idioma) 
		/* consultar review a la bbdd a partir d'una id */
		{
            print '<div class="titdiscos">'; /*-- Titol de discos --*/
            switch ($idioma) {
                case 'ES':
                    print '<p>Archivo de críticas</p>';
                break;
                case 'CAT':
                    print '<p>Archivo de crítiques</p>';
                break;
        	}
            print '</div>';
		    print '<div id="links">                                          
                <ul class="lista_links">
                    <li class="letra"><a class="list" href="#num">#</a></li>
                    <li class="letra"><a class="list" href="#a">A</a></li>
                    <li class="letra"><a class="list" href="#b">B</a></li>
                    <li class="letra"><a class="list" href="#c">C</a></li>
                    <li class="letra"><a class="list" href="#d">D</a></li>
                    <li class="letra"><a class="list" href="#e">E</a></li>
                    <li class="letra"><a class="list" href="#f">F</a></li>
                    <li class="letra"><a class="list" href="#g">G</a></li>
                    <li class="letra"><a class="list" href="#h">H</a></li>
                    <li class="letra"><a class="list" href="#i">I</a></li>
                    <li class="letra"><a class="list" href="#j">J</a></li>
                    <li class="letra"><a class="list" href="#k">K</a></li>
                    <li class="letra"><a class="list" href="#l">L</a></li>
                    <li class="letra"><a class="list" href="#m">M</a></li>
                    <li class="letra"><a class="list" href="#n">N</a></li>
                    <li class="letra"><a class="list" href="#o">O</a></li>
                    <li class="letra"><a class="list" href="#p">P</a></li>
                    <li class="letra"><a class="list" href="#q">Q</a></li>
                    <li class="letra"><a class="list" href="#r">R</a></li>
                    <li class="letra"><a class="list" href="#s">S</a></li>
                    <li class="letra"><a class="list" href="#t">T</a></li>
                    <li class="letra"><a class="list" href="#u">U</a></li>
                    <li class="letra"><a class="list" href="#v">V</a></li>
                    <li class="letra"><a class="list" href="#w">W</a></li>
                    <li class="letra"><a class="list" href="#x">X</a></li>
                    <li class="letra"><a class="list" href="#y">Y</a></li>
                    <li class="letra"><a class="list" href="#z">Z</a></li>                       
                </ul>
            </div><div id="enlaces">';
            
            /* iteracio per entrades */
            $banda_antiga=''; 
            $lletra_actual='';
            for ($x=0;$x<$this->numero_resultats;$x++)
            {
                $resultat=$this->resultat_consulta->fetch_assoc();
                $banda=$resultat['banda'];
                $disc=$resultat['disc'];
                $any=$resultat['any'];
                $link=$resultat['link'];
                $estil=$resultat['estil'];
                $tipus=$resultat['tipus'];
                $y=0;
                $lletra_banda=substr($banda,$y,$y+1);                           
                while (($lletra_banda=='¡') || ($lletra_banda=='¿') || ($lletra_banda==',') || ($lletra_banda=='.'))                
                {   
                    $y++;
                    $lletra_banda=substr($banda,$y,$y+1);    
                }
                
                if ($lletra_actual=='')
                {
                    print '<div class="letras"><p class="gran">';
                    //if (is_int($lletra_banda))
                    if (is_numeric($lletra_banda))
                    {
                        
                        $lletra_actual='#'; 
                        print '<a id="num">#</a></p>';                                     
                    } else {
                        $lletra_actual=$lletra_banda;
                        print '<a id="'.strtolower($lletra_actual).'">'.$lletra_actual.'</a></p>';   
                    }
                        print '<p class="banda_hist">'.$banda.'</p>';
                        print '<p class="disc_hist"><a class="list" href="';
                        switch ($idioma)
                        {
                            case 'ES':
                                print 'index.php?ln=ES&sec=criticas&';
                            break;
                            case 'CAT':
                                print 'index.php?ln=CAT&sec=critiques&';
                            break;
                        }    
                        print $link.'" title="'.$banda.' - '.$disc.'">'.$disc.' ('.$any.' - '.$estil;
                        switch ($tipus)
                        {
                            case 2:
                                print ' EP';
                            break;
                            case 3:
                                print 'Demo';
                            break;
                            case 4:
                                print 'Sinle';
                            break;
                            case 3:
                                print 'DVD';
                            break;
                            
                        }
                        print ' )</a></p>';
                    
                } else {
                    
                    /* controlar link lletra */
                    if (($lletra_actual=='#'))
                    {
                        if (!is_numeric($lletra_banda))
                        {
                            print '</div>';
                            $lletra_actual=$lletra_banda;
                            print '<div class="letras"><p class="gran">';
                            print '<a id="'.strtolower($lletra_actual).'">'.$lletra_actual.'</a></p>';
                        }
                        
                        
                    } else {
                        if ($lletra_banda!=$lletra_actual)
                        {
                            print '</div>';
                            $lletra_actual=$lletra_banda;
                            print '<div class="letras"><p class="gran">';
                            print '<a id="'.strtolower($lletra_actual).'">'.$lletra_actual.'</a></p>';
                            
                        }
                    }
                    
                    /* controlar impresio de banda */
                    
                    if ($banda_antiga!=$banda)
                    {
                        print '<p class="banda_hist">'.$banda.'</p>';
                    }
                    
                    print '<p class="disc_hist"><a class="list" href="';
                        switch ($idioma)
                        {
                            case 'ES':
                                print 'index.php?ln=ES&sec=criticas&';
                            break;
                            case 'CAT':
                                print 'index.php?ln=CAT&sec=critiques&';
                            break;
                        }    
                        print $link.'" title="'.$banda.' - '.$disc.'">'.$disc.' ('.$any.' - '.$estil;
                        switch ($tipus)
                        {
                            case 2:
                                print ' EP';
                            break;
                            case 3:
                                print 'Demo';
                            break;
                            case 3:
                                print 'Single';
                            break;
                            case 5:
                                print 'DVD';
                            break;
                            
                        }
                        print ' )</a></p>';
                        $banda_antiga=$banda;
                }
                
                
            }
            if ($lletra_actual!='') print '</div>';
            
            print '</div>';
		}

		public function preparar_texte($texte,$tags)
		{
			/* Prepara per ser posat a la web */
			$texte=$this->tractar_tag_link(2,$texte,$tags);
			return $texte;
		}

		public function tractar_tag_link($opcio,$texte,$tags)
		/* Als textes busca el tag [link] www.xemple.es [link] on www.exemple.es es una adreça url completa sense els http i si opcio es 1 el converteix en un link class linkk i la resta del texte el tracta per caracterls especials html i si es 2 ignira els tags i els treu del texte i el filtra per caracters html */ 
		{
			$array_texte=explode('[link]',$texte);
			$texte='';
			switch ($opcio)
			{
				case '1': /* [link]www.exemple.es[link] -> <a class="linkk" href="http://www.exemple.es">www.exemple.es</a> */
					for ($i=0;$i<count($array_texte);$i++)
					{
						if (substr($texte,0,6)=='[link]')
						{
							if ($i%2==0) 
							{
								$array_texte[$i]=str_replace('http://','',$array_texte[$i]);
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} else {
								$texte=$texte.$this->posar_negretes(nl2br(htmlspecialchars($array_texte[$i])),$tags);
							}
							
						} else {
							if ($i%2!=0) 
							{	
								$array_texte[$i]=str_replace('http://','',$array_texte[$i]);
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} else {
								$texte=$texte.$this->posar_negretes(nl2br(htmlspecialchars($array_texte[$i])),$tags);
							}
						}
					}
				break;
				
				case '2': /* Anula le tag [link]www.exemple.s[link] -> www.exemple.es i el filtra per caracters html */
					for ($i=0;$i<count($array_texte);$i++)
					{
						$texte=$texte.$array_texte[$i];
					}
					$texte=nl2br($texte);
				break;
			}
			return $texte;
		}
		
		public function posar_negretes($text,$tags)
		{
			if ($tags!='')
			{		
				$paraules=explode(',',$tags);
				for ($i=0;$i<count($paraules);$i++)
				{
					$paraules[$i]=htmlspecialchars(trim($paraules[$i]));
					$text=str_replace($paraules[$i],'<span class="cursiva">'.$paraules[$i].'</span>',$text);

				}
			}
			return $text;
		}

		public function taula_a_timestamp($taula) 
		{
			$data=$taula['any'].$taula['mes'].$taula['dia'].$taula['hora'].$taula['min'].'00';

			return $data;
		}
		
		public function timestamp_a_taula($data)
		{
			$taula['any']=substr($data,0,4);
			$taula['mes']=substr($data,5,2);
			$taula['dia']=substr($data,8,2);
			$taula['hora']=substr($data,11,2);
			$taula['min']=substr($data,14,2);
			return $taula;
		}
		public function timestamp_a_datahora($data)
		{
			$taula['any']=substr($data,0,4);
			$taula['mes']=substr($data,5,2);
			$taula['dia']=substr($data,8,2);
			$taula['hora']=substr($data,11,2);
			$taula['min']=substr($data,14,2);
			return $taula['dia'].'/'.$taula['mes'].'/'.$taula['any'].' '.$taula['hora'].':'.$taula['min'];
		}
		public function timestamp_a_data($data)
		{
			$taula['any']=substr($data,0,4);
			$taula['mes']=substr($data,5,2);
			$taula['dia']=substr($data,8,2);
			$taula['hora']=substr($data,11,2);
			$taula['min']=substr($data,14,2);
			return $taula['dia'].'/'.$taula['mes'].'/'.$taula['any'];
		}
		public function timestamp_a_hora($data)
		{
			$taula['any']=substr($data,0,4);
			$taula['mes']=substr($data,5,2);
			$taula['dia']=substr($data,8,2);
			$taula['hora']=substr($data,11,2);
			$taula['min']=substr($data,14,2);
			return $taula['hora'].':'.$taula['min'];
		}
	}
?>