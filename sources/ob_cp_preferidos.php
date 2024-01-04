<?php
	class ob_cp_preferidos {
	
		public $formulari_ok; /* control dels formularis */
		public $error;
		public $resultat_consulta;
		public $resultat_consulta2;
		public $numero_resultats;
		public $arxius_pujats;
		public $contador_arxius_pujats;

		
		
		public function __construct()
		{
			$this->formulari_ok=FALSE;
			
			$this->error='Errores:<br /> ';
			/*$this->arxius_pujats=array();*/
			$this->contador_arxius_pujats=0;
		}
		
		public function recull_parametres($formulari,$preferido,$basedades) /* Mira si hi ha un formulari enviat i recull parametres */
		{
	
			if ($formulari['enviat']=='si') {
				$this->formulari_ok=TRUE;
				if ($formulari['id']!='') {
					$preferido->id=trim($formulari['id']);
				}
                
                $preferido->nom=trim($formulari['nom']);
				if ($preferido->nom=='') 
				{
					$this->error=$this->error.'No se ha rellenado el nombre.<br />';
					$this->formulari_ok=FALSE;
				} else {
				    if (isset($formulari['pic'])) $preferido->logo=trim($formulari['pic']);
                    $time_file=(date('YmdHis'));
                    /* recollir imatge de la nom */
    				if (isset($_FILES['pic']))
    				{
    					if ($_FILES['pic']['error'] > 0 )
    					/* Comprovacio erros al pujar */
    					{
    						switch ($_FILES['pic']['error'])
    						{
    							case 1:
    								$this->error=$this->error.'El archivo excede del tamaño máximo.<br />';
    								$this->formulari_ok=FALSE;
    							break;
    							case 2:
    								$this->error=$this->error.'El archivo excede del tamaño máximo.<br />';
    								$this->formulari_ok=FALSE;
    								break;
    							case 4:
    							break;
    							default:
    								$this->error=$this->error.'Error al subir el archivo '.$i.'.<br />';
    									$this->formulari_ok=FALSE;
    							break;
    						}
    						
    					} else {
    							$ext='';
    						if (stristr($_FILES['pic']['name'],'.jpg')!=FALSE) $ext='.jpg';
							if (stristr($_FILES['pic']['name'],'.jpeg')!=FALSE) $ext='.jpeg';
    						if (stristr($_FILES['pic']['name'],'.gif')!=FALSE) $ext='.gif';
    						if (stristr($_FILES['pic']['name'],'.png')!=FALSE) $ext='.png';
    						if ($ext=='') 
    						{
    								$this->error=$this->error.'El archivo no es una imagen válida.<br />';
    							$this->formulari_ok=FALSE;
    						} else {
    							$directori='../pics/favoritos/'.convertir_cadena_arxiu($preferido->pic).$time_file.$ext;
    							if (is_uploaded_file($_FILES['pic']['tmp_name']))
    								{
    								if (!move_uploaded_file($_FILES['pic']['tmp_name'],$directori))
    								{
    									$this->error=$this->error.'Error al subir la imagen a su carpeta.<br />';	
    									$this->formulari_ok=FALSE;
    								} else {
    									$preferido->pic=convertir_cadena_arxiu($preferido->pic).$time_file.$ext;                                            
    								}
    							} else {
    								$this->error=$this->error.'Error al subir la imagen.<br />';
    								$this->formulari_ok=FALSE;
    							}
    						}
    					}
    				}
        
                    if ($preferido->pic=='') {
                        $nom=convertir_cadena_arxiu($preferido->nom);
                        $correcte=FALSE;
                        if (file_exists('../pics/favoritos/'.$nom.$time_file.'.jpg')) {
                            $correcte=TRUE;
                            $preferido->pic=$nom.'.jpg';
                        }
						if (file_exists('../pics/favoritos/'.$nom.$time_file.'.jpeg')) {
                            $correcte=TRUE;
                            $preferido->pic=$nom.'.jpeg';
                        }
                        if (file_exists('../pics/favoritos/'.$nom.$time_file.'.gif')) {
                            $correcte=TRUE;
                            $preferido->pic=$nom.'.gif';
                        }                         
                        if (file_exists('../pics/logos/'.$nom.$time_file.'.png')) {
                            $correcte=TRUE;
                            $preferido->pic=$nom.'.png';
                        }
                        if ($correcte==FALSE) {
                            $this->error=$this->error.'No hay imagen del logo de la nom.<br />';
				            $this->formulari_ok=FALSE;  
                        } 
                    }
				}
				
                
                $preferido->obs=trim($formulari['obs']);
				if ($preferido->obs=='') 
				{
					$this->error=$this->error.'No se han rellenado las observaciones.<br />';
					$this->formulari_ok=FALSE;
				}
                
				$preferido->resp1=($formulari['resp1']);
                $preferido->resp2=($formulari['resp2']);
                $preferido->resp3=($formulari['resp3']);
                $preferido->resp4=($formulari['resp4']);
                $preferido->resp5=($formulari['resp5']);

                
                /* buscar hora actual per afegir a la data introduida */
                
                
                $minut=date('i');
                $hora=date('H');
                $preferido->anydata=$formulari['anydata'];
                $preferido->mes=$formulari['mes'];
                if (($preferido->mes)<10) $preferido->mes='0'.$preferido->mes; 
                $preferido->dia=$formulari['dia'];
                if (($preferido->dia)<10) $preferido->dia='0'.$preferido->dia;
                $preferido->data=$preferido->anydata.$preferido->mes.$preferido->dia.$hora.$minut.'00';
                 
                
                
                              
			
			}
			return($this->formulari_ok);
		}
       
		
		public function introduir($bs,$preferido,$logica_id,$id)
		{
			if (!get_magic_quotes_gpc())
			{
				$preferido->nom=addslashes(htmlspecialchars($preferido->nom));
                $preferido->obs=addslashes(htmlspecialchars($preferido->obs));                
                $preferido->pic=addslashes($preferido->pic);
                $preferido->resp1=addslashes($preferido->resp1);
                $preferido->resp2=addslashes($preferido->resp2);
                $preferido->resp3=addslashes($preferido->resp3);
                $preferido->resp4=addslashes($preferido->resp4);
                $preferido->resp5=addslashes($preferido->resp5);         
				
			}
            print 'ID: '.$preferido->id.'<br />';		
            print 'nom: '.$preferido->nom.'<br />';
            print 'Ruta pic: '.$preferido->pic.'<br />';
            print 'Observaciones: '.$preferido->obs.'<br />';   
            print 'resp1: '.$preferido->resp1.'<br />';
            print 'resp2: '.$preferido->resp2.'<br />';
            print 'resp3: '.$preferido->resp3.'<br />';
            print 'resp4: '.$preferido->resp4.'<br />';
            print 'resp5: '.$preferido->resp5.'<br />';
            print 'Fecha: '.$preferido->data.'<br />';
            print 'Link: '.$preferido->link.'<br />';
            	
			if ($logica_id) 
			{
				$query1="update preferidos set data='".$preferido->data."', nom='".$preferido->nom."', obs='".$preferido->obs."', pic='".$preferido->pic."', resp1='".$preferido->resp1."', resp2='".$preferido->resp2."', resp3='".$preferido->resp3."', resp4='".$preferido->resp4."', resp5='".$preferido->resp5."' where idpreferidos='".$preferido->id."'" ;
			} else {
				$query1="insert into preferidos (data, nom, obs, pic, resp1, resp2, resp3, resp4, resp5) values ('".$preferido->data."', '".$preferido->nom."', '".$preferido->obs."', '".$preferido->pic."', '".$preferido->resp1."', '".$preferido->resp2."', '".$preferido->resp3."', '".$preferido->resp4."', '".$preferido->resp5."')";
				$query2="select idpreferidos from preferidos order by idpreferidos desc limit 1";
			}
				
		}

	
		
		public function formulari($preferido,$basedades)
		{
			print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\" enctype=\"multipart/form-data\">";
			print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$preferido->id\" \>\n";            			
			
            print '<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';
			
			print "<p class=\"form_data\">";
			print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';
					
					
			print '<p class="contingut">nom: <br /><br /><input class="titol_form" type="text" name="nom" maxlength="1000" value="'.$preferido->nom.'" /></p>';
            
            print '<p class="contingut">Foto: <br /><br />';
            if ($preferido->logo!='')
            {
                print '<img src="../pics/favoritos/'.$preferido->pìc.'" width="325" /><br />';
                print "<input type=\"hidden\" name=\"logo_off\" value=\"$preferido->pic\" \>\n";
            }
            print '<input type="file" name="pic" id="pic"/><br />';
			print '</p>';
            
            
            print '<p class="contingut">Observaciones: <br /><br /><input class="titol_form" type="text" name="obs" maxlength="1000" value="'.$preferido->obs.'" /></p>';
            
            print '<p class="contingut">Pregunta1: <br />Resposta 1: <br /><br /><input class="titol_form" type="text" name="resp1" maxlength="1000" value="'.$preferido->resp1.'" /></p>';
            print '<p class="contingut">Pregunta2: <br />Resposta 2: <br /><br /><input class="titol_form" type="text" name="resp2" maxlength="1000" value="'.$preferido->resp2.'" /></p>';
            print '<p class="contingut">Pregunta3: <br />Resposta 3: <br /><br /><input class="titol_form" type="text" name="resp3" maxlength="1000" value="'.$preferido->resp3.'" /></p>';
            print '<p class="contingut">Pregunta4: <br />Resposta 4: <br /><br /><input class="titol_form" type="text" name="resp4" maxlength="1000" value="'.$preferido->resp4.'" /></p>';
            print '<p class="contingut">Pregunta5: <br />Resposta 5: <br /><br /><input class="titol_form" type="text" name="resp5" maxlength="1000" value="'.$preferido->resp5.'" /></p>';
                       			
			
            print '<p class="contingut">Fecha: <br /><br />';
            
            print 'Día <select name="dia">';
			for ($y=1;$y<=31;$y++) {
				if ($preferido->dia==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}
			print '</select>';
					
			print 'Mes <select name="mes">';
			for ($y=1;$y<=12;$y++) {				
				if ($preferido->mes==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}				
			print'</select>';
						
			print 'Año <select name="anydata">';
			for ($y=2016;$y<=2017;$y++) {
				if ($preferido->anydata==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';

				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}
			print'</select>';
            print'</p>';
            
			
						
				
			
			print "<input type=\"submit"; 
			print "\" value=\"";					
			print 'Enviar';				
			print "\" />";
		
			print "</fieldset>";
			
			print "</form>\n";

		}

		
        public function consulta_banderes($basedades)
		/* consulta els pasisos a la bbdd a partir de la conexió */
		{
			
			
            
			$query= "select idpais, pais from banderes order by pais asc"; 

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer los paises a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
				
					
				}
			}

		}
        public function consulta_estils($basedades)
		/* consulta els estils a la bbdd a partir de la conexió */
		{   
			$query= "select idestil, estil from estil order by estil asc"; 

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer los estilos a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
				
					
				}
			}

		}

        public function consulta_colaboradors($basedades)
		/* consulta els colaboradors a la bbdd a partir de la conexió */
		{
			

			$query= "select idcolaboradors, nom from colaboradors order by nom asc"; 

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer los colaboradores a mostrar.</p>';	
			} else 
            {
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
				}

			}

		}

        public function consulta_segells($basedades)
		/* consulta els segells a la bbdd a partir de la conexió */
		{
			
			
            
			$query= "select idlabel, labelnom from label order by labelnom asc"; 

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer los sellos a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
					 
					
				}
			}

		}        
		public function consulta_preferidos($basedades,$desde,$quantitat)
		/* consulta media a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$desde-1;
			
			/* Recupera les 10 primeres ID */
			$query= "select idpreferidos from preferidos order by data desc limit ".$inici.", ".$quantitat." ";

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer la id de las preferidos a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
					/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */
					
				}
			}

		}
		
		public function extreu_dades_preferidos_per_id($bd,$preferido,$id)
		/* Extreu dades d'una unica noticia */
		{
			$query= "select * from preferidos where idpreferidos = ".$id;
			
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta==FALSE) 
			{ 
				print '<p class="terminal">Error al extraer la review</p>';			 
			} else {
				$resultat=$this->resultat_consulta->fetch_assoc();
                $preferido->id=$resultat['idpreferidos'];
            	$preferido->data=$resultat['data'];
				$preferido->disc=$resultat['disc'];
				$preferido->nom=$resultat['nom'];
				$preferido->portada=$resultat['portada'];
                $preferido->logo=$resultat['logo'];
                $preferido->video=$resultat['video'];
                $preferido->media=$resultat['media'];
                switch ($preferido->video)
                {
                    case 1:
                        $preferido->media_video=$preferido->media;
                    break;
                    case 2:
                        $preferido->media_foto=$preferido->media;
                    break;
                }
                $preferido->texte_es=$resultat['texte_es'];
                $preferido->texte_cat=$resultat['texte_cat'];
                $preferido->tracklist=$resultat['tracklist'];
                $preferido->formacio_es=$resultat['formacio_es'];
                $preferido->formacio_cat=$resultat['formacio_cat'];
                $preferido->idcolaboradors=$resultat['idcolaboradors'];
                $preferido->nota=$resultat['nota'];
                $preferido->idpais=$resultat['idpais'];
                $preferido->any=$resultat['any'];
                $preferido->idestil=$resultat['idestil'];
                $preferido->idlabel=$resultat['idlabel'];
                $preferido->tipus=$resultat['tipus'];
                $preferido->link=$resultat['link'];
                $preferido->dia=substr($preferido->data,8,2);
				$preferido->anydata=substr($preferido->data,0,4);
				$preferido->mes=substr($preferido->data,5,2);
                
				
			}
		}
		
		public function eliminar_registre($bd,$id)
		{
			
			
			$query="delete from preferidos where idpreferidos = '".$id."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Registro borrado</p>';
			} else {
				print '<p class="terminal">Delete de news fallido</p>';
			}
		

		}
		public function presentar_preferidos_formulari($bd,$tasca,$preferido) 
		/* tenint l'objecte de la consulta les posa a pantalla */
		{
			print $this->numero_resultats;
			for ($i=0;$i<$this->numero_resultats;$i++) 
			{
				$row=$this->resultat_consulta->fetch_assoc();
				$preferido->id=$row['idpreferidos'];
				$query= "select nom, disc, resp1, resp2, resp3, resp4, resp5, data from preferidos where idpreferidos=".$preferido->id;
				$this->resultat_consulta2=$bd->query($query);
				if (!$this->resultat_consulta2==FALSE) {
					if (($this->resultat_consulta2->num_rows) == 1 )
					{
						$row=$this->resultat_consulta2->fetch_assoc();
						$preferido->nom=$row['nom'];
						$preferido->disc=$row['disc'];
						$preferido->data=$row['data'];
                        $preferido->resp1=$row['resp1'];
                        $preferido->resp2=$row['resp2'];
                        $preferido->resp3=$row['resp3'];
                        $preferido->resp4=$row['resp4'];
                        $preferido->resp5=$row['resp5'];
						$preferido->dia=substr($preferido->data,8,2);
						$preferido->anydata=substr($preferido->data,0,4);
						$preferido->mes=substr($preferido->data,5,2);			
						
						print '<div class="noticia_curta">';
						switch ($tasca) 
						{
							case ('editar'):
								print '<div class="noticia_curta">';
								print "<form action=\"home_cp.php?sec=criticas&action=edit&tasca=edit&id=$preferido->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$preferido->id.' - Fecha: '.$preferido->dia.' / '.$preferido->mes.' / '.$preferido->anydata.'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								
								print 'Editar';
								
								print "\" />";						
								print "<p class=\"titol\">Nom: $preferido->nom</p><br />";
                                print "<p class=\"titol\">Obs: $preferido->obs</p><br />";								
										
								print "</fieldset>";
								
								print "</form></div>";
							break;
							case ('del'):
								print '<div class="noticia_curta">';
								print "<form action=\"home_cp.php?sec=preferidos&action=del&tasca=del&id=$preferido->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$preferido->id.' - Fecha: '.$preferido->dia.' / '.$preferido->mes.' / '.$preferido->anydata.'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								
								print 'Eliminar';
								
								print "\" />";

                                print "<p class=\"titol\">nom: $preferido->nom</p><br />";
                                print "<p class=\"titol\">Disco: $preferido->disc</p><br />";
										
								print "</fieldset>";

								print "</form></div>";
							break;
							case ('edit_del'):
								print '<div class="noticia_curta">';
								print '<fieldset><legend class="white">Id: '.$preferido->id.' - Fecha: '.$preferido->dia.' / '.$preferido->mes.' / '.$preferido->anydata.'</legend>';
								print "<form action=\"home_cp.php?sec=preferidos&action=edit&tasca=edit&id=$preferido->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";					
								print 'Editar';
								print "\" /></form>";
								print "<form action=\"home_cp.php?sec=preferidos&action=del&tasca=del&id=$preferido->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Eliminar';
								print "\" /></form>";
	
								print "<p class=\"titol\">nom: $preferido->nom</p><br />";
                                print "<p class=\"titol\">Disco: $preferido->obs</p><br />";
										
								print "</fieldset>";
								print "</div>";
		
							break;
						}
					}
			
				}

			}
		}

		public function navegador_entrades($numero,$punter,$quantitat,$action) 
		/* controla fletxes de navegacio per presentar noticies */
		{
?>			<div class="navegador">
				
<?php			if ($punter!=1) {
?>					
                <a class="linkk" href="index_cp.php?sec=preferidos&action=edit&punter=1"><img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
<?php
				}
				if ($punter!=1) {
						$punter_dir=$punter-10;
					print '<a class="linkk" href="index_cp.php?sec=preferidos&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
				}

                if ($numero>=($punter+10)) {
						$punter_dir=$punter+10;
					print '<a class="linkk" href="index_cp.php?sec=preferidos&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
				}                
                if ($numero>=($punter+10)) {
					$punter_dir=((number_format(($numero/$quantitat), 0)*$quantitat)+1)-10;
					print '<a class="linkk" href="index_cp.php?sec=preferidos&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
				}
?>
            </div>    
<?php
		}
	}
?>