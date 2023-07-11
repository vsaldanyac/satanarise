<?php

	class ob_colaboradors_web
	{

		public $id;
		public $resultat_consulta;
		public $numero_resultats;
		public $noticia_individual;
		
		public function __construct()
		{
			$this->id='';
			$this->numero_resultats=0;
			$this->punter=1;
			$this->quantitat=10;
			$this->noticia_individual=FALSE;
            require('sources/basic_functions.php');
		}
		
		public function estructurar_noticia($noticia,$bd,$desti)
		{
			
			for ($i=0;$i<$this->numero_resultats;$i++)
			{
				
				$noticia->reset_noticia();
				$resultat=$this->resultat_consulta->fetch_assoc();			
				$noticia->id=$resultat['idNews'];
				$noticia->titol=$resultat['Title'];
				$noticia->texte=$resultat['Body'];
				$noticia->tipus=$resultat['type'];
				$noticia->descripcio=$resultat['descripcio'];
				$noticia->timestamp=$resultat['dateIn'];
				$noticia->idioma=$resultat['Idioma'];
				$noticia->dia=substr($noticia->timestamp,8,2);
				$noticia->any=substr($noticia->timestamp,0,4);
				$noticia->mes=substr($noticia->timestamp,5,2);
				switch ($desti)
				{
					case 'noticies':				
						if ($noticia->tipus==2)
						{
							$query="select ruta from newsdata where idNews = ".$noticia->id." and tipo = 2";					
							$resultat2=$bd->query($query);
							if (($resultat2!=FALSE) && ($resultat2->num_rows==1)) 
							{
								$resultat3=$resultat2->fetch_assoc();
								$noticia->video=$resultat3['ruta'];
							}
							
						}
						$query="select ruta from newsdata where idNews = ".$noticia->id." and tipo = 1 order by orden asc";					
						$resultat2=$bd->query($query);
						if ($resultat2!=FALSE) 
						{	
							
							for ($y=0;$y<$resultat2->num_rows;$y++)
							{
								$num=$y+1;
								$var='imatge'.$num;
								$resultat3=$resultat2->fetch_assoc();
								$noticia->$var=$resultat3['ruta'];
								$noticia->control_imatges='si';
								$noticia->num_imatges=$noticia->num_imatges+1;
							}
							
						}
						$this->mostrar_noticia($noticia);
					break;
					case 'index':
						$this->mostrar_noticia_index($noticia,$i);
						if ($i==5) $i=$this->numero_resultats;
					break;
					case 'individual':
						if ($noticia->tipus==2)
						{
							$query="select ruta from newsdata where idNews = ".$noticia->id." and tipo = 2";					
							$resultat2=$bd->query($query);
							if (($resultat2!=FALSE) && ($resultat2->num_rows==1)) 
							{
								$resultat3=$resultat2->fetch_assoc();
								$noticia->video=$resultat3['ruta'];
							}
							
						}
						$query="select ruta from newsdata where idNews = ".$noticia->id." and tipo = 1 order by orden asc";					
						$resultat2=$bd->query($query);
						if ($resultat2!=FALSE) 
						{	
							
							for ($y=0;$y<$resultat2->num_rows;$y++)
							{
								$num=$y+1;
								$var='imatge'.$num;
								$resultat3=$resultat2->fetch_assoc();
								$noticia->$var=$resultat3['ruta'];
								$noticia->control_imatges='si';
								$noticia->num_imatges=$noticia->num_imatges+1;
							
							}
							
						}
						$this->mostrar_noticia_individual($noticia);
					break;
				}

				
			}
		}
		
		public function extreure_colaboradors($bd,$idioma,$tipus,$actiu) 
		/* consulta colaboradors a la bbdd a partir de la conexió, idioma, tipus i activitat */
		{
			/* Demanar dades a bbdd ordenat per id */
			switch ($idioma) {
                case 'ES':
                    $bio='bio_es';
                    $carreg='carreg_es';
                break;
                case 'CAT':
                    $bio='bio_cat';
                    $carreg='carreg_cat';
                break;
            }
            if ($tipus!=5)
            {
               $query= "select nom, mail, $bio, ruta, $carreg from colaboradors where tipus = $tipus and actiu = $actiu order by nom";
            } else {
               $query= "select nom from colaboradors where actiu = $actiu";
            }		
			$this->resultat_consulta=$bd->query($query);
            if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				
			}
            			
		}
		public function extreure_noticia($bd,$id,$idioma) 
		/* consulta noticies a la bbdd a partir d'una id */
		{
			
			$error=TRUE;
			$query= "select news.idNews, type, descripcio, newscontent.Idioma, news.dateIn, Title, Body from news, newscontent where news.idNews = ".$id." and newscontent.idNews = ".$id." and newscontent.Idioma='".$idioma."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta!=FALSE) 
			{
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats==0)	 
				{
					$error=FALSE;
				}
			} else {
				$error=FALSE;
			}
			return $error;
			
		}
		
		public function presentar_colaboradors ($colaborador,$idioma)
		{
		  
		  switch ($idioma) {
                case 'ES':
                    $bio='bio_es';
                    $carreg='carreg_es';
                break;
                case 'CAT':
                    $bio='bio_cat';
                    $carreg='carreg_cat';
                break;
          }
          if ($this->numero_resultats!=0) print '<table class="resp">';
          $control=0;
		  for ($i=0;$i<$this->numero_resultats;$i++) 
		  {
		   	$row=$this->resultat_consulta->fetch_assoc();  
            $colaborador->reset_colaboradors();
            $colaborador->nom=$row['nom'];
            $colaborador->mail=$row['mail'];
            $colaborador->ruta=$row['ruta'];
            $colaborador->bio_es=$row[$bio];
            $colaborador->carreg_es=$row[$carreg];
			    
            if ($control==0) print '<tr>';
            print '<td>
            <a name="'.convertir_cadena_arxiu($colaborador->nom).'"></a>';
            if ($colaborador->ruta!='') 
            {
                print '<a href="pics/staff/'.$colaborador->ruta.'" rel="lightbox[quien]" title="'.$colaborador->nom.'"><img src="pics/staff/'.$colaborador->ruta.'" width="140" alt="'.$colaborador->nom.'" /></a>';    
            }
            print '<p><span class="vermell">'.$colaborador->nom.'</span><br />'.$this->tractar_tag_link(1,$colaborador->bio_es);
            if ($colaborador->mail!='info@satanarise.com')
            {
                print '<p><a class="linkk" href="mailto:'.$colaborador->mail.'">'.$colaborador->mail.'</a><br />'.$colaborador->carreg_es.'</p></td>';
            }
           	if ($control==1)
            {
                print '</tr>';
                $control=0;
            } else {
                $control++;
            }       
 	      }
          if ($control==1) print '<td></td></tr>';
          print '</table>';
        }

        public function presentar_colaboradors_no_actius()
		{
		  
		 
          print '<p class="otros">';
		  for ($i=0;$i<$this->numero_resultats;$i++) 
		  {
            $row=$this->resultat_consulta->fetch_assoc();  
            if ($i!=0) print ', '; 
            print $row['nom'];
                           
 	      }
          print '</p>';
        }                 
		
		
		public function mostrar_noticia_individual($noticia)
		{
			
			print '<div class="noticia">
			<div class="data_not">'.$noticia->dia.' / '.$noticia->mes.' / '.$noticia->any.'</div>';
			
			print '<h1 class="tit_centrada">'.$noticia->titol.'</h1>';
			if ($noticia->control_imatges=='si') 
			{
				print '<div class="centrar"><a href="'.$noticia->imatge1.'" rel="lightbox['.$noticia->id.']" title="'.$noticia->titol.'"><img src = "'.$noticia->imatge1.'" width="300" alt="'.$noticia->titol.'" /></a></div>';

			}
			//$noticia->texte=$this->posar_negretes(nl2br($this->tractar_tag_link(1,$noticia->texte)),$noticia->descripcio);

			$noticia->texte=nl2br($this->tractar_tag_link(1,$noticia->texte));
			$noticia->texte=$this->posar_negretes($noticia->texte,$noticia->descripcio);
			print '<p>'.$noticia->texte.'</p>';
			if ($noticia->tipus==2) 
			{
				print '<div class="centrar">
   	         	<iframe width="600" height="338" src="https://www.youtube.com/embed/'.$noticia->video.'?rel=0" frameborder="0" allowfullscreen></iframe>
	            </div>';

			}
			if ($noticia->num_imatges>1) {
				print '<div class="centrar">';
					for ($i=2;$i<=$noticia->num_imatges;$i++)
					{
						$var = 'imatge'.$i;
						print'<a href=""'.$noticia->$var.'"" rel="lightbox['.$noticia->id.']" title="'.$noticia->titol.'"><img class="general" src = "'.$noticia->$var.'" width="300" alt="'.$noticia->titol.'" /></a>';
					}
					print '</div>';
			}
?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>

<!-- AddThis Button END -->
<?php
			print '</div>';
                 
		}
		
		
		public function mostrar_noticia_index ($noticia,$control_tags)
		{
			if ($control_tags%2==0) { /*parell*/
				print '<div class="not">';
			}
			switch ($noticia->idioma)
			{
				case 'ES':
					$section='noticias';
				break;
				case 'CAT':
				$section='noticies';
				break;
			}
			print '<h1><a class="linkk" href="index.php?ln='.$noticia->idioma.'&sec='.$section.'&id='.$noticia->id.'&noticia='.(urlencode($noticia->titol)).'"> '.$noticia->titol.'</a></h1>';
			$noticia->texte=$this->tractar_tag_link(2,$noticia->texte);
			print '<p>'.substr($noticia->texte,0,115).'...</p>';
			if (($control_tags%2!=0) || ($control_tags==($this->numero_resultats-1))) {
				print '</div>';
			}
		}
		
		public function tractar_tag_link($opcio,$texte)
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
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} else {
								$texte=$texte.htmlspecialchars($array_texte[$i]);
							}
							
						} else {
							if ($i%2!=0) 
							{
								$texte=$texte.'<a class="linkk" target="_blank" href="http://'.$array_texte[$i].'">'.$array_texte[$i].'</a>';
							} else {
								$texte=$texte.htmlspecialchars($array_texte[$i]);
							}
						}
					}
				break;
				
				case '2': /* Anula le tag [link]www.exemple.s[link] -> www.exemple.es i el filtra per caracters html */
					for ($i=0;$i<count($array_texte);$i++)
					{
						$texte=$texte.$array_texte[$i];
					}
					$texte=htmlspecialchars($texte);
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
		
	}
?>	