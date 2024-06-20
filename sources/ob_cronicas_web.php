<?php

	class ob_cronicas_web
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
		
		
		public function extreure_cronicas_per_data_entrada($bd,$punter,$quantitat,$leng) 
		/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$punter-1;
			
			switch ($leng)
            {
                case 'ES':
                    $query= "select titol, cartell, link, intro_es, data from cronicas where idioma = 'ES' or idioma = 'BOTH' order by data desc limit ".$inici.", ".$quantitat;
                break;
                case 'CAT':
                    $query= "select titol, cartell, link, intro_cat, data from cronicas where idioma = 'CAT' or idioma = 'BOTH' order by data desc limit ".$inici.", ".$quantitat;
                break;
            }            
            $this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
			}
			
		}
		
		public function mostrar_cronicas_per_data_entrada($bd,$leng)
		{
			$cronica  = new ob_cronicas;
			for ($i=0;$i<$this->numero_resultats;$i++)
			{
				$cronica->reset_cronicas();
				$resultat=$this->resultat_consulta->fetch_assoc();
				$cronica->titol=$resultat['titol'];
                $cronica->cartell=$resultat['cartell'];                
                $cronica->link=$resultat['link'];
                $cronica->timestamp=$resultat['data'];
                
                
			    switch ($leng)
                {
                    case 'ES':
                        $cronica->intro=$resultat['intro_es'];
                        $link='ln=ES&sec=cronicas&'; /* per canviar */
                    break;
                    case 'CAT':
                        $cronica->intro=$resultat['intro_cat'];
                        $link='ln=CAT&sec=croniques&'; /* per canviar */
                    break;                 
                    
                }
				/* mostrar dades */
                $cadena=explode('<br />',nl2br($cronica->intro));
                print '<div class="cronica">';
                print '<p><a class="linkk" href="index.php?'.$link.$cronica->link.'" title="'.$cronica->titol.'"><img class="cartell_cronica" src="pics/cronicas_pics/'.$cronica->cartell.'" width="80" align="middle" alt = "'.$cronica->titol.'"/>
                        <span>'.$cronica->titol.'</span><br /><br />'.$cadena[0].'</a></p></div>';
			}
		}
		
		public function extreure_cronica_unica($bd,$id,$idioma) 
		/* consultar cronica a la bbdd a partir d'una id */
		{
		  
			$ok=TRUE;
            switch ($idioma)
            {
                case 'ES':
                    $query= "select cronicas.titol, cronicas.idcronicas, cronicas.link, cronicas.cartell, cronicas.intro_es, cronicas.num_div, cronicas.outro_es, cronicas.setlist, cronicas.data, cronicas.idcolaborador1, cronicas.idcolaborador2, cronicas.idfoto1, cronicas.idfoto2 from cronicas where cronicas.idcronicas=".$id;
                break;
                case 'CAT':
                    $query= "select cronicas.titol, cronicas.idcronicas, cronicas.link, cronicas.cartell, cronicas.intro_cat, cronicas.num_div, cronicas.outro_cat, cronicas.setlist, cronicas.data, cronicas.idcolaborador1, cronicas.idcolaborador2, cronicas.idfoto1, cronicas.idfoto2 from cronicas where cronicas.idcronicas=".$id;
                break;
            }
            
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta==FALSE) 
			{
			     $ok=FALSE;
			}
			return $ok;
			
			
			
		}
		
		public function mostrar_cronica_unica ($idioma,$bd)
		{
		  
            $tags='sddsdsds';
            $cronica  = new ob_cronicas;
            require('sources/basic_functions.php');
            $cronica->reset_cronicas();            
            $resultat=$this->resultat_consulta->fetch_assoc();
			$cronica->id=$resultat['idcronicas'];
			$cronica->titol=$resultat['titol'];
			$cronica->cartell=$resultat['cartell'];
			$cronica->num_div=$resultat['num_div'];
            $cronica->timestamp=$resultat['data'];
            $cronica->setlist=$resultat['setlist'];
            $cronica->link=$resultat['link'];
            $cronica->idcolaborador1=$resultat['idcolaborador1'];
            $cronica->idcolaborador2=$resultat['idcolaborador2'];
            $cronica->idfoto1=$resultat['idfoto1'];
            $cronica->idfoto2=$resultat['idfoto2'];
            /* cercar noms colaboradors */
            $query= "select nom from colaboradors where idcolaboradors=".$cronica->idcolaborador1;
                      
			$this->resultat_consulta2=$bd->query($query);
            
            if ($this->resultat_consulta2!=FALSE) 
			{
                $resultat2=$this->resultat_consulta2->fetch_assoc();
                $cronica->colaborador1=$resultat2['nom']; 
                
			}
            if ($cronica->idcolaborador2!=0) 
            {
                $query= "select nom from colaboradors where idcolaboradors=".$cronica->idcolaborador2;            
                $this->resultat_consulta2=$bd->query($query);
            
                if ($this->resultat_consulta2!=FALSE) 
                {
                    $resultat2=$this->resultat_consulta2->fetch_assoc();
                    $cronica->colaborador2=$resultat2['nom']; 
                }
            }
            if ($cronica->idfoto1!=0) 
            {
                $query= "select nom from colaboradors where idcolaboradors=".$cronica->idfoto1;            
                $this->resultat_consulta2=$bd->query($query);
            
                if ($this->resultat_consulta2!=FALSE) 
                {
                    $resultat2=$this->resultat_consulta2->fetch_assoc();
                    $cronica->foto1=$resultat2['nom']; 
                }
            }
            if ($cronica->idfoto2!=0) 
            {
                $query= "select nom from colaboradors where idcolaboradors=".$cronica->idfoto2;            
                $this->resultat_consulta2=$bd->query($query);
            
                if ($this->resultat_consulta2!=FALSE) 
                {
                    $resultat2=$this->resultat_consulta2->fetch_assoc();
                    $cronica->foto2=$resultat2['nom']; 
                }
            }
            switch ($idioma)
            {
                case 'ES':
                    $cronica->intro=$resultat['intro_es'];
                    $cronica->outro=$resultat['outro_es'];
                    $link_idioma='ln=ES&sec=contacto';
                break;
                case 'CAT':
                    $cronica->intro=$resultat['intro_cat'];
                    $cronica->outro=$resultat['outro_cat'];
                    $link_idioma='ln=CAT&sec=contacte';
                break;
            }          
            $texte='<p class="texte">'.$cronica->intro.'</p>';
            $cronica->crear_divisions();
            $query= "select * from cronicasdata where idcronicas = ".$cronica->id." order by idcronicasdata";
            $this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta) 
            { 
                for ($i=1;$i<=$cronica->num_div;$i++)
                {
                    $nom='div'.$i;
                    $resultat=$this->resultat_consulta->fetch_assoc();
                    $cronica->$nom->id=$resultat['idcronicasdata'];
                    $cronica->$nom->id_cronica=$resultat['idcronicas'];
                    $cronica->$nom->texte_es=$resultat['texte_es'];                   
                    $cronica->$nom->texte_cat=$resultat['texte_cat'];
                    switch ($idioma)
                    {
                        case 'ES':
                            $cronica->$nom->texte_es=$resultat['texte_es'];
                        break;
                        case 'CAT':
                            $cronica->$nom->texte_es=$resultat['texte_cat'];
                        break;
                    }                    
                    $query= "select * from cronicasimgs where idcronicasdata = ".$cronica->$nom->id." order by ordre";                    
                    $this->resultat_consulta2=$bd->query($query);
                    if ($this->resultat_consulta2) 
                    { 
                        $this->numero_resultats=$this->resultat_consulta2->num_rows;
                        for ($x=1;$x<=$this->numero_resultats;$x++)
                        {
                            $resultat2=$this->resultat_consulta2->fetch_assoc();
                            $cronica->$nom->imgs[$x]=$resultat2['ruta'];
                        }
                    }
                    $control_fi_div=FALSE;
                    for ($x=1;$x<=5;$x++)
                    {
                        if ($x==1)
                        {
                            if ($cronica->$nom->imgs[$x]!='')
                            {
                                $tamany=array();
        						$tamany=getimagesize('pics/cronicas_pics/'.$cronica->$nom->imgs[$x]);
        						if ($tamany[0]>=$tamany[1])
        						{
        							/* mes ample me alt */
        							$h=200;
        						} else {
        							/* mes alt que llarg */
        							$h=250;
        						}
                                $resto = $i%2; 
                                if (($resto==0) && ($i!=0)) { 
                                    // Parell
                                    $texte=$texte.'<p class="texte"><a href="pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" rel="lightbox[.$cronica->titol.]" title="'.$cronica->titol.'"><img class="esq" src = "pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" alt="'.$cronica->titol.'" height="'.$h.'" /></a>'; 
                                } else { 
                                    // senar
                                    $texte=$texte.'<p class="texte"><a href="pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" rel="lightbox[.$cronica->titol.]" title="'.$cronica->titol.'"><img class="dret" src = "pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" alt="'.$cronica->titol.'" height="'.$h.'" /></a>';
                                }
                                $texte=$texte.$cronica->$nom->texte_es.'</p>';        
                            } else {
                                $x=6;
                                $texte=$texte.'<p class="texte">'.$cronica->$nom->texte_es.'</p>';   
                            }                                                                                             
                        } else {                                
                            if (($x==2) && ($cronica->$nom->imgs[$x]!=''))
                            {
                                $texte=$texte.'<div class="centrar">';
                                $texte=$texte.'<a href="pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" rel="lightbox[.$cronica->titol.]" title="'.$cronica->titol.'"><img style="margin:2px" src = "pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" height="180" alt="'.$cronica->titol.'" /></a>';
                                $control_fi_div=TRUE;
                            
                            } else {
                                if ($cronica->$nom->imgs[$x]!='')
                                {
                                    $texte=$texte.'<a href="pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" rel="lightbox[.$cronica->titol.]" title="'.$cronica->titol.'"><img style="margin:2px" src = "pics/cronicas_pics/'.$cronica->$nom->imgs[$x].'" height="180" alt="'.$cronica->titol.'" /></a>';
                                
                                }    
                            }
                        }
                    }
                    if ($control_fi_div)
                    {
                        $texte=$texte.'</div>';
                    }
                    
                }
                $texte=$texte.'<p class="texte">'.$cronica->outro.'</p>'.$cronica->setlist;
            }
            
              
            /* impresió dades */
            
            
            print '<div class="titdiscos"> <!-- Titol de discos --><p>'.$cronica->titol.'</p></div>';
            print '<div id="critica">';
            
        	print '<div class="centrar"><img src="pics/cronicas_pics/'.$cronica->cartell.'" width="250" align="middle" alt = "'.$cronica->titol.'"/></div>';
            print $this->preparar_texte($texte,$tags);
            
            /* firmas */
            
            switch ($idioma)
            {
                case 'ES':
                    print '<h1>Crónica realizada por ';
                    $link_idioma='ln=ES&sec=contacto';
                break;
                
                case 'CAT';
                    print '<h1>Crónica realitzada per ';
                    $link_idioma='ln=CAT&sec=contacte';
                break;
            }
            
            print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($cronica->colaborador1).'" target="_blank">'.$cronica->colaborador1.'</a>';
            if ($cronica->colaborador2!='') {
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
                print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($cronica->colaborador2).'" target="_blank">'.$cronica->colaborador2.'</a>';
            }
            
            if ($cronica->foto1!='') {
                switch ($idioma)            
                {
                    case 'ES':
                        print '<br />Fotos por ';
                        $link_idioma='ln=ES&sec=contacto';
                    break;
                    
                    case 'CAT';
                        print '<br />Fotos per ';
                        $link_idioma='ln=CAT&sec=contacte';
                    break;
                }
                print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($cronica->foto1).'" target="_blank">'.$cronica->foto1.'</a>';
            }
            if ($cronica->foto2!='') {
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
                print '<a class="linkk" href="index.php?'.$link_idioma.'#'.convertir_cadena_arxiu($cronica->foto2).'" target="_blank">'.$cronica->foto2.'</a>';
            }

            print '<br />'.$this->timestamp_a_data($cronica->timestamp).'</h1>';
            print '
            <!-- ShareThis BEGIN -->
            <div class="sharethis-inline-reaction-buttons"></div>
            <!-- ShareThis END -->
            ';
            print '<!-- ShareThis BEGIN -->
            <div class="sharethis-inline-share-buttons"></div>
            <!-- ShareThis END -->';
            print '</div>';
            $this->inserir_sugerencies($bd,$cronica,$idioma);
        } 
        public function inserir_sugerencies($bd,$cronica,$idioma) 
		/* mostra les sugerencies de reviews que surten al final d'una review, per estil, per país i per mes visitades */
		{
			
			/* per mes vistes */
			switch ($idioma)
            {
                case 'ES':
                    $query="select titol, idcronicas, link, intro_es, cartell, data from cronicas where (idioma = 'ES' OR idioma = 'BOTH') AND (idcronicas <> ".$cronica->id.") order by visitas desc limit 0, 10";
                break;
                case 'CAT':
                    $query="select titol, idcronicas, link, intro_cat, cartell, data from cronicas where (idioma = 'CAT' OR idioma = 'BOTH') AND (idcronicas <> ".$cronica->id.") order by visitas desc limit 0, 10";
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
					$titol=$resultat['titol'];
					$link=$resultat['link'];
                    $cartell=$resultat['cartell'];                    
					$idcronica=$resultat['idcronicas'];
					switch ($idioma) 
                    {
                        case 'ES':
                            $intro=$resultat['intro_es'];
                        break;
                        case 'CAT':
                            $intro=$resultat['intro_cat'];
                        break;
                    }
                    $cadena=explode('<br />',nl2br($intro));
                    print '<div class="cronica">';
					switch ($idioma)
					{
						case 'ES':
							print '<p><a class="linkk" href="index.php?ln=ES&sec=cronicas&'.$link.'" title="Crónica de '.$titol.'" >';
						break;
						case 'CAT':
							print '<p><a class="linkk" href="index.php?ln=CAT&sec=croniques&'.$link.'" title="Crónica de '.$titol.'" >';
						break;
					}
					print '<img class="cartell_cronica" src="pics/cronicas_pics/'.$cartell.'" width="80" align="middle" alt = "'.$titol.'"/>
            <span>'.$titol.'</span><br /><br />'.$cadena[0].'</a></p></div>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}
        }
			   
   		public function afegir_visita ($bd,$id)
		{
			$query= "select visitas, titol from cronicas where idcronicas = $id";	
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta!=FALSE) 
			{
				$resultat=$this->resultat_consulta->fetch_assoc();
                $vistes=$resultat['visitas']+1;
                $titol=$resultat['titol'];
                if (fmod($vistes, 250) == 0)        
                {
                    $tit="Nova fita a la cronica: ".$titol;
                    $mensaje="La cronica de $titol ha arribat a $vistes vistes!\n\n Una birra pel redactor!";
                    $cab = 'From: info@satanarise.com';
                    mail('info@satanarise.com', $tit, $mensaje, $cab);
                }
                $query="update cronicas set visitas=$vistes where idcronicas=$id";
                $this->resultat_consulta=$bd->query($query);
                if ($this->resultat_consulta!=FALSE) 
			    {}
				
			}
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
							} else {
								//$texte=$texte.$this->posar_negretes(nl2br(htmlspecialchars($array_texte[$i])),$tags);
                                $texte=$texte.$this->posar_negretes(nl2br($array_texte[$i]),$tags);
							}
							
						} else {
							if ($i%2!=0) 
							{	
								$array_texte[$i]=str_replace('http://','',$array_texte[$i]);
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} else {
								//$texte=$texte.$this->posar_negretes(nl2br(htmlspecialchars($array_texte[$i])),$tags);
                                $texte=$texte.$this->posar_negretes(nl2br($array_texte[$i]),$tags);
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
                    //$texte=nl2br(htmlspecialchars($texte));
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
                    //$paraules[$i]=htmlspecialchars(trim($paraules[$i]));
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
