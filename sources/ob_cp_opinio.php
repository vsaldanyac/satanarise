<?php
	class ob_cp_opinio {
	
		public $formulari_ok; /* control dels formularis */
		public $error;
		public $resultat_consulta;
		public $resultat_consulta2;
		public $numero_resultats;

		
		
		public function __construct()
		{
			$this->formulari_ok=FALSE;
			
			$this->error='Errores:<br /> ';
			/*$this->arxius_pujats=array();*/
			$this->contador_arxius_pujats=0;
		}
		
		public function recull_parametres($formulari,$opinio) /* Mira si hi ha un formulari enviat i recull parametres */
		{
	       $opinio->reset_opinio();
			if ($formulari['enviat']=='si') {
				$this->formulari_ok=TRUE;
				if ($formulari['id']!='') {
					$opinio->id=trim($formulari['id']);
				}
                if ($opinio->timestamp=='') $time_file=(date('Y-m-d H:i:s'));
				$time_file=str_replace('-','',$time_file);
                $time_file=str_replace(' ','',$time_file);
                $time_file=str_replace(':','',$time_file);                
                if (isset($formulari['ruta_off'])){
                    $opinio->ruta=trim($formulari['ruta_off']);
                } else {
                    /* recollir imatge de la banda */
				    if (isset($_FILES['fitxer_ruta']))
    				{
        				if ($_FILES['fitxer_ruta']['error'] > 0 )
        					/* Comprovacio erros al pujar */
       					{
        					switch ($_FILES['fitxer_ruta']['error'])
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
                            if (isset($_POST['ruta_off']))
                            {
                                print 'Hi ha una imatge ja i no sha pujat res';
                                $opinio->logo=$_POST['ruta_off'];
                                             
                            }
                                
        						
       					} else {
        					$ext='';
        					if (stristr($_FILES['fitxer_ruta']['name'],'.jpg')!=FALSE) $ext='.jpg';
							if (stristr($_FILES['fitxer_ruta']['name'],'.jpeg')!=FALSE) $ext='.jpeg';
        					if (stristr($_FILES['fitxer_ruta']['name'],'.gif')!=FALSE) $ext='.gif';
        					if (stristr($_FILES['fitxer_ruta']['name'],'.png')!=FALSE) $ext='.png';
        					if ($ext=='') 
        					{
        						$this->error=$this->error.'El archivo no es una imagen .<br />';
        						$this->formulari_ok=FALSE;
        					} else {
        						$directori='../pics/opinio_pics/'.$time_file.$ext;
        						if (is_uploaded_file($_FILES['fitxer_ruta']['tmp_name']))
        						{
        				    		if (!move_uploaded_file($_FILES['fitxer_ruta']['tmp_name'],$directori))
        							{
        								$this->error=$this->error.'Error al subir la imagen a su carpeta.<br />';	
        								$this->formulari_ok=FALSE;
        							} else {
        					       		$opinio->ruta=$time_file.$ext;                                                               }
        						} else {
        							$this->error=$this->error.'Error al subir la imagen.<br />';
        							$this->formulari_ok=FALSE;
        						}
        					}
        				}
                    }
                }
				$opinio->idioma=($formulari['idioma']);
                $opinio->idcolaboradors=($formulari['idcolaboradors']);
                $opinio->titol_es=$formulari['titol_es'];
                if (($opinio->titol_es=='') && (($opinio->idioma=='ES') || ($opinio->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Titulo ES<br />';
				    $this->formulari_ok=FALSE;  
                }
                $opinio->titol_cat=$formulari['titol_cat'];
                if (($opinio->titol_cat=='') && (($opinio->idioma=='CAT') || ($opinio->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Titulo CAT.<br />';
				    $this->formulari_ok=FALSE;  
                }
                $opinio->texte_es=$formulari['texte_es'];
                if (($opinio->texte_es=='') && (($opinio->idioma=='ES') || ($opinio->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Texto ES.<br />';
				    $this->formulari_ok=FALSE;  
                }
                $opinio->texte_cat=$formulari['texte_cat'];
                if (($opinio->texte_cat=='') && (($opinio->idioma=='CAT') || ($opinio->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Texto CAT.<br />';
				    $this->formulari_ok=FALSE;  
                }
                $minut=date('i');
                $hora=date('H');
                $opinio->anydata=$formulari['anydata'];
                $opinio->mes=$formulari['mes'];
                if (($opinio->mes)<10) $opinio->mes='0'.$opinio->mes; 
                $opinio->dia=$formulari['dia'];
                if (($opinio->dia)<10) $opinio->dia='0'.$opinio->dia;
                $opinio->timestamp=$opinio->anydata.$opinio->mes.$opinio->dia.$hora.$minut.'00';
			}
			return($this->formulari_ok);
		}
		

		public function introduir($bs,$opinio,$logica_id,$id)
		{
			if (!get_magic_quotes_gpc())
			{
                $opinio->titol_es=addslashes($opinio->titol_es);
                $opinio->titol_cat=addslashes($opinio->titol_cat);
                $opinio->texte_es=addslashes($opinio->texte_es);
                $opinio->texte_cat=addslashes($opinio->texte_cat);
                $opinio->ruta=addslashes($opinio->ruta);
			}
            print 'ID: '.$opinio->id.'<br />';		
            print 'Ruta: '.$opinio->ruta.'<br />';
            print 'Titulo ES: '.$opinio->titol_es.'<br />';
            print 'Titulo CAT: '.$opinio->titol_cat.'<br />';
            print 'Texto ES: '.$opinio->texte_es.'<br />';
            print 'Texto CAT: '.$opinio->texte_cat.'<br />';
            print 'Id Colaborador: '.$opinio->idcolaboradors.'<br />';
            print 'Idioma: '.$opinio->idioma.'<br />';
            print 'Fecha: '.$opinio->timestamp.'<br />';
            	
			if ($logica_id) 
			{
				$query1="update opinio set data='".$opinio->timestamp."', idioma='".$opinio->idioma."', titol_es='".$opinio->titol_es."', titol_cat='".$opinio->titol_cat."', texte_es='".$opinio->texte_es."', texte_cat='".$opinio->texte_cat."', idcolaboradors='".$opinio->idcolaboradors."', ruta='".$opinio->ruta."' where idopinio='".$opinio->id."'" ;
			} else {
				$query1="insert into opinio (data, idcolaboradors, idioma, titol_es, titol_cat, texte_es, texte_cat, ruta, visites) values ('".$opinio->timestamp."', '".$opinio->idcolaboradors."', '".$opinio->idioma."', '".$opinio->titol_es."', '".$opinio->titol_cat."', '".$opinio->texte_es."', '".$opinio->texte_cat."', '".$opinio->ruta."', 0)";
			}
			
			$this->resultat_consulta=$bs->query($query1);
            print $query1;
			if ($this->resultat_consulta) 
			{
				
			} else {
				print '<p class="terminal">Error </p>';
			}	
		}

	
		
		public function formulari($opinio,$basedades)
		{
			print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\" enctype=\"multipart/form-data\">";
			print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$opinio->id\" \>\n";
            		
            print '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';
			
			print "<p class=\"form_data\">";
			print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';
			
            print '<p class="contingut">Idioma
			<select name="idioma">';
								
            switch ($opinio->idioma) {
				case 'ES':
					print '<option value="ES" selected="selected">Castellano</option>
					<option value="CAT">Català</option>
					<option value="BOTH">Castellano - Català</option>';
				break;
				case 'CAT':
					print '<option value="ES">Castellano</option>
					<option value="CAT" selected="selected">Català</option>
					<option value="BOTH">Castellano - Català</option>';
				break;
				case 'BOTH':
					print '<option value="ES">Castellano</option>
					<option value="CAT">Català</option>
					<option value="BOTH" selected="selected">Castellano - Català</option>';
				break;
                default:
					print '<option value="ES">Castellano</option>
					<option value="CAT">Català</option>
					<option value="BOTH">Castellano - Català</option>';
				break;
			}        
			print'</select></p>';
            		
			print '<p class="contingut">Titulo ES: <br /><br /><input class="titol_form" type="text" name="titol_es" maxlength="1000" value="'.$opinio->titol_es.'" /></p>';

            print '<p class="contingut">Titulo CAT: <br /><br /><input class="titol_form" type="text" name="titol_cat" maxlength="1000" value="'.$opinio->titol_cat.'" /></p>';
                        
            print '<p class="contingut">Imageen: <br /><br />';
            if ($opinio->logo!='')
            {
                print '<img src="../pics/opinio_pics/'.$opinio->ruta.'" width="325" /><br />';
                print "<input type=\"hidden\" name=\"ruta_off\" value=\"$opinio->ruta\" \>\n";
            }
            print '<input type="file" name="fitxer_ruta" id="fitxer_ruta"/><br />';
			print '</p>';
            
            
            
            print '<p class="contingut">Contenido ES: <br /><br />';
            print '<textarea class="texte_form" name="texte_es">'.$opinio->texte_es.'</textarea></p>';
           
            print '<p class="contingut">Contenido CAT: <br /><br />';
            print '<textarea class="texte_form" name="texte_cat">'.$opinio->texte_cat.'</textarea></p>';            
            
			
            print '<p class="contingut">Atuor: <br /><br />';
            $this->consulta_colaboradors($basedades);
            $x='<select name="idcolaboradors">';
            for ($i=0;$i<$this->numero_resultats;$i++)
            {
                $row=$this->resultat_consulta->fetch_assoc();
                if ($opinio->idcolaboradors==$row['idcolaboradors'])
                {
                    $x=$x.'<option value="'.$row['idcolaboradors'].'" selected="selected">'.$row['nom'].'</option>';
                } else {
                    $x=$x.'<option value="'.$row['idcolaboradors'].'">'.$row['nom'].'</option>';
                }
            }
            $x=$x.'</select></p>';
            print $x;		
            
            
            print '<p class="contingut">Fecha: <br /><br />';
            
            print 'Día <select name="dia">';
			for ($y=1;$y<=31;$y++) {
				if ($opinio->dia==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}
			print '</select>';
					
			print 'Mes <select name="mes">';
			for ($y=1;$y<=12;$y++) {				
				if ($opinio->mes==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}				
			print'</select>';
						
			print 'Año <select name="anydata">';
			for ($y=2024;$y<=2024;$y++) {
				if ($opinio->anydata==$y) {
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

           
		public function consulta_opinio($basedades,$desde,$quantitat)
		/* consulta media a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$desde-1;
			
			/* Recupera les 10 primeres ID */
			$query= "select idopinio from opinio order by idopinio desc limit ".$inici.", ".$quantitat." ";

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer la id de la opinion a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
					/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */
					
				}
			}

		}
		
		public function extreu_dades_opinio_per_id($bd,$opinio,$id)
		/* Extreu dades d'una unica noticia */
		{
			$opinio->reset_opinio();
            $query= "select * from opinio where idopinio = ".$id;
			
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta==FALSE) 
			{ 
				print '<p class="terminal">Error al extraer la opinion</p>';			 
			} else {
				$resultat=$this->resultat_consulta->fetch_assoc();
                $opinio->id=$resultat['idopinio'];
            	$opinio->timestamp=$resultat['data'];			
                $opinio->texte_es=$resultat['texte_es'];
                $opinio->texte_cat=$resultat['texte_cat'];
                $opinio->titol_es=$resultat['titol_es'];
                $opinio->titol_cat=$resultat['titol_cat'];
                $opinio->idioma=$resultat['idioma'];
                $opinio->ruta=$resultat['ruta'];
                $opinio->idcolaboradors=$resultat['idcolaboradors'];
                $opinio->dia=substr($opinio->timestamp,8,2);
				$opinio->anydata=substr($opinio->timestamp,0,4);
				$opinio->mes=substr($opinio->timestamp,5,2);
                
				
			}
		}
		
		public function eliminar_registre($bd,$id)
		{
            $query="select ruta from opinio where idopinio = '".$id."'";
            $this->resultat_consulta=$bd->query($query);
            $resultat=$this->resultat_consulta->fetch_assoc();
			if (file_exists('../pics/opinio_pics/'.$resultat['ruta'])) 
            {
                unlink('../pics/opinio_pics/'.$resultat['ruta']);
			}
            $query="delete from opinio where idopinio = '".$id."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Registro borrado</p>';
			} else {
				print '<p class="terminal">Delete de news fallido</p>';
			}

		}
		public function presentar_opinio_formulari($bd,$tasca,$opinio) 
		/* tenint l'objecte de la consulta les posa a pantalla */
		{
			print $this->numero_resultats;
			for ($i=0;$i<$this->numero_resultats;$i++) 
			{
				$row=$this->resultat_consulta->fetch_assoc();
				$opinio->id=$row['idopinio'];
				$query= "select titol_es, titol_cat, data from opinio where idopinio=".$opinio->id;
				$this->resultat_consulta2=$bd->query($query);
				if (!$this->resultat_consulta2==FALSE) {
					if (($this->resultat_consulta2->num_rows) == 1 )
					{
						$row=$this->resultat_consulta2->fetch_assoc();
						$opinio->titol_es=$row['titol_es'];
						$opinio->titol_cat=$row['titol_cat'];
                        $opinio->timestamp=$row['data'];
						$opinio->dia=substr($opinio->timestamp,8,2);
						$opinio->anydata=substr($opinio->timestamp,0,4);
						$opinio->mes=substr($opinio->timestamp,5,2);			
						
						print '<div class="noticia_curta">';
						switch ($tasca) 
						{
							case ('editar'):
								print '<div class="noticia_curta">';
								print "<form action=\"home_cp.php?sec=opinion&action=edit&tasca=edit&id=$opinio->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$opinio->id.' - Fecha: '.$opinio->dia.' / '.$opinio->mes.' / '.$opinio->anydata.'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								
								print 'Editar';
								
								print "\" />";						
								print "<p class=\"titol\">ES: $opinio->titol_es</p><br />";
                                print "<p class=\"titol\">CAT: $opinio->titol_cat</p><br />";
   								print "</fieldset>";
								
								print "</form></div>";
							break;
							case ('del'):
								print '<div class="noticia_curta">';
								print "<form action=\"home_cp.php?sec=opinion&action=del&tasca=del&id=$opinio->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$opinio->id.' - Fecha: '.$opinio->dia.' / '.$opinio->mes.' / '.$opinio->anydata.'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								
								print 'Eliminar';
								
								print "\" />";

                                print "<p class=\"titol\">ES: $opinio->titol_es</p><br />";
                                print "<p class=\"titol\">CAT: $opinio->titol_cat</p><br />";
								print "</fieldset>";

								print "</form></div>";
							break;
							case ('edit_del'):
								print '<div class="noticia_curta">';
								print '<fieldset><legend class="white">Id: '.$opinio->id.' - Fecha: '.$opinio->dia.' / '.$opinio->mes.' / '.$opinio->anydata.'</legend>';
								print "<form action=\"home_cp.php?sec=opinion&action=edit&tasca=edit&id=$opinio->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";					
								print 'Editar';
								print "\" /></form>";
								print "<form action=\"home_cp.php?sec=opinion&action=del&tasca=del&id=$opinio->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Eliminar';
								print "\" /></form>";
	
								print "<p class=\"titol\">ES: $opinio->titol_es</p><br />";
                                print "<p class=\"titol\">CAT: $opinio->titol_cat</p><br />";
                                
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
				
<?php			
        print 'paso por aquiii';
        if ($punter!=1) {
    
?>					
                <a class="linkk" href="home_cp.php?sec=opinion&action=edit&punter=1"><img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
<?php
				}
				if ($punter!=1) {
						$punter_dir=$punter-10;
					print '<a class="linkk" href="home_cp.php?sec=opinion&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
				}

                if ($numero>=($punter+10)) {
						$punter_dir=$punter+10;
					print '<a class="linkk" href="home_cp.php?sec=opinion&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
				}                
                if ($numero>=($punter+10)) {
					$punter_dir=((number_format(($numero/$quantitat), 0)*$quantitat)+1)-10;
					print '<a class="linkk" href="home_cp.php?sec=opinion&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
				}
?>
            </div>    
<?php
		}
	}
?>