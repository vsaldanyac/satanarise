<?php
	class ob_cp_carta {
	
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
		
		public function recull_parametres($formulari,$carta) /* Mira si hi ha un formulari enviat i recull parametres */
		{
	       $carta->reset_carta();
			if ($formulari['enviat']=='si') {
				$this->formulari_ok=TRUE;
				if ($formulari['id']!='') {
					$carta->id=trim($formulari['id']);
				}
                if ($carta->timestamp=='') $time_file=(date('Y-m-d H:i:s'));
				$time_file=str_replace('-','',$time_file);
                $time_file=str_replace(' ','',$time_file);
                $time_file=str_replace(':','',$time_file);                
				$carta->idioma=($formulari['idioma']);
                $carta->autor=($formulari['autor']);
                $carta->titol_es=$formulari['titol_es'];
                if (($carta->titol_es=='') && (($carta->idioma=='ES') || ($carta->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Titulo ES<br />';
				    $this->formulari_ok=FALSE;  
                }
                $carta->titol_cat=$formulari['titol_cat'];
                if (($carta->titol_cat=='') && (($carta->idioma=='CAT') || ($carta->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Titulo CAT.<br />';
				    $this->formulari_ok=FALSE;  
                }
                $carta->texte_es=$formulari['texte_es'];
                if (($carta->texte_es=='') && (($carta->idioma=='ES') || ($carta->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Texto ES.<br />';
				    $this->formulari_ok=FALSE;  
                }
                $carta->texte_cat=$formulari['texte_cat'];
                if (($carta->texte_cat=='') && (($carta->idioma=='CAT') || ($carta->idioma=='BOTH'))) {
                    $this->error=$this->error.'No hay Texto CAT.<br />';
				    $this->formulari_ok=FALSE;  
                }
                $minut=date('i');
                $hora=date('H');
                $carta->anydata=$formulari['anydata'];
                $carta->mes=$formulari['mes'];
                if (($carta->mes)<10) $carta->mes='0'.$carta->mes; 
                $carta->dia=$formulari['dia'];
                if (($carta->dia)<10) $carta->dia='0'.$carta->dia;
                $carta->timestamp=$carta->anydata.$carta->mes.$carta->dia.$hora.$minut.'00';
			}
			return($this->formulari_ok);
		}
		

		public function introduir($bs,$carta,$logica_id,$id)
		{
			if (!get_magic_quotes_gpc())
			{
                $carta->titol_es=addslashes($carta->titol_es);
                $carta->titol_cat=addslashes($carta->titol_cat);
                $carta->texte_es=addslashes($carta->texte_es);
                $carta->texte_cat=addslashes($carta->texte_cat);
			}
            print 'ID: '.$carta->id.'<br />';		
            print 'Titulo ES: '.$carta->titol_es.'<br />';
            print 'Titulo CAT: '.$carta->titol_cat.'<br />';
            print 'Texto ES: '.$carta->texte_es.'<br />';
            print 'Texto CAT: '.$carta->texte_cat.'<br />';
            print 'Autor: '.$carta->autor.'<br />';
            print 'Idioma: '.$carta->idioma.'<br />';
            print 'Fecha: '.$carta->timestamp.'<br />';
            	
			if ($logica_id) 
			{
				$query1="update carta set data='".$carta->timestamp."', idioma='".$carta->idioma."', titol_es='".$carta->titol_es."', titol_cat='".$carta->titol_cat."', texte_es='".$carta->texte_es."', texte_cat='".$carta->texte_cat."', autor='".$carta->autor."' where idcarta='".$carta->id."'" ;
			} else {
				$query1="insert into carta (data, autor, idioma, titol_es, titol_cat, texte_es, texte_cat, visites) values ('".$carta->timestamp."', '".$carta->autor."', '".$carta->idioma."', '".$carta->titol_es."', '".$carta->titol_cat."', '".$carta->texte_es."', '".$carta->texte_cat."', 0)";
			}
			
			$this->resultat_consulta=$bs->query($query1);
            print $query1;
			if ($this->resultat_consulta) 
			{
				
			} else {
				print '<p class="terminal">Error </p>';
			}	
		}

	
		
		public function formulari($carta,$basedades)
		{
			print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\" enctype=\"multipart/form-data\">";
			print "<input type=\"hidden\" name=\"enviat\" value=\"si\" \>\n";
			print "<input type=\"hidden\" name=\"id\" value=\"$carta->id\" \>\n";
            		
            print '<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />';
			
			print "<p class=\"form_data\">";
			print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';
			
            print '<p class="contingut">Idioma
			<select name="idioma">';
								
            switch ($carta->idioma) {
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
            		
			print '<p class="contingut">Titulo ES: <br /><br /><input class="titol_form" type="text" name="titol_es" maxlength="1000" value="'.$carta->titol_es.'" /></p>';

            print '<p class="contingut">Titulo CAT: <br /><br /><input class="titol_form" type="text" name="titol_cat" maxlength="1000" value="'.$carta->titol_cat.'" /></p>';
                        
            
            print '<p class="contingut">Contenido ES: <br /><br />';
            print '<textarea class="texte_form" name="texte_es">'.$carta->texte_es.'</textarea></p>';
           
            print '<p class="contingut">Contenido CAT: <br /><br />';
            print '<textarea class="texte_form" name="texte_cat">'.$carta->texte_cat.'</textarea></p>';            
            
			
            print '<p class="contingut">Atuor: <br /><br /><input class="titol_form" type="text" name="autor" maxlength="1000" value="'.$carta->autor.'" /></p>';
            
            
            print '<p class="contingut">Fecha: <br /><br />';
            
            print 'Día <select name="dia">';
			for ($y=1;$y<=31;$y++) {
				if ($carta->dia==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}
			print '</select>';
					
			print 'Mes <select name="mes">';
			for ($y=1;$y<=12;$y++) {				
				if ($carta->mes==$y) {
					print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
				} else {
					print '<option value="'.$y.'">'.$y.'</option>';
				}
			}				
			print'</select>';
						
			print 'Año <select name="anydata">';
			for ($y=2017;$y<=2017;$y++) {
				if ($carta->anydata==$y) {
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

		
        

        

           
		public function consulta_carta($basedades,$desde,$quantitat)
		/* consulta media a la bbdd a partir de la conexió, el numero d'inici de la consulta per data i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$desde-1;
			
			/* Recupera les 10 primeres ID */
			$query= "select idcarta from carta order by idcarta desc limit ".$inici.", ".$quantitat." ";

			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer la id de la carta a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
					/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */
					
				}
			}

		}
		
		public function extreu_dades_carta_per_id($bd,$carta,$id)
		/* Extreu dades d'una unica noticia */
		{
			$carta->reset_entrevistes();
            $query= "select * from carta where idcarta = ".$id;
			
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta==FALSE) 
			{ 
				print '<p class="terminal">Error al extraer la carta</p>';			 
			} else {
				$resultat=$this->resultat_consulta->fetch_assoc();
                $carta->id=$resultat['idcarta'];
            	$carta->timestamp=$resultat['data'];			
                $carta->texte_es=$resultat['texte_es'];
                $carta->texte_cat=$resultat['texte_cat'];
                $carta->titol_es=$resultat['titol_es'];
                $carta->titol_cat=$resultat['titol_cat'];
                $carta->idioma=$resultat['idioma'];
                $carta->autor=$resultat['autor'];
                $carta->dia=substr($carta->timestamp,8,2);
				$carta->anydata=substr($carta->timestamp,0,4);
				$carta->mes=substr($carta->timestamp,5,2);
                
				
			}
		}
		
		public function eliminar_registre($bd,$id)
		{
            
            $query="delete from carta where idcarta = '".$id."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Registro borrado</p>';
			} else {
				print '<p class="terminal">Delete de news fallido</p>';
			}

		}
		public function presentar_carta_formulari($bd,$tasca,$carta) 
		/* tenint l'objecte de la consulta les posa a pantalla */
		{
			print $this->numero_resultats;
			for ($i=0;$i<$this->numero_resultats;$i++) 
			{
				$row=$this->resultat_consulta->fetch_assoc();
				$carta->id=$row['idcarta'];
				$query= "select titol_es, titol_cat, data from carta where idcarta=".$carta->id;
				$this->resultat_consulta2=$bd->query($query);
				if (!$this->resultat_consulta2==FALSE) {
					if (($this->resultat_consulta2->num_rows) == 1 )
					{
						$row=$this->resultat_consulta2->fetch_assoc();
						$carta->titol_es=$row['titol_es'];
						$carta->titol_cat=$row['titol_cat'];
                        $carta->timestamp=$row['data'];
						$carta->dia=substr($carta->timestamp,8,2);
						$carta->anydata=substr($carta->timestamp,0,4);
						$carta->mes=substr($carta->timestamp,5,2);			
						
						print '<div class="noticia_curta">';
						switch ($tasca) 
						{
							case ('editar'):
								print '<div class="noticia_curta">';
								print "<form action=\"home_cp.php?sec=carta&action=edit&tasca=edit&id=$carta->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$carta->id.' - Fecha: '.$carta->dia.' / '.$carta->mes.' / '.$carta->anydata.'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								
								print 'Editar';
								
								print "\" />";						
								print "<p class=\"titol\">ES: $carta->titol_es</p><br />";
                                print "<p class=\"titol\">CAT: $carta->titol_cat</p><br />";
   								print "</fieldset>";
								
								print "</form></div>";
							break;
							case ('del'):
								print '<div class="noticia_curta">';
								print "<form action=\"home_cp.php?sec=carta&action=del&tasca=del&id=$carta->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$carta->id.' - Fecha: '.$carta->dia.' / '.$carta->mes.' / '.$carta->anydata.'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								
								print 'Eliminar';
								
								print "\" />";

                                print "<p class=\"titol\">ES: $carta->titol_es</p><br />";
                                print "<p class=\"titol\">CAT: $carta->titol_cat</p><br />";
								print "</fieldset>";

								print "</form></div>";
							break;
							case ('edit_del'):
								print '<div class="noticia_curta">';
								print '<fieldset><legend class="white">Id: '.$carta->id.' - Fecha: '.$carta->dia.' / '.$carta->mes.' / '.$carta->anydata.'</legend>';
								print "<form action=\"home_cp.php?sec=carta&action=edit&tasca=edit&id=$carta->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";					
								print 'Editar';
								print "\" /></form>";
								print "<form action=\"home_cp.php?sec=carta&action=del&tasca=del&id=$carta->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Eliminar';
								print "\" /></form>";
	
								print "<p class=\"titol\">ES: $carta->titol_es</p><br />";
                                print "<p class=\"titol\">CAT: $carta->titol_cat</p><br />";
                                
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
                <a class="linkk" href="home_cp.php?sec=entrevistas&action=edit&punter=1"><img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
<?php
				}
				if ($punter!=1) {
						$punter_dir=$punter-10;
					print '<a class="linkk" href="home_cp.php?sec=carta&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
				}

                if ($numero>=($punter+10)) {
						$punter_dir=$punter+10;
					print '<a class="linkk" href="home_cp.php?sec=carta&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
				}                
                if ($numero>=($punter+10)) {
					$punter_dir=((number_format(($numero/$quantitat), 0)*$quantitat)+1)-10;
					print '<a class="linkk" href="homeindex_cp.php?sec=carta&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
				}
?>
            </div>    
<?php
		}
	}
?>