<?php

	class ob_entrevistes_web
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
		
		
		public function extreure_entrevistes_per_data_entrada($bd,$punter,$quantitat,$leng) 
		/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$punter-1;
			
			$query= "select identrevistes, banda, link, titol_es, titol_cat, data from entrevistes where idioma = '".$leng."' or idioma = 'BOTH' order by data desc limit ".$inici.", ".$quantitat;
            //$query= "select reviews.link, reviews.banda, reviews.disc, reviews.any, reviews.portada, estil.estil, reviews.tipus, reviews.nota, colaboradors.nom, banderes.pais, banderes.ruta from reviews left join colaboradors on reviews.idcolaboradors=colaboradors.idcolaboradors left join  banderes on reviews.idpais=banderes.idpais left join estil on reviews.idestil=estil.idestil order by reviews.data desc";
            		
            $this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
			}
		}
		
		public function mostrar_entrevistes_per_data_entrada($bd,$leng)
		{
			$entrevista  = new ob_entrevistes;
			for ($i=0;$i<$this->numero_resultats;$i++)
			{
				$entrevista->reset_entrevistes();
				$resultat=$this->resultat_consulta->fetch_assoc();
				$entrevista->banda=$resultat['banda'];
				$entrevista->titol_es=$resultat['titol_es'];
				$entrevista->titol_cat=$resultat['titol_cat'];
				$entrevista->link=$resultat['link'];
        $entrevista->timestamp=$resultat['data'];
				$entrevista->id=$resultat['identrevistes'];
				$query="select ruta from entrevistesdata where identrevistes=".$entrevista->id." and tipus=1 and ordre=1";
        $this->resultat_consulta2=$bd->query($query);
        if ($this->resultat_consulta2!=FALSE) 
			  {
             $row=$this->resultat_consulta2->fetch_assoc();
             $entrevista->logo=$row['ruta'];                    
			  }
        print '<div class="entrevista">';
        switch ($leng)
        {
        	case 'ES':
            $link='ln=ES&sec=entrevistas&'; /* per canviar */
          break;
          case 'CAT':
          	$link='ln=CAT&sec=entrevistes&'; /* per canviar */
          break;                         
        }
        print '<div class="data">';
        print ($this->timestamp_a_data($entrevista->timestamp));
        print '</div>';
        print '<a class="linkk" href="index.php?'.$link.$entrevista->link.'" title="Entrevista con '.$entrevista->banda.'"><img class="coverent" src="pics/entrevistes_pics/'.$entrevista->logo.'" width="100" alt="'.$entrevista->banda.'"/>';
        switch ($leng)
        {
            case 'ES':
                $texte=$entrevista->titol_es;
            break;
            case 'CAT':
                $texte=$entrevista->titol_cat;
            break;
        }
        print '<p>'.$texte.'</p></a></div>';
			}
		}
		
		public function extreure_entrevista_unica($bd,$id,$idioma) 
		/* consultar review a la bbdd a partir d'una id */
		{
			$ok=TRUE;
      switch ($idioma)
      {
          case 'ES':
              $query= "select entrevistes.identrevistes, entrevistes.banda, entrevistes.link, entrevistes.titol_es, entrevistes.tipus, entrevistes.texte_es, entrevistes.idcolaboradors, entrevistes.idcolaboradors2, entrevistes.idtraductor, entrevistes.data from entrevistes where identrevistes=".$id;
          break;
          case 'CAT':
              $query= "select entrevistes.identrevistes, entrevistes.banda, entrevistes.link, entrevistes.titol_cat, entrevistes.tipus, entrevistes.texte_cat, entrevistes.idcolaboradors, entrevistes.idcolaboradors2, entrevistes.idtraductor, entrevistes.data from entrevistes where identrevistes=".$id;
          break;
      }
            
			$this->resultat_consulta=$bd->query($query);
            
      if ($this->resultat_consulta==FALSE) 
			{
			     $ok=FALSE;
			}
            /* extraccio imatges */
      $query= "select * from entrevistesdata where identrevistes=".$id." order by ordre";            
			$this->resultat_consulta2=$bd->query($query);
            
      if ($this->resultat_consulta2==FALSE) 
			{
			     $ok=FALSE;
			}
      return $ok;
		}
		
		public function mostrar_entrevista_unica ($idioma,$bd)
		{
		  
      $entrevista  = new ob_entrevistes;
      require('sources/basic_functions.php');
      $entrevista->reset_entrevistes();            
      $resultat=$this->resultat_consulta->fetch_assoc();
			$entrevista->id=$resultat['identrevistes'];
			$entrevista->banda=$resultat['banda'];
			$entrevista->link=$resultat['link'];
			$entrevista->timestamp=$resultat['data'];
            
      switch ($idioma)
      {
          case 'ES':
              $entrevista->titol=$resultat['titol_es'];
              $entrevista->texte=$resultat['texte_es'];        
          break;
          case 'CAT':
              $entrevista->titol=$resultat['titol_cat'];
              $entrevista->texte=$resultat['texte_cat'];        
          break;
      }
      $entrevista->idcolaboradors=$resultat['idcolaboradors'];
      $entrevista->idcolaboradors2=$resultat['idcolaboradors2'];
      $entrevista->idtraductor=$resultat['idtraductor'];
      
      $query= "select nom from colaboradors where idcolaboradors=".$entrevista->idcolaboradors;
                      
			$this->resultat_consulta=$bd->query($query);
            
      if ($this->resultat_consulta!=FALSE) 
			{
      	$resultat=$this->resultat_consulta->fetch_assoc();
        $entrevista->colaborador=$resultat['nom'];         
			}
      if ($entrevista->idcolaboradors2!=0) 
      {
          $query= "select nom from colaboradors where idcolaboradors=".$entrevista->idcolaboradors2;            
          $this->resultat_consulta=$bd->query($query);
      
          if ($this->resultat_consulta!=FALSE) 
          {
              $resultat=$this->resultat_consulta->fetch_assoc();
              $entrevista->colaborador2=$resultat['nom']; 
          }
      }
      if ($entrevista->idtraductor!=0) 
      {
          $query= "select nom from colaboradors where idcolaboradors=".$entrevista->idtraductor;            
          $this->resultat_consulta=$bd->query($query);
      
          if ($this->resultat_consulta!=FALSE) 
          {
              $resultat=$this->resultat_consulta->fetch_assoc();
              $entrevista->traductor=$resultat['nom']; 
          }
      }

      $this->numero_resultats=$this->resultat_consulta2->num_rows;
      for ($i=0;$i<$this->numero_resultats;$i++)
      {
          $row=$this->resultat_consulta2->fetch_assoc();
          if ($row['tipus']==1)
          {
              if ($row['ordre']==1) 
              {
              	$entrevista->logo=$row['ruta'];
              } else
              {
              	$entrevista->imgs[($i-1)]=$row['ruta'];                        
              }
          } 
          else 
          {
          	$entrevista->ruta_audio=$row['ruta'];
          }
      }           
      
      $tags='sddsdsds';

      switch ($idioma)
      {
          case 'ES':
              print '<div class="titdiscos"> <!-- Titol de discos --><p>Entrevista con ';
          break;
          case 'CAT':
              print '<div class="titdiscos"> <!-- Titol de discos --><p>Entrevista amb ';
          break;
      }
      print  $entrevista->banda.'</p></div>';
      
      print '<div id="entrevista"><div id="logoent">';
      print '<img src="pics/entrevistes_pics/'.$entrevista->logo.'" width="300" alt="'.$entrevista->banda.'" /></div>';
      print '<h1 class="ent">'.$entrevista->titol.'</h1>';
      /* preparar texte */
      
      /* tags 
      
          [p] ------------> <h2 class="preg">
          [/p] -----------> </h2>
          [r] ------------> <h2 class="resp">
          [/r] -----------> </h2>
          [audio] --------> <object type="application/x-shockwave-flash" data="css/dewplayer-bubble.swf" width="250" height="65" id="dewplayer" name="dewplayer"> <param name="wmode" value="transparent" /><param name="movie" value="css/dewplayer-bubble.swf" /> <param name="flashvars" value="mp3=audio/xxxxxx.mp3" /> </object>
          [img#] ---------> <a href="pics/entrevistes_pics/ruta" rel="lightbox[lr]" title="Banda"><img class="esq" src = "pics/entrevistes_pics/ruta" width="400" alt="Banda" /></a>
          [imgcentrada#] ->
      */
      
      $entrevista->texte=str_replace('[p]','<h2 class="preg">',$entrevista->texte);
      $entrevista->texte=str_replace('[/p]','</h2>',$entrevista->texte);
      $entrevista->texte=str_replace('[r]','<h2 class="resp">',$entrevista->texte);
      $entrevista->texte=str_replace('[/r]','</h2>',$entrevista->texte);
      /* generar link audio */            
      $link_audio='';
      if ($entrevista->ruta_audio!='')
      {
          /*$link_audio='<div class="centrar"><object type="application/x-shockwave-flash" data="css/dewplayer-bubble.swf" width="250" height="65" id="dewplayer" name="dewplayer"> <param name="wmode" value="transparent" /><param name="movie" value="css/dewplayer-bubble.swf" /> <param name="flashvars" value="mp3=audio/'.$entrevista->ruta_audio.'" /> </object></div><br />'; */
          $link_audio='<div class="centrar"><audio src="audio/'.$entrevista->ruta_audio.'" preload="auto" controls></audio></div><br />';
      }
      $entrevista->texte=str_replace('[audio]',$link_audio,$entrevista->texte);
      /* generar links_imgs */
      for ($y=0;$y<3;$y++)
      {
          $link_img[$y]='';
          if ($entrevista->imgs[$y]!='')
          {
              if (($y==0) || ($y==2))
              {
                  $link_img[$y]='<a href="pics/entrevistes_pics/'.$entrevista->imgs[$y].'" rel="lightbox[.$entrevista->banda.]" title="'.$entrevista->banda.'"><img class="esq" src = "pics/entrevistes_pics/'.$entrevista->imgs[$y].'" width="400" alt="'.$entrevista->banda.'" /></a>';
              } else {
                  $link_img[$y]='<a href="pics/entrevistes_pics/'.$entrevista->imgs[$y].'" rel="lightbox[.$entrevista->banda.]" title="'.$entrevista->banda.'"><img class="dret" src = "pics/entrevistes_pics/'.$entrevista->imgs[$y].'" width="400" alt="'.$entrevista->banda.'" /></a>';
              }
          }
      }
      $entrevista->texte=str_replace('[img1]',$link_img[0],$entrevista->texte);
      $entrevista->texte=str_replace('[img2]',$link_img[1],$entrevista->texte);
      $entrevista->texte=str_replace('[img3]',$link_img[2],$entrevista->texte);
      
      /* img centrades */
      
      for ($y=0;$y<3;$y++)
      {
          $link_img[$y]='';
          if ($entrevista->imgs[$y]!='')
          {
              $link_img[$y]='<div class="centrar"><a href="pics/entrevistes_pics/'.$entrevista->imgs[$y].'" rel="lightbox[.$entrevista->banda.]" title=".$entrevista->banda."><img src="pics/entrevistes_pics/'.$entrevista->imgs[$y].'" width="400" alt="'.$entrevista->banda.'" /></a></div><br />';
          }
      }
      $entrevista->texte=str_replace('[imgcentrada1]',$link_img[0],$entrevista->texte);
      $entrevista->texte=str_replace('[imgcentrada2]',$link_img[1],$entrevista->texte);
      $entrevista->texte=str_replace('[imgcentrada3]',$link_img[2],$entrevista->texte);
      
      print $this->preparar_texte($entrevista->texte,$tags);

      print '
            <!-- ShareThis BEGIN -->
            <div class="sharethis-inline-reaction-buttons"></div>
            <!-- ShareThis END -->
            ';
      print '<!-- ShareThis BEGIN -->
      <div class="sharethis-inline-share-buttons"></div>
      <!-- ShareThis END -->';
      
      
      switch ($idioma)
      {
          case 'ES':
              print '<p class="firma">Entrevista realizada por ';
              $link_idioma='ln=ES&sec=contacto';
          break;
          
          case 'CAT';
              print '<p class="firma">Entrevista realitzada per ';
              $link_idioma='ln=CAT&sec=contacte';
          break;
      }
      
      print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($entrevista->colaborador).'" target="_blank">'.$entrevista->colaborador.'</a>';
      if ($entrevista->colaborador2!='')
      {
          switch ($idioma)
          {
              case 'ES':
                  print ' y ';
                  $link_idioma='ln=ES&sec=contacto';
              break;
              
              case 'CAT';
                  print ' i ';
                  $link_idioma='ln=CAT&sec=contacte';
              break;
          }
          print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($entrevista->colaborador2).'" target="_blank">'.$entrevista->colaborador2.'</a>';
      }
      
      if ($entrevista->traductor!='')
      {
          switch ($idioma)            
          {
              case 'ES':
                  print '<br />Traducción por ';
                  $link_idioma='ln=ES&sec=contacto';
              break;
              
              case 'CAT';
                  print '<br />Traducció per ';
                  $link_idioma='ln=CAT&sec=contacte';
              break;
          }
          print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($entrevista->traductor).'" target="_blank">'.$entrevista->traductor.'</a><br />';
      }
      print '<br />'.$this->timestamp_a_data($entrevista->timestamp).'</p></div>';
      $this->inserir_sugerencies($bd,$entrevista,$idioma);
		}
		
		public function inserir_sugerencies($bd,$entrevista,$idioma) 
		/* mostra les sugerencies de reviews que surten al final d'una review, per estil, per país i per mes visitades */
		{
			/* per mes vistes */
			switch ($idioma)
      {
          case 'ES':
              $query="select banda, identrevistes, link, titol_es, data from entrevistes where (idioma = 'ES' OR idioma = 'BOTH') AND (identrevistes <> ".$entrevista->id.") order by visites desc limit 0, 5";
          break;
          case 'CAT':
              $query="select banda, identrevistes, link, titol_cat, data from entrevistes where (idioma = 'CAT' OR idioma = 'BOTH') AND (identrevistes <> ".$entrevista->id.") order by visites desc limit 0, 5";
          break;
      }

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
					$banda=$resultat['banda'];
					$link=$resultat['link'];
					$identrevistes=$resultat['identrevistes'];
					switch ($idioma) 
          {
              case 'ES':
                  $titol=$resultat['titol_es'];
              break;
              case 'CAT':
                  $titol=$resultat['titol_cat'];
              break;
          }
          $query="select ruta from entrevistesdata where identrevistes=".$identrevistes." and tipus=1 and ordre=1";
          $this->resultat_consulta2=$bd->query($query);
          if ($this->resultat_consulta2!=FALSE) 
          { 
            $row=$this->resultat_consulta2->fetch_assoc();
            $logo=$row['ruta'];
          }
					print '<div class="entrevista_rec"><div class="data">';
          print $this->timestamp_a_data($entrevista->timestamp);
          print '</div>';
            
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=entrevistas&'.$link.'" title="Entrevista con '.$banda.' ><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=entrevistes&'.$link.'" title="Entrevista con '.$banda.' ><div class="recomend_item">';
						break;
					}
					print '<img class="coverent" src="pics/entrevistes_pics/'.$logo.'" width="100" alt="'.$banda.'" />';
					print '<p>'.$titol.'</p>';
					print '</div></a>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}
		}
   	
   	public function afegir_visita ($bd,$id)
		{
			$query= "select visites, banda from entrevistes where identrevistes = $id";	
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta!=FALSE) 
			{
			$resultat=$this->resultat_consulta->fetch_assoc();
            $vistes=$resultat['visites']+1;
            $banda=$resultat['banda'];
                if (fmod($vistes, 250) == 0)        
                {
                    $tit="Nova fita a l'entrevista de ".$banda;
                    $mensaje="L'entrevista a la banda $banda ha arribat a $vistes vistes!\n\n Una birra pel redactor!";
                    $cab = 'From: info@satanarise.com';
                    mail('info@satanarise.com', $tit, $mensaje, $cab);
                }
            $query="update entrevistes set visites=$vistes where identrevistes=$id";
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
			}
			else 
			{
      	$this->numero_resultats=$this->resultat_consulta->num_rows;
      }
			return $ok;
		}
        
		public function preparar_texte($texte,$tags)
		{
			/* Prepara per ser posat a la web */
			$texte=$this->tractar_tag_link(1,$texte,$tags);
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
							} 
							else 
							{
                $texte=$texte.$this->posar_negretes($array_texte[$i],$tags);
							}
							
						} 
						else 
						{
							if ($i%2!=0) 
							{	
								$array_texte[$i]=str_replace('http://','',$array_texte[$i]);
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} 
							else 
							{
               	$texte=$texte.$this->posar_negretes($array_texte[$i],$tags);
							}
						}
					}
				break;
				case '2': /* Anula le tag [link]www.exemple.s[link] -> www.exemple.es i el filtra per caracters html */
					for ($i=0;$i<count($array_texte);$i++)
					{
						$texte=$texte.$array_texte[$i];
					}
					//$texte=nl2br(htmlspecialchars($texte));
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
         	$paraules[$i]=trim($paraules[$i]);
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
