<?php

	class ob_preferidos_web
	{

		public $id;
		public $resultat_consulta;
		public $resultat_consulta2;
		public $numero_resultats;
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
		
		
		public function extreure_preferidos_per_data_entrada($bd,$punter,$quantitat) 
		/* consulta noticies a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$punter-1;
			
			$query= "select idpreferidos, nom, idpreferidos, pic, obs, resp1, resp2, resp3, resp4, resp5 from preferidos  order by data desc limit ".$inici.", ".$quantitat;
            	
            $this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
			}
			
		}
		
		public function mostrar_preferidos_per_data_entrada($bd,$leng)
		{
			$preferido  = new ob_preferidos;
			for ($i=0;$i<$this->numero_resultats;$i++)
			{
				$preferido->reset_preferidos();
				$resultat=$this->resultat_consulta->fetch_assoc();
				$preferido->nom=$resultat['nom'];
				$preferido->obs=$resultat['obs'];
				$preferido->pic=$resultat['pic'];
				$preferido->resp1=$resultat['resp1'];
				$preferido->resp2=$resultat['resp2'];
                $preferido->resp3=$resultat['resp3'];
                $preferido->resp4=$resultat['resp4'];
                $preferido->resp5=$resultat['resp5'];
                $preferido->udpreferidos=$resultat['idpreferidos'];                
                print '<div class="novedad">';
                print '<img class="covermini" src="pics/preferits/'.$preferido->pic.'" width="80" height="80" alt="'.$preferido->nom.'"/>';
                print '<div class="dades"><h1>'.$preferido->nom.'</h1>';
                print '<h2>'.$preferido->obs.'</h2>';
                print '</div></div>';
			}
		}
		
		public function extreure_preferidos_lateral()
        {
            
        }
        public function mostrar_preferidos_lateral()
        {
            
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