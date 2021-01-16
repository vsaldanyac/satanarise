<?php

	class ob_carta_web
	{

		public $id;
		public $resultat_consulta;
		public $resultat_consulta2;
		public $numero_resultats;
		public function __construct()
		{
			$this->id='';
			$this->numero_resultats=0;
			$this->punter=1;
			$this->quantitat=10;
		}
		public  function __get($nom) /* crea parametres */
		{
			return $this->$nom;
		}
	
		public function __set($nom,$valor) /* asigna valors al parametre */
		{
			return $this->$nom = $valor;
		}		
		
		
		public function extreure_carta_per_data_entrada($bd,$punter,$quantitat,$leng) 
		/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$punter-1;
			
			$query= "select idcarta, texte_es, texte_cat, titol_es, titol_cat, autor, data from carta where idioma = '".$leng."' or idioma = 'BOTH' order by idcarta desc limit ".$inici.", ".$quantitat;
            
            $this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
			}
		}
		
		public function mostrar_carta_per_data_entrada($bd,$leng)
		{
			$carta  = new ob_carta;
			for ($i=0;$i<$this->numero_resultats;$i++)
			{
				$carta->reset_carta();
				$resultat=$this->resultat_consulta->fetch_assoc();
				$carta->titol_es=$resultat['titol_es'];
				$carta->titol_cat=$resultat['titol_cat'];
                $carta->texte_es=$resultat['texte_es'];
				$carta->texte_cat=$resultat['texte_cat'];
                $carta->autor=$resultat['autor'];
                $carta->timestamp=$resultat['data'];
				$carta->id=$resultat['idcarta'];
                print '<div class="entrevista">';
                switch ($leng)
                {
                    case 'ES':
                        $link='ln=ES&sec=cartaslector&type=entrada&'; /* per canviar */
                    break;
                    case 'CAT':
                        $link='ln=CAT&sec=carteslector&type=entrada&'; /* per canviar */
                    break;                 
                    
                }
                print '<div class="data">';
                    print ($this->timestamp_a_data($carta->timestamp));
                print '</div>';
                print '<a class="linkk" href="index.php?'.$link.'id='.$carta->id.'" title="'.$carta->titol_es.'">';
                switch ($leng)
                {
                    case 'ES':
                        $texte2=substr($carta->texte_es,0,300).'...';
                        $texte=$carta->titol_es;
                    break;
                    case 'CAT':
                        $texte=$carta->titol_cat;
                        $texte2=substr($carta->texte_cat,0,300).'...';
                    break;
                }
                print '<h3 class="titol_op">'.$texte.' - '.$carta->autor.'</h3><h3 class="texte_op">'.$texte2.'</h3></a></div>';
			}
		}
		
		public function extreure_carta_unica($bd,$id,$idioma) 
		/* consultar review a la bbdd a partir d'una id */
		{
			$ok=TRUE;
            switch ($idioma)
            {
                case 'ES':
                    $query= "select carta.idcarta, carta.titol_es, carta.texte_es, carta.autor, carta.data from carta where idcarta=".$id;
                break;
                case 'CAT':
                    $query= "select carta.idcarta, carta.titol_cat, carta.texte_cat, carta.autor, carta.data from carta where idcarta=".$id;
                break;
            }
            
			$this->resultat_consulta=$bd->query($query);
            
            if ($this->resultat_consulta==FALSE) 
			{
			     $ok=FALSE;
			}
           
            return $ok;
			
			
			
		}
		
		public function mostrar_carta_unica ($idioma,$bd)
		{
		  
            $carta  = new ob_carta;
            require('sources/basic_functions.php');
            $carta->reset_carta();            
            $resultat=$this->resultat_consulta->fetch_assoc();
			$carta->id=$resultat['idcarta'];
			$carta->timestamp=$resultat['data'];
            
            switch ($idioma)
            {
                case 'ES':
                    $carta->titol=$resultat['titol_es'];
                    $carta->texte=$resultat['texte_es'];        
                break;
                case 'CAT':
                    $carta->titol=$resultat['titol_cat'];
                    $carta->texte=$resultat['texte_cat'];        
                break;
            }
            $carta->autor=$resultat['autor'];           
               
            $tags='sddsdsds';
            switch ($idioma)
            {
                case 'ES':
                    print '<div class="titdiscos"> <!-- Titol de discos --><p>';
                break;
                case 'CAT':
                    print '<div class="titdiscos"> <!-- Titol de discos --><p>';
                break;
            }
            print  $carta->titol.'</p></div>';
            
            print '<div id="entrevista">';
            
            
            /* preparar texte */
            
            
            print '<h3 class="texte_carta">'.$this->preparar_texte($carta->texte,$tags).'</p>';

            print '<!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style" style="margin-left:50px;">
            <a class="addthis_button_preferred_1"></a>
            <a class="addthis_button_preferred_2"></a>
            <a class="addthis_button_preferred_3"></a>
            <a class="addthis_button_preferred_4"></a>
            <a class="addthis_button_compact"></a>
            <a class="addthis_counter addthis_bubble_style"></a>
            <span style="margin-left:5px;"><g:plusone></g:plusone></span>

            </div>
            
            <!-- AddThis Button END -->';
            
            
            print '<p class="firma">'.$carta->autor.'<br />'.$this->timestamp_a_data($carta->timestamp).'</p></div>';
            $this->inserir_sugerencies($bd,$carta,$idioma);
		}
		
		public function inserir_sugerencies($bd,$carta,$idioma) 
		/* mostra les sugerencies de reviews que surten al final d'una review, per estil, per país i per mes visitades */
		{
			
			/* per mes vistes */
			switch ($idioma)
            {
                case 'ES':
                    $query="select idcarta, titol_es, data from carta where (idioma = 'ES' OR idioma = 'BOTH') AND (idcarta <> ".$carta->id.") order by visites desc limit 0, 5";
                break;
                case 'CAT':
                    $query="select idcarta, titol_cat, data from carta where (idioma = 'CAT' OR idioma = 'BOTH') AND (idcarta <> ".$carta->id.") order by visites desc limit 0, 5";
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
					$idcarta=$resultat['idcarta'];
					switch ($idioma) 
                    {
                        case 'ES':
                            $titol=$resultat['titol_es'];
                        break;
                        case 'CAT':
                            $titol=$resultat['titol_cat'];
                        break;
                    }
                    
					print '<div class="entrevista_rec"><div class="data">';
                    print $this->timestamp_a_data($carta->timestamp);
                    print '</div>';
                    
                
            
					switch ($idioma)
					{
						case 'ES':
							print '<a class="linkk" href="index.php?ln=ES&sec=cartaslector&id='.$idcarta.'" title="'.$titol.' ><div class="recomend_item">';
						break;
						case 'CAT':
							print '<a class="linkk" href="index.php?ln=CAT&sec=carteslector&if='.$idcarta.'" title="'.$titol.' ><div class="recomend_item">';
						break;
					}
					print '<p>'.$titol.'</p>';
					print '</div></a>';
				}
				if ($this->numero_resultats>0) print '</div>';
			}
			
			
			
		}
   		public function afegir_visita ($bd,$id)
		{
			$query= "select visites, titol_es from carta where idcarta = $id";	
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta!=FALSE) 
			{
				$resultat=$this->resultat_consulta->fetch_assoc();
                $vistes=$resultat['visites']+1;
                $titol=$resultat['titol_es'];
                if (fmod($vistes, 250) == 0)        
                {
                    $tit="Nova a fita a una carta del lector: ".$titol;
                    $mensaje="La carta del lector $titol ha arribat a $vistes vistes!\n\n Una birra pel redactor!";
                    $cab = 'From: info@satanarise.com';
                    mail('info@satanarise.com', $tit, $mensaje, $cab);
                }
                $query="update carta set visites=$vistes where idcarta=$id";
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
                                //$texte=$texte.$this->posar_negretes($array_texte[$i],$tags);
                                $texte=$texte.$this->posar_negretes(nl2br($array_texte[$i]),$tags);
							}
							
						} else {
							if ($i%2!=0) 
							{	
								$array_texte[$i]=str_replace('http://','',$array_texte[$i]);
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} else {
								//$texte=$texte.$this->posar_negretes(nl2br(htmlspecialchars($array_texte[$i])),$tags);
                                //$texte=$texte.$this->posar_negretes($array_texte[$i],$tags);
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
					//$paraules[$i]=htmlspecialchars(trim($paraules[$i]));
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
?>	