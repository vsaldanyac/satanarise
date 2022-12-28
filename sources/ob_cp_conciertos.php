<?php
	class cp_propers_concerts 
	{
		
		public $formulari_1_ok;
		public $formulari_2_ok;
		public $error;
		public $data;
		public $num_concerts; /* control del numero de ocncerts a mostrar al formular 2 */
		public $num_bandes; /* control del número de bandes a mostrar per conert al formulari 2 */
		public $dades;
		public $resultat_consulta;
		public $resultat_consulta2;
		public $numero_resultats;
		public $mini_dades;



		public function __construct()

		{
			$this->formulari_1_ok=FALSE;
			$this->formulari_2_ok=FALSE;
			$this->error='Error: ';
			$this->timestamp='';
			
			
		}
		
		public function __set($name,$value)
		{
			$this->$name=$value;
		}
		public function __get($name)
		{
			return $this->$name;
		}
		
		public function recull_parametres_formulari_1($formulari)
		{
			if (isset($formulari['enviat_formulari_1'])) 
			{ /* formulari 1 enviat */
				$this->num_concerts=$formulari['num_concerts'];
				$this->num_bandes=$formulari['num_bandes'];
				$this->formulari_1_ok=TRUE;			
			} 
			return $this->formulari_1_ok;
		}

		public function estructura_objectes_concerts()
		{

			$this->dades = new entrada_concerts($this->num_concerts, $this->num_bandes);
		}
				
		public function recull_parametres_formulari_2($formulari,$id) /* Mira si hi ha un formulari enviat i recull parametres */
		{
			if (isset($_POST['enviat_formulari_2'])) {
				if ($_POST['enviat_formulari_2']=='si') {
					$this->formulari_2_ok=TRUE;

					$this->num_concerts=$formulari['num_concerts'];
					$this->num_bandes=$formulari['num_bandes'];
					$this->estructura_objectes_concerts();
				    /*$this->dades->cartell=trim($formulari['cartell_generic']);*/
                    
				    $time_file=str_replace('-','',date('Y-m-d H:i:s'));
                    $time_file=str_replace(' ','',$time_file);
                    $time_file=str_replace(':','',$time_file);
                    /* recollit file */
                    if ($_FILES['cartell_generic']['error'] > 0 )
					/* Comprovacio erros al pujar */
					{
						switch ($_FILES['cartell_generic']['error'])
						{
							case 1:
								$this->error=$this->error.'El cartel generico excede del tamaño máximo.<br />';
								$this->formulari_ok=FALSE;
							break;
							case 2:
								$this->error=$this->error.'El cartel generico excede del tamaño máximo.<br />';
								$this->formulari_ok=FALSE;
							break;
							case 4:
							break;
							default:
								$this->error=$this->error.'Error al subir el cartel generico.<br />';
								$this->formulari_ok=FALSE;
							break;
 						}
                        /* si hi ha imatge, copiarla */
                        
                        if (isset($_POST['cartell_pujat']))
                        {
                            $this->dades->cartell=$_POST['cartell_pujat'];        
                        }

						
					} else {
						$ext='';
						if (stristr($_FILES['cartell_generic']['name'],'.jpg')!=FALSE) $ext='.jpg';
						if (stristr($_FILES['cartell_generic']['name'],'.gif')!=FALSE) $ext='.gif';
						if (stristr($_FILES['cartell_generic']['name'],'.png')!=FALSE) $ext='.png';
						if ($ext=='') 
						{
							$this->error=$this->error.'El archivo no es una imagen.<br />';
							$this->formulari_ok=FALSE;
						} else {
							$directori=$time_file.$ext;
                            
							if (is_uploaded_file($_FILES['cartell_generic']['tmp_name']))
							{
								if (!move_uploaded_file($_FILES['cartell_generic']['tmp_name'],'../pics/conc/'.$directori))
								{
									$this->error=$this->error.'Error al subir la imagen a su carpeta.<br />';	
									$this->formulari_ok=FALSE;
								} else {								    
									$this->dades->cartell=$time_file.$ext;                                        
									
								}
							} else {
								$this->error=$this->error.'Error al subir la imagen.<br />';
								$this->formulari_ok=FALSE;
							}
						}
					}
                    
					
					$this->dades->tipus=$formulari['tipus'];
					$this->dades->titol=trim($formulari['titol']);
					$this->dades->texte=trim($formulari['texte']);
                    
					
					
                    if (isset($formulari['dateIn'])) 
					{
						$this->dades->dateIn=$formulari['dateIn'];
						$this->dades->id=$id;
					} else {
						$this->dades->dateIn=$this->timestamp_actual();
					}
					for ($i=1;$i<=$this->num_concerts;$i++)
					{
						$nom='concert'.$i;
						if ($this->dades->id!='') $this->dades->$nom->id=$this->dades->id;
						$this->dades->$nom->cartell_concert=trim($formulari['cartell_concert_'.$i]);
						$this->dades->$nom->sala=trim($formulari['sala_'.$i]);
						$this->dades->$nom->localitat=trim($formulari['localitat_'.$i]);
						$this->dades->$nom->link=trim($formulari['link_'.$i]);
						$this->dades->$nom->link=str_replace('http://','',$this->dades->$nom->link);
						$this->dades->$nom->preu=trim($formulari['preu_'.$i]);
						$this->dades->$nom->preu_ant=trim($formulari['preu_ant_'.$i]);
						if (isset($formulari['patrocinat_'.$i])) {
							$this->dades->$nom->patrocinat=1;	
						} else {
							$this->dades->$nom->patrocinat=0;	
						}
						$this->dades->$nom->dia=trim($formulari['dia_'.$i]);
						$this->dades->$nom->mes=trim($formulari['mes_'.$i]);
						$this->dades->$nom->any=trim($formulari['any_'.$i]);
						$this->dades->$nom->hora=trim($formulari['hora_'.$i]);
						$this->dades->$nom->mins=trim($formulari['mins_'.$i]);
						$this->dades->$nom->data=$this->dades->$nom->any.$this->dades->$nom->mes.$this->dades->$nom->dia.$this->dades->$nom->hora.$this->dades->$nom->mins.'00';
						for ($y=1;$y<=$this->num_bandes;$y++)
						{
							$nom2='banda'.$y;
							if ($this->dades->id!='') $this->dades->$nom->$nom2->id=$this->dades->id;
							$this->dades->$nom->$nom2->nom=trim($formulari['banda_'.$i.'_'.$y]);
							/*$this->dades->$nom->$nom2->foto=trim($formulari['imatge_'.$i.'_'.$y]);*/
							$this->dades->$nom->$nom2->video=trim($formulari['video_'.$i.'_'.$y]);
							$this->dades->$nom->$nom2->ordre=$y;
						}
					}
					$this->dades->descripcio=$formulari['descripcio'];
					
					print '<p class="contingut">';
					print 'Tipo: '.$this->dades->tipus.'<br />';
					print 'Título: '.$this->dades->titol.'<br />';
					print 'Texte: '.$this->dades->texte.'<br />';
					print 'Cartell: '.$this->dades->cartell.'<br />';
					for ($i=1;$i<=$this->num_concerts;$i++)
					{
						$nom='concert'.$i;
						print '<br />Concert '.$i.'<br /><br />';
						print 'Cartell concert: '.$this->dades->$nom->cartell_concert.'<br />';
						print 'Sala: '.$this->dades->$nom->sala.'<br />';
						print 'Localitat: '.$this->dades->$nom->localitat.'<br />';
						print 'Facebook link: '.$this->dades->$nom->link.'<br />';
						print 'Preu: '.$this->dades->$nom->preu.'<br />';
						print 'Preu anticipat: '.$this->dades->$nom->preu_ant.'<br />';
						print 'Dia: '.$this->dades->$nom->dia.'<br />';
						print 'Mes: '.$this->dades->$nom->mes.'<br />';
						print 'Any: '.$this->dades->$nom->any.'<br />';
						print 'Hora: '.$this->dades->$nom->dia.'<br />';
						print 'Min: '.$this->dades->$nom->mins.'<br />';
						print 'Timestamp: '.$this->dades->$nom->data.'<br />';
						print 'Patrocinat: '.$this->dades->$nom->patrocinat.'<br />';										
						
						for ($y=1;$y<=$this->num_bandes;$y++)
						{
							$nom2='banda'.$y;
							print '<br />Banda '.$y.'<br /><br />';
							print 'Banda: '.$this->dades->$nom->$nom2->nom.'<br />';
							/*print 'Foto: '.$this->dades->$nom->$nom2->foto.'<br />';*/
							print 'Codi video: '.$this->dades->$nom->$nom2->video.'<br />';
							
						}
					}
					print '<br /><br />Paraules clau : '.$this->dades->descripcio;
					print '</p>';
					
				}
			}
			return($this->formulari_2_ok);
		}
		

		public function validar_entrada()
		{
			
			for ($i=1;$i<=$this->num_concerts;$i++)
			{
				$nom='concert'.$i;
				if ($this->dades->tipus!=3)
				{	
					if ($this->dades->$nom->localitat=='')
					{
						$this->formulari_2_ok=FALSE;
						$this->error=$this->error.' No se ha introducido la localidad en el Concierto '.$i.'.<br />';
					}
					if ($this->dades->$nom->sala=='')
					{
						$this->formulari_2_ok=FALSE;
						$this->error=$this->error.' No se ha introducido la sala en el Concierto '.$i.'.<br />';
					}
					if ($this->dades->$nom->data=='01012013000000')
					{
						$this->formulari_2_ok=FALSE;
						$this->error=$this->error.' No se ha introducido una hora correcto en el Concierto '.$i.'.<br />';
					}
					$banda=FALSE;
					for ($y=1;$y<=$this->num_bandes;$y++)
					{
						$nom2='banda'.$y;
						if ($this->dades->$nom->$nom2->nom!='')
						{
							$banda=TRUE;
							
						}					
					}
					if ($banda==FALSE) {
						$this->formulari_2_ok=FALSE;
						$this->error=$this->error.' No se ha introducido ninguna banda en el Concierto '.$i.'.<br />';
					}
				}
			}

			
			return ($this->formulari_2_ok);
		}
		
		
		public function introduir_concert($bs,$logica_id,$id)
		{
			if (!get_magic_quotes_gpc())
			{
				$this->dades->titol=addslashes($this->dades->titol);
				$this->dades->texte=addslashes($this->dades->texte);
				$this->dades->descripcio=addslashes($this->dades->descripcio);
				$array_bandes=array();
				for ($i=1;$i<=$this->num_concerts;$i++)
					{
						$nom='concert'.$i;
						$this->dades->$nom->sala=addslashes($this->dades->$nom->sala);
						$this->dades->$nom->localitat=addslashes($this->dades->$nom->localitat);
						$this->dades->$nom->link=addslashes($this->dades->$nom->link);						
				
						for ($y=1;$y<=$this->num_bandes;$y++)
						{
							$nom2='banda'.$y;
							if ($this->dades->$nom->$nom2->nom!='')
							{ 
								$this->dades->$nom->$nom2->nom=addslashes($this->dades->$nom->$nom2->nom);
								$array_bandes[]=$this->dades->$nom->$nom2->nom;
							}
						}
					}
				/*for ($i=0;$i<count($array_bandes);$i++)
				{
					if (strstr($this->dades->descripcio,$array_bandes[$i])==FALSE)
					{
						if ($this->dades->descripcio='') 
						{
							$this->dades->descripcio=$array_bandes[$i];
						} else {
							$this->dades->descripcio=$this->dades->descripcio.', '.$array_bandes[$i];
						}
					}
				}*/
			}	
			
					

			if ($logica_id)  /* Insersio amb ID existent */
			{
				
				$query="update concerts set tipus='".$this->dades->tipus."', dateIn='".$this->dades->dateIn."', descripcio='".$this->dades->descripcio."', Nom='".$this->dades->titol."', texte='".$this->dades->texte."', cartell='".$this->dades->cartell."', num_concerts='".$this->num_concerts."', num_bandes='".$this->num_bandes."' where idGig = '".$id."'";
				$this->resultat_consulta=$bs->query($query);
				if ($this->resultat_consulta) 
				{
					print '<p class="terminal">¡¡Entrada genérica del concierto editada!!</p>';
					$query=array();
					for ($i=1;$i<=$this->num_concerts;$i++)
					{
						$nom='concert'.$i;
						if ($this->dades->$nom->sala!='')
						{
							$this->dades->$nom->id_concert=$id."_".$i;
							$query[]="delete from concertsdata where idConcert = '".$this->dades->id."_".$i."'";
							/*$query[]="insert into concertsdata (idGig, idConcert, localitat, sala, preu, preu_ant, dateConcert, dateIn, cartell_concert, patrocinat) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->localitat."', '".$this->dades->$nom->sala."', '".$this->dades->$nom->preu."', '".$this->dades->$nom->preu_ant."', '".$this->dades->$nom->data."', '".$this->dades->dateIn."', '".$this->dades->$nom->cartell_concert."', '".$this->dades->$nom->patrocinat."')";*/
							$query[]="insert into concertsdata (idGig, idConcert, link, localitat, sala, preu, preu_ant, dateConcert, dateIn, cartell_concert, patrocinat) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->link."', '".$this->dades->$nom->localitat."', '".$this->dades->$nom->sala."', '".$this->dades->$nom->preu."', '".$this->dades->$nom->preu_ant."', '".$this->dades->$nom->data."', '".$this->dades->dateIn."', '".$this->dades->$nom->cartell_concert."', '".$this->dades->$nom->patrocinat."')";
			
							for ($y=1;$y<=$this->num_bandes;$y++)
							{
								$nom2='banda'.$y;
								if ($this->dades->$nom->$nom2->nom!='')
								{
									$query[]="delete from concertsgrups where ordre= '".$y."' and idConcert = '".$this->dades->$nom->id_concert."' ";
									/*$query[]="insert into concertsgrups (idGig, idConcert, Grup, Foto, Video, ordre) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->$nom2->nom."', '".$this->dades->$nom->$nom2->foto."', '".$this->dades->$nom->$nom2->video."', '".$this->dades->$nom->$nom2->ordre."')";*/
									$query[]="insert into concertsgrups (idGig, idConcert, Grup, Video, ordre) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->$nom2->nom."', '".$this->dades->$nom->$nom2->video."', '".$this->dades->$nom->$nom2->ordre."')";
									
								} else {
									$query[]="delete from concertsgrups where ordre= '".$y."' and idConcert = '".$this->dades->$nom->id_concert."' ";
								}
							}
						} else {
									$query[]="delete from concertsdata where idConcert = '".$this->dades->id."_".$i."'";
									$query[]="delete from concertsgrups where idConcert = '".$this->dades->$nom->id_concert."' ";
						}
					}						
					for ($i=0;$i<(count($query));$i++)
					{
						print $query[$i];
						$this->resultat_consulta=$bs->query($query[$i]);
						if ($this->resultat_consulta) 
						{
							print '<p class="terminal">¡¡Entrada '.$i.' a la bbdd de concertos añadida!!</p>';
						} else {
							print '<p class="terminal">¡¡Entrada '.$i.' a la bbdd de conciertos no se ha añadido!!</p>';
							$i=(count($query));
						}
					}
				} else {
					print '<p class="terminal">¡¡Concierto NO editado!!</p>';		
				}				
				
				
			} else { /* Insersio sense ID existent */
				$query="insert into concerts (tipus, dateIn, descripcio, Nom, texte, cartell, num_concerts, num_bandes) values ('".$this->dades->tipus."', '".$this->dades->dateIn."', '".$this->dades->descripcio."', '".$this->dades->titol."', '".$this->dades->texte."', '".$this->dades->cartell."', '".$this->num_concerts."', '".$this->num_bandes."')";

				$this->resultat_consulta=$bs->query($query);
				if ($this->resultat_consulta) 
				{
					print '<p class="terminal">¡¡Entrada genérica del concierto añadida!!</p>';
					$query_id="select idGig from concerts order by idGig desc limit 1";
					$this->resultat_consulta=$bs->query($query_id);
					if ($this->resultat_consulta)
					{
						$resultat=$this->resultat_consulta->fetch_assoc();
						$this->dades->id=$resultat['idGig'];							
						$query=array();
						for ($i=1;$i<=$this->num_concerts;$i++)
						{
							$nom='concert'.$i;
							
							/*$query[]="insert into concertsdata (idGig, idConcert, localitat, sala, preu, preu_ant, dateConcert, dateIn, cartell_concert, patrocinat) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->localitat."', '".$this->dades->$nom->sala."', '".$this->dades->$nom->preu."', '".$this->dades->$nom->preu_ant."', '".$this->dades->$nom->data."', '".$this->dades->dateIn."', '".$this->dades->$nom->cartell_concert."', '".$this->dades->$nom->patrocinat."')";*/
							$query[]="insert into concertsdata (idGig, idConcert, link, localitat, sala, preu, preu_ant, dateConcert, dateIn, cartell_concert, patrocinat) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->link."', '".$this->dades->$nom->localitat."', '".$this->dades->$nom->sala."', '".$this->dades->$nom->preu."', '".$this->dades->$nom->preu_ant."', '".$this->dades->$nom->data."', '".$this->dades->dateIn."', '".$this->dades->$nom->cartell_concert."', '".$this->dades->$nom->patrocinat."')";
				
							for ($y=1;$y<=$this->num_bandes;$y++)
							{
								$nom2='banda'.$y;
								if ($this->dades->$nom->$nom2->nom!='')
								{
									/*$query[]="insert into concertsgrups (idGig, idConcert, Grup, Foto, Video, ordre) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->$nom2->nom."', '".$this->dades->$nom->$nom2->foto."', '".$this->dades->$nom->$nom2->video."', '".$this->dades->$nom->$nom2->ordre."')";*/
									$query[]="insert into concertsgrups (idGig, idConcert, Grup, Video, ordre) values ('".$this->dades->id."', '".$this->dades->id."_".$i."', '".$this->dades->$nom->$nom2->nom."', '".$this->dades->$nom->$nom2->video."', '".$this->dades->$nom->$nom2->ordre."')";
								} else {
									$y=$this->num_bandes+1;
								}
							}
						}						
						for ($i=0;$i<(count($query));$i++)
						{
							$this->resultat_consulta=$bs->query($query[$i]);
							if ($this->resultat_consulta) 
							{
								print '<p class="terminal">¡¡Entrada '.$i.' a la bbdd de concertos añadida!!</p>';
							} else {
								print '<p class="terminal">¡¡Entrada '.$i.' a la bbdd de conciertos no se ha añadido!!</p>';
								$i=(count($query));
							}
						}
						/* Comprobar si les fotos de les bandes existeixen */
						
						for ($i=0;$i<count($array_bandes);$i++)				
						{
							$nom=$this->convertir_cadena_arxiu($array_bandes[$i]);
							if ((file_exists('pics/logos/'.$nom.'.jpg')) || (file_exists('pics/logos/'.$nom.'.gif')) || (file_exists('pics/logos/'.$nom.'.png')))
							{
								print '<p class="terminal">El logo de '.$array_bandes[$i].' no está subido al servidor.</p>';
							} else {
								print '<p class="terminal">El logo de '.$array_bandes[$i].' está subido al servidor.</p>';
							}

							if ((file_exists('pics/band/'.$nom.'.jpg')) || (file_exists('pics/band/'.$nom.'.gif')) || (file_exists('pics/band/'.$nom.'.png')))
							{
								print '<p class="terminal">La imagen de '.$array_bandes[$i].' no está subida al servidor.</p>';
							} else {
								print '<p class="terminal">La imagen de '.$array_bandes[$i].' está subida al servidor.</p>';
							}
						}
						
											
					} else {
						print '<p class="terminal">¡¡La entrada genérica del concierto no se ha añadido!!</p>';		
					}				
				}
			}
		}
	
		public function formulari_1 ()
		{
			print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\">";
			print "<input type=\"hidden\" name=\"enviat_formulari_1\" value=\"si\" \>\n";

			print "<p class=\"form_data\">";
			print '<fieldset><legend><p class="contingut">Rellena el formulario para poder mostrar el formualrio de entrada de conciertos</p></legend>';
					

			
			
			print '<p class="contingut">Numero de conciertos de la gira (1 si es concierto único) :
			<select name="num_concerts">';
			for ($i=1;$i<=20;$i++) {
				if (1==$i) {
					print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

				} else {
					print '<option value="'.$i.'">'.$i.'</option>';
				}			
			}
			print' </select></p>';
			
			print '<p class="contingut">Numero de máximo de bandas en un concierto :
			<select name="num_bandes">';
			for ($i=1;$i<=40;$i++) {
				if (1==$i) {
					print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

				} else {
					print '<option value="'.$i.'">'.$i.'</option>';
				}			
			}
			print' </select></p>';

				
			print "<input type=\"submit"; 
			print "\" value=\"";
			
			print 'Enviar';
			
			print "\" /></fieldset>";
			
			print "</form>\n";

		}
		
		public function formulari_2 ()
		{
			print "<form action=\"".$_SERVER['REQUEST_URI']."\" method=\"post\" enctype=\"multipart/form-data\">";
			print "<input type=\"hidden\" name=\"enviat_formulari_2\" value=\"si\" \>\n";

			
			if (!$this->formulari_1_ok) {
				if ($this->dades->dateIn!='')
				{
					print "<input type=\"hidden\" name=\"dateIn\" value=\"".$this->dades->dateIn."\" \>\n";
				}
			}
			print "<p class=\"form_data\">";
			print '<fieldset><legend><p class="contingut">Rellena el formulario</p></legend>';
					

			
			
			print '<p class="contingut">Tipo de entrada:
			<select name="tipus">';
			if ($this->formulari_1_ok) {
				$contingut_camp=1;
			} else {
				$contingut_camp=$this->dades->tipus;
				
			}
			switch ($contingut_camp) {
				case '1':
					print '<option value="1" selected="selected">Concierto</option>
					<option value="2">Gira</option>
					<option value="3">Festival</option>';
				break;
				case '2':
					print '<option value="1">Concierto</option>
					<option value="2" selected="selected">Gira</option>
					<option value="3">Festival</option>';
				break;
				case '3':
					print '<option value="1">Concierto</option>
					<option value="2">Gira</option>
					<option value="3" selected="selected">Festival</option>';
				break;
			}
			print' </select></p>';
			
			print '<p class="contingut">Numero de conciertos de la gira (1 si es concierto único) :
			<select name="num_concerts">';
			for ($i=1;$i<=20;$i++) {
				if ($this->formulari_1_ok) {
					$contingut_camp=$this->num_concerts;
				} else {
					$contingut_camp=$this->dades->num_concerts;
				}

				if ($contingut_camp==$i) {
					print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

				} else {
					print '<option value="'.$i.'">'.$i.'</option>';
				}			
			}
			print' </select></p>';
			
			print '<p class="contingut">Numero de máximo de bandas en un concierto :
			<select name="num_bandes">';
			for ($i=1;$i<=40;$i++) {
				if ($this->formulari_1_ok) {
					$contingut_camp=$this->num_bandes;
				} else {
					$contingut_camp=$this->dades->num_bandes;
				}
				
				if ($contingut_camp==$i) {
					print '<option selected="selected" value="'.$i.'">'.$i.'</option>';

				} else {
					print '<option value="'.$i.'">'.$i.'</option>';
				}			
			}
			print' </select></p>';
					
			if ($this->formulari_1_ok) {
				$contingut_camp='';
			} else {
				$contingut_camp=$this->dades->titol;
			}
			print '<p class="contingut">Nombre Concierto / Gira / Festival :<br /><br /><input class="titol_form"  type="text" name="titol" maxlength="256" value="'.$contingut_camp.'" /></p>';
			
			/*if ($this->formulari_1_ok) {
				$contingut_camp='';
			} else {
				$contingut_camp=$this->dades->cartell;
				
				
			}*/
			print '<p class="contingut">Cartel del concierto / Festival / Gira (si es gira y hay un cartel por concierto, dejar en blanco) :<br />';
            /*print '<input class="imgs_form" type="text" name="cartell_generic" maxlength="200" value="'.$contingut_camp.'" /></p>';*/
            print '<input type="hidden" name="MAX_FILE_SIZE" value="1000000" />';
			
            if ($this->formulari_1_ok)
            {
                print '<input type="file" name="cartell_generic" id="cartell_generic"/><br />';
			} else {
			    if ($this->dades->cartell!='')
                {
                    print '<img src="../pics/conc/'.$this->dades->cartell.'" width="100" /><br />';
                    print '<input type="hidden" name="cartell_pujat" value="'.$this->dades->cartell.'" />';
                    print '<input type="file" name="cartell_generic" id="cartell_generic"/><br />';
                } else {
                    print '<input type="file" name="cartell_generic" id="cartell_generic"/><br />';
                }
			}

            
            
                    					
			if ($this->formulari_1_ok) {
				$contingut_camp='';
			} else {
				$contingut_camp=$this->dades->texte;
				
			}
			print '<p class="contingut">Texto<br /><br />
			<textarea class="texte_form" name="texte">'.$contingut_camp.'</textarea>';
            print '</p>';
			
            
            		
			for ($i=1;$i<=$this->num_concerts;$i++) /* Genera x concerts */
			{
				$nom='concert'.$i;
				print '<p class="contingut">Concert '.$i.'</p><hr />';
				 
				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					$contingut_camp=$this->dades->$nom->cartell_concert;	
				}
				print '<p class="contingut">Cartel del concierto (si lo hay) : <input class="imgs_form" type="text" name="cartell_concert_'.$i.'" maxlength="200" value="'.$contingut_camp.'" /></p>';
				
				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					$contingut_camp=$this->dades->$nom->sala;	
				}
				print '<p class="contingut">Sala : <input class="imgs_form" type="text" name="sala_'.$i.'" maxlength="100" value="'.$contingut_camp.'" /></p>';
				
				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					$contingut_camp=$this->dades->$nom->localitat;	
				}
				print '<p class="contingut">Localidad : <input class="imgs_form" type="text" name="localitat_'.$i.'" maxlength="100" value="'.$contingut_camp.'" /></p>';

				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					$contingut_camp=$this->dades->$nom->link;	
				}
				print '<p class="contingut">Link de evento de Facebook (si lo hay) : <input class="imgs_form" type="text" name="link_'.$i.'" maxlength="200" value="'.$contingut_camp.'" /></p>';
				
				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					$contingut_camp=$this->dades->$nom->preu;	
				}
				print '<p class="contingut">Precio : <input class="imgs_form" type="text" name="preu_'.$i.'" maxlength="100" value="'.$contingut_camp.'" /></p>';
				
				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					$contingut_camp=$this->dades->$nom->preu_ant;	
				}
				print '<p class="contingut">Precio anticipado : <input class="imgs_form" type="text" name="preu_ant_'.$i.'" maxlength="100" value="'.$contingut_camp.'" /></p>';
				if ($this->formulari_1_ok) {
					$contingut_camp='';
				} else {
					if ($this->dades->$nom->patrocinat=='1') {
						$contingut_camp='checked="checked"';
					} else {
						$contingut_camp='';
					}
				}
				print '<p class="contingut"><input type="checkbox" name="patrocinat_'.$i.'" '.$contingut_camp.' />Concierto patrocinado (banner lateral)</p>';
			
				print '<p class="contingut">Fecha y hora de apertura de puertas: ';

				
			
			
			
				if ($this->formulari_1_ok) {
					$contingut_camp='01';
				}else {
					$contingut_camp=$this->dades->$nom->dia;
				}
				print 'Día <select name="dia_'.$i.'">';

				for ($y=1;$y<=31;$y++) {
					if ($y<10)
					{
						 $yx='0'.$y;
					} else {
						$yx=$y;
					}
					if ($contingut_camp==$yx) {
						print '<option selected="selected" value="'.$yx.'">'.$yx.'</option>';
					} else {
						print '<option value="'.$yx.'">'.$yx.'</option>';
					}
				}
				print '</select>';
						
				print 'Mes <select name="mes_'.$i.'">';
				if ($this->formulari_1_ok) {
					$contingut_camp='01';
				}else {
					$contingut_camp=$this->dades->$nom->mes;
				}

				for ($y=1;$y<=12;$y++) {
					
					if ($y<10)
					{
						 $yx='0'.$y;
					} else {
						$yx=$y;
					}
					if ($contingut_camp==$yx) {
						print '<option selected="selected" value="'.$yx.'">'.$yx.'</option>';
	
					} else {
						print '<option value="'.$yx.'">'.$yx.'</option>';
					}
				}
				
				print'</select>';
						
				print 'Año <select name="any_'.$i.'">';
				if ($this->formulari_1_ok) {
					$contingut_camp=2023;
				}else {
					$contingut_camp=$this->dades->$nom->any;
				}
						
				for ($y=2023;$y<=2024;$y++) {
					if ($contingut_camp==$y) {
						print '<option selected="selected" value="'.$y.'">'.$y.'</option>';
	
					} else {
						print '<option value="'.$y.'">'.$y.'</option>';
					}
				}
				print'</select>';
						
				print ' Hora <select name="hora_'.$i.'">';
				if ($this->formulari_1_ok) {
					$contingut_camp='20';
				}else {
					$contingut_camp=$this->dades->$nom->hora;
				}
	
				for ($y=0;$y<=23;$y++) {
					
					if ($y<10)
					{
						 $yx='0'.$y;
					} else {
						$yx=$y;
					}
					if ($contingut_camp==$yx) {
						print '<option selected="selected" value="'.$yx.'">'.$yx.'</option>';
	
					} else {
						print '<option value="'.$yx.'">'.$yx.'</option>';
					}
				}
				print'</select>:
				<select name="mins_'.$i.'">';
				if ($this->formulari_1_ok) {
					$contingut_camp='00';
				}else {
					$contingut_camp=$this->dades->$nom->mins;
				}

				for ($y=0;$y<=59;$y=$y+5) {
					
					if ($y<10)
					{
						 $yx='0'.$y;
					} else {
						$yx=$y;
					}
					if ($contingut_camp==$yx) {
						print '<option selected="selected" value="'.$yx.'">'.$yx.'</option>';
	
					} else {
						print '<option value="'.$yx.'">'.$yx.'</option>';
					}
				}
				print'</select><br /><br /><br />';
				for ($y=1;$y<=$this->num_bandes;$y++)
				{
					$nom2='banda'.$y;
					print '<p class="contingut" >Banda '.($y).' :';
					if ($this->formulari_1_ok) {
						$contingut_camp='';
					}else {
						$contingut_camp=$this->dades->$nom->$nom2->nom;
					}
					print ' Nombre <input class="imgs_form" type="text" name="banda_'.$i.'_'.$y.'" maxlength="200" value="'.$contingut_camp.'" />';
					/*if ($this->formulari_1_ok) {
						$contingut_camp='';
					}else {
						$contingut_camp=$this->dades->$nom->$nom2->foto;
					}
					print ' Foto <input class="imgs_form" type="text" name="imatge_'.$i.'_'.$y.'" maxlength="200" value="'.$contingut_camp.'" />';*/
					if ($this->formulari_1_ok) {
						$contingut_camp='';
					}else {
						$contingut_camp=$this->dades->$nom->$nom2->video;
					}
					print ' Video <input class="imgs_form" type="text" name="video_'.$i.'_'.$y.'" maxlength="200" value="'.$contingut_camp.'" /><br /><br />';
					}

					print '</p>';
			}
			
			
			
			if ($this->formulari_1_ok) {
				$contingut_camp='';
			}else {
				$contingut_camp=$this->dades->descripcio;
			}
			print '<p class="contingut">Etiquetas, separadas por comas<br /><br /><input class="titol_form" type="text" name="descripcio" maxlength="200" value="'.$contingut_camp.'" /></p>';
			print "<input type=\"submit"; 
			print "\" value=\"";
			
			print 'Enviar';
			
			print "\" /></fieldset>";
			
			print "</form>\n";

		}
				

		public function consulta_concerts($basedades,$desde,$quantitat)
		/* consulta concerts a la bbdd a partir del numero d'inici de la consulta per data de concert i la quantitat a mostrar */
		{
			/* Demanar dades a bbdd ordenat per data, desde $desde fins a $desde+$quantitat */
			$inici=$desde-1;
			
			/* Recupera les 10 primeres ID */
			$query= "select idGig from concertsdata order by dateConcert desc limit ".$inici.", ".$quantitat." ";
			$this->resultat_consulta=$basedades->query($query);
			if ($this->resultat_consulta==FALSE) 
			{
				print '<p class="terminal">Error al extraer la id de los conciertos a mostrar.</p>';	
			} else {

				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->numero_resultats == 0) 
				{
					print '<p class="terminal">No hay resultados que mostrar</p>';
					/* Hi ha hagut resultats. Busca les coincidencies per ID-IDIOMA */
					
				}
			}

		}
		
		public function extreu_dades_concert_per_id($bd,$id)
		/* Extreu dades d'un concert a partir d'una id  */
		{
			$query= "select tipus, Nom, texte, cartell, dateIn, descripcio, num_concerts, num_bandes from concerts where idGig = ".$id;
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta==FALSE) 
			{ 
				print '<p class="terminal">Error al extraer los datos para editar</p>'; 			 
			} else {
				$resultat=$this->resultat_consulta->fetch_assoc();
				$this->num_concerts=$resultat['num_concerts'];
				$this->num_bandes=$resultat['num_bandes'];
				$this->dades= new entrada_concerts($this->num_concerts, $this->num_bandes);
				$this->dades->id=$id;
				$this->dades->titol=$resultat['Nom'];
				$this->dades->cartell=$resultat['cartell'];
				$this->dades->texte=$resultat['texte'];
				$this->dades->dateIn=$resultat['dateIn'];
				$this->dades->descripcio=$resultat['descripcio'];
				$this->dades->num_concerts=$this->num_concerts;
				$this->dades->num_bandes=$this->num_bandes;
				$this->dades->tipus=$resultat['tipus'];
				
				/* Dades genériques extretes, torn del bucle de concerts */
				
				$query="select idGig, idConcert, cartell_concert, dateConcert, sala, localitat, preu, link, preu_ant, patrocinat, dateIn from concertsdata where idGig = ".$id." order by idConcert asc";
				$this->resultat_consulta=$bd->query($query);
				if ($this->resultat_consulta==FALSE) {
					print '<p class="terminal">Error al extraer los datos para editar (conciertos)</p>';
				} else {
					$concs=$this->resultat_consulta->num_rows;
					for ($i=0;$i<$concs;$i++)
					{
						$resultat=$this->resultat_consulta->fetch_assoc();
						$nom='concert'.($i+1);
						$this->dades->$nom->id_concert=$resultat['idConcert'];
						$this->dades->$nom->idGig=$resultat['idGig'];
						$this->dades->$nom->link=$resultat['link'];
						$this->dades->$nom->cartell_concert=$resultat['cartell_concert'];
						$this->dades->$nom->dateConcert=$resultat['dateConcert'];
						$this->dades->$nom->sala=$resultat['sala'];
						$this->dades->$nom->localitat=$resultat['localitat'];
						$this->dades->$nom->preu=$resultat['preu'];
						$this->dades->$nom->preu_ant=$resultat['preu_ant'];
						$this->dades->$nom->patrocinat=$resultat['patrocinat'];
						$this->dades->$nom->data=$resultat['dateConcert'];
						$array_data=$this->timestamp_a_taula($this->dades->$nom->dateConcert);
						$this->dades->$nom->dia=$array_data['dia'];
						$this->dades->$nom->mes=$array_data['mes'];
						$this->dades->$nom->any=$array_data['any'];
						$this->dades->$nom->hora=$array_data['hora'];
						$this->dades->$nom->mins=$array_data['min'];
						
						
						$query="select idConcert, ordre, Grup, Video from concertsgrups where idConcert= '".$this->dades->$nom->id_concert."' order by ordre asc";
						$this->resultat_consulta2=$bd->query($query);
						if ($this->resultat_consulta2==FALSE) {
							print '<p class="terminal">Error al extraer los datos para editar (grupos)</p>';
						} else {
						$bandes=$this->resultat_consulta2->num_rows;
							for ($y=0;$y<$bandes;$y++)
							{
								$resultat2=$this->resultat_consulta2->fetch_assoc();
								$nom2='banda'.($y+1);
								$this->dades->$nom->$nom2->nom=$resultat2['Grup'];
								$this->dades->$nom->$nom2->video=$resultat2['Video'];
								$this->dades->$nom->$nom2->ordre=$resultat2['ordre'];
								$this->dades->$nom->$nom2->id_concert=$resultat2['idConcert'];
							}
						}
					}
				}
				
			}
			/*print '<p class="contingut">';
			print 'Tipo: '.$this->dades->tipus.'<br />';
			print 'Título: '.$this->dades->titol.'<br />';
			print 'Texte: '.$this->dades->texte.'<br />';
			print 'Cartell: '.$this->dades->cartell.'<br />';
			print 'DateIn: '.$this->dades->dateIn.'<br />';
			for ($i=1;$i<=$this->num_concerts;$i++)
			{
				$nom='concert'.$i;
				print '<br />Concert '.$i.'<br /><br />';
				print 'Cartell concert: '.$this->dades->$nom->cartell_concert.'<br />';
				print 'Sala: '.$this->dades->$nom->sala.'<br />';
				print 'Localitat: '.$this->dades->$nom->localitat.'<br />';
				print 'Preu: '.$this->dades->$nom->preu.'<br />';
				print 'Preu anticipat: '.$this->dades->$nom->preu_ant.'<br />';
				print 'Dia: '.$this->dades->$nom->dia.'<br />';
				print 'Mes: '.$this->dades->$nom->mes.'<br />';
				print 'Any: '.$this->dades->$nom->any.'<br />';
				print 'Hora: '.$this->dades->$nom->hora.'<br />';
				print 'Min: '.$this->dades->$nom->mins.'<br />';
				print 'Timestamp: '.$this->dades->$nom->data.'<br />';
				print 'Patrocinat: '.$this->dades->$nom->patrocinat.'<br />';
				
				for ($y=1;$y<=$this->num_bandes;$y++)
				{
					$nom2='banda'.$y;
					print '<br />Banda '.$y.'<br /><br />';
					print 'Banda: '.$this->dades->$nom->$nom2->nom.'<br />';
					print 'Foto: '.$this->dades->$nom->$nom2->foto.'<br />';
					print 'Codi video: '.$this->dades->$nom->$nom2->video.'<br />';
					print 'Ordre: '.$this->dades->$nom->$nom2->ordre.'<br />';
					
				}
			}
			print '<br /><br />Paraules clau : '.$this->dades->descripcio;
			print '</p>';*/

		}
		
		
		
		public function eliminar_registre($bd,$id)
		{
			$query="delete from concerts where idGig = '".$id."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Delete de concerts OK</p>';
			} else {
				print '<p class="terminal">Delete de concerts fallido</p>';
			}
			$query="delete from concertsdata where idGig = '".$id."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Delete de concertsdata OK</p>';
			} else {
				print '<p class="terminal">Delete de concertsdata fallido</p>';
			}
			$query="delete from concertsgrups where idGig = '".$id."'";
			$this->resultat_consulta=$bd->query($query);
			if ($this->resultat_consulta) {
				print '<p class="terminal">Delete de concertsgrups OK</p>';
			} else {
				print '<p class="terminal">Delete de concertsgrups fallido</p>';
			}
			
		}
		public function presentar_concerts_formulari($bd,$tasca,$inici,$quantitat) 
		/* tenint l'objecte de la consulta les posa a pantalla */
		{
			$query= "select concerts.tipus, concerts.Nom, concerts.idGig, concerts.dateIn, concerts.cartell, concertsdata.dateConcert, concertsdata.cartell_concert, concertsdata.idConcert, concertsdata.sala, concertsdata.localitat from concerts, concertsdata where concertsdata.idGig = concerts.idGig order by concertsdata.dateConcert asc limit ".($inici-1).", ".$quantitat;				
			$this->mini_dades=new mini_concert;
			$this->resultat_consulta=$bd->query($query);
			if (!$this->resultat_consulta==FALSE) {
				$this->numero_resultats=$this->resultat_consulta->num_rows;
				if ($this->resultat_consulta->num_rows==0) {
					print '<p class="terminal">No hay resultados para mostrar.</p>';
				} else {
					for ($y=0;$y<($this->numero_resultats);$y++)
					{		
						
						$row=$this->resultat_consulta->fetch_assoc();
						$this->mini_dades->titol=$row['Nom'];
						$this->mini_dades->tipus=$row['tipus'];
						$this->mini_dades->dateIn=$row['dateIn'];
						$this->mini_dades->data=$row['dateConcert'];
						$this->mini_dades->cartell=$row['cartell'];
						$this->mini_dades->cartell_concert=$row['cartell_concert'];
						$this->mini_dades->id=$row['idGig'];
						$this->mini_dades->id_concert=$row['idConcert'];
						$this->mini_dades->sala=$row['sala'];
						$this->mini_dades->localitat=$row['localitat'];
						$this->mini_dades->array_data=$this->timestamp_a_taula($this->mini_dades->data);
						$this->mini_dades->array_dateIn=$this->timestamp_a_taula($this->mini_dades->dateIn);
						print '<div class="noticia_curta">';						
						switch ($tasca) 
						{
							case ('editar'):
								
								print "<form action=\"home_cp.php?sec=conciertos&action=edit&tasca=edit&id=".$this->mini_dades->id."&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$this->mini_dades->id.' - Id Concierto: '.$this->mini_dades->id_concert.' - Fecha: '.$this->mini_dades->array_data['dia'].' / '.$this->mini_dades->array_data['mes'].' / '.$this->mini_dades->array_data['any'].' Hora: '.$this->mini_dades->array_data['hora'].':'.$this->mini_dades->array_data['min'].'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Editar';
							
								print "\" />";						
								switch ($this->mini_dades->tipus) {
									case '1':
										$nom='Concierto';
									break;
									case '2':
										$nom='Gira';
									break;
									case 3:
										$nom='Festival';
									break;
								}
								
								print "<div class=\"concert_cp\">";
								if ($this->mini_dades->cartell_concert=='')
								{
									$cartell=$this->mini_dades->cartell;
								} else {
									$cartell=$this->mini_dades->cartell_concert;
								}
								print "<img src=\"../pics/conc/$cartell\" height=\"200\" />
										<p class=\"titol\">Tipo: $nom</p><br/>
										<p class=\"titol\">Titulo: ".$this->mini_dades->titol."</p><br />
										<p class=\"titol\">Fecha: ".$this->mini_dades->array_data['dia']."/".$this->mini_dades->array_data['mes']."/".$this->mini_dades->array_data['any']." ".$this->mini_dades->array_data['hora'].":".$this->mini_dades->array_data['min']."</p><br />
										<p class=\"titol\">Sala: ".$this->mini_dades->sala."</p><br />
										<p class=\"titol\">Localidad: ".$this->mini_dades->localitat."</p><br />";
								print "</fieldset>";
							
								print "</form></div>";
							break;
							case ('del'):

								print "<form action=\"home_cp.php?sec=conciertos&action=del&tasca=del&id=".$this->mini_dades->id."&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print '<fieldset><legend class="white">Id: '.$this->mini_dades->id.' - Id Concierto: '.$this->mini_dades->id_concert.' - Fecha: '.$this->mini_dades->array_data['dia'].' / '.$this->mini_dades->array_data['mes'].' / '.$this->mini_dades->array_data['any'].' Hora: '.$this->mini_dades->array_data['hora'].':'.$this->mini_dades->array_data['min'].'</legend>';
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Eliminar';
							
								print "\" />";						
								switch ($this->mini_dades->tipus) {
									case '1':
										$nom='Concierto';
									break;
									case '2':
										$nom='Gira';
									break;
									case 3:
										$nom='Festival';
									break;
								}
								
								print "<div class=\"concert_cp\">";
								if ($this->mini_dades->cartell_concert=='')
								{
									$cartell=$this->mini_dades->cartell;
								} else {
									$cartell=$this->mini_dades->cartell_concert;
								}
								print "<img src=\"../pics/conc/$cartell\" height=\"200\" />
										<p class=\"titol\">Tipo: $nom</p><br/>
										<p class=\"titol\">Titulo: ".$this->mini_dades->titol."</p><br />
										<p class=\"titol\">Fecha: ".$this->mini_dades->array_data['dia']."/".$this->mini_dades->array_data['mes']."/".$this->mini_dades->array_data['any']." ".$this->mini_dades->array_data['hora'].":".$this->mini_dades->array_data['min']."</p><br />
										<p class=\"titol\">Sala: ".$this->mini_dades->sala."</p><br />
										<p class=\"titol\">Localidad: ".$this->mini_dades->localitat."</p><br />";
								print "</fieldset>";
							
								print "</form></div>";							

							break;
							case ('edit_del'):
								print '<fieldset><legend class="white">Id: '.$this->mini_dades->id.' - Id Concierto: '.$this->mini_dades->id_concert.' - Fecha: '.$this->mini_dades->array_data['dia'].' / '.$this->mini_dades->array_data['mes'].' / '.$this->mini_dades->array_data['any'].' Hora: '.$this->mini_dades->array_data['hora'].':'.$this->mini_dades->array_data['min'].'</legend>';
								print "<form action=\"home_cp.php?sec=conciertos&action=edit&tasca=edit&id=".$this->mini_dades->id."&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";								
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Editar';
							
								print "\" /></form>";
								print "<form action=\"home_cp.php?sec=conciertos&action=del&tasca=del&id=".$this->mini_dades->id."&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n
									<p class=\"form_data\">";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Eliminar';
							
								print "\" /></form>";						
								switch ($this->mini_dades->tipus) {
									case '1':
										$nom='Concierto';
									break;
									case '2':
										$nom='Gira';
									break;
									case 3:
										$nom='Festival';
									break;
								}
								
								print "<div class=\"concert_cp\">";
								if ($this->mini_dades->cartell_concert=='')
								{
									$cartell=$this->mini_dades->cartell;
								} else {
									$cartell=$this->mini_dades->cartell_concert;
								}
								print "<img src=\"../pics/conc/$cartell\" height=\"200\" />
										<p class=\"titol\">Tipo: $nom</p><br/>
										<p class=\"titol\">Titulo: ".$this->mini_dades->titol."</p><br />
										<p class=\"titol\">Fecha: ".$this->mini_dades->array_data['dia']."/".$this->mini_dades->array_data['mes']."/".$this->mini_dades->array_data['any']." ".$this->mini_dades->array_data['hora'].":".$this->mini_dades->array_data['min']."</p><br />
										<p class=\"titol\">Sala: ".$this->mini_dades->sala."</p><br />
										<p class=\"titol\">Localidad: ".$this->mini_dades->localitat."</p><br />";
								print "</fieldset>";
							
								print "</div>";			
								/*print '<div class="noticia_curta">';
								print '<fieldset><legend class="white">Id: '.$this->id.' - Fecha: '.$this->dia.' / '.$this->mes.' / '.$this->any.' Hora: '.$this->hora.':'.$this->mins.'</legend>';
								print "<form action=\"home_cp.php?sec=noticias&action=edit&tasca=edit&id=$this->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";					
								print 'Editar';
								print "\" /></form>";
								print "<form action=\"home_cp.php?sec=noticias&action=del&tasca=del&id=$this->id&formulari=TRUE\" method=\"post\">";
								print "<input type=\"hidden\" name=\"enviat_edit\" value=\"si\" \>\n";
								print "<input class=\"esq\" type=\"submit"; 
								print "\" value=\"";
								print 'Eliminar';
								print "\" /></form>";
	
								switch ($this->tipus) {
									case '1':
										$nom='Noticia';
									break;
									case '2':
										$nom='Video';
									break;
								}
								switch ($this->idioma)
								{
									case 'ES':
										print "<p class=\"titol\">Idioma: $this->idioma</p>
										<p class=\"titol\">Tipo: $nom</p><br/>
										<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
										<p class=\"texte\">Texto ES: $this->texte_es</p>\n";
									break;
									case 'CAT':
										print "<p class=\"titol\">Idioma: $this->idioma</p>
										<p class=\"titol\">Tipo: $nom</p><br />
										<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
										<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
									break;							
									case 'BOTH':
										print "<p class=\"titol\">Idioma: $this->idioma</p>
										<p class=\"titol\">Tipo: $nom</p><br />
										<p class=\"titol\">Titulo ES: $this->titol_es</p><br />
										<p class=\"texte\">Texto ES: $this->texte_es</p><br /><br />\n
										<p class=\"titol\">Titulo CAT: $this->titol_cat</p><br />
										<p class=\"texte\">Texto CAT: $this->texte_cat</p>\n";
									break;				
								}
								print "</div>";*/
		
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
                <a class="linkk" href="home_cp.php?sec=conciertos&action=edit&punter=1"><img class="ico_navegador" src="../pics/containers/max_prev.jpg" width="43" height="43" /></a>
<?php
				}
				if ($punter!=1) {
						$punter_dir=$punter-10;
					print '<a class="linkk" href="home_cp.php?sec=conciertos&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/prev.jpg" width="43" height="43" /></a>';
				}

                if ($numero>=($punter+10)) {
						$punter_dir=$punter+10;
					print '<a class="linkk" href="home_cp.php?sec=conciertos&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/next.jpg" width="43" height="43" /></a>';
				}                
                if ($numero>=($punter+10)) {
					$punter_dir=((number_format(($numero/$quantitat), 0)*$quantitat)+1)-10;
					print '<a class="linkk" href="home_cp.php?sec=conciertos&action='.$action.'&punter='.$punter_dir.'"><img class="ico_navegador" src="../pics/containers/max_next.jpg" width="43" height="43" /></a>';
				}
?>
            </div>    
<?php
		}

		public function timestamp_actual ()
		{
			//$time=date('YmdHis');Y-m-d H:i:s
			$time=date('Y-m-d H:i:s');
			return ($time);
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
		public function convertir_cadena_arxiu($cadena)
		{
			$cadena=strtolower($cadena);
			$cadena=str_replace('á','a',$cadena);
			$cadena=str_replace('à','a',$cadena);
			$cadena=str_replace('ä','a',$cadena);
			$cadena=str_replace('â','a',$cadena);
			$cadena=str_replace('é','e',$cadena);
			$cadena=str_replace('è','e',$cadena);
			$cadena=str_replace('ë','e',$cadena);
			$cadena=str_replace('ê','e',$cadena);
			$cadena=str_replace('í','i',$cadena);
			$cadena=str_replace('ì','i',$cadena);
			$cadena=str_replace('ï','i',$cadena);
			$cadena=str_replace('î','i',$cadena);
			$cadena=str_replace('ó','o',$cadena);
			$cadena=str_replace('ò','o',$cadena);
			$cadena=str_replace('ö','o',$cadena);
			$cadena=str_replace('ô','o',$cadena);
			$cadena=str_replace('ú','u',$cadena);
			$cadena=str_replace('ù','u',$cadena);
			$cadena=str_replace('ü','u',$cadena);
			$cadena=str_replace('û','u',$cadena);
			$cadena=str_replace('ñ','n',$cadena);
			$cadena=str_replace('-','',$cadena);
			$cadena=str_replace("'",'',$cadena);
			$cadena=str_replace('.','',$cadena);
			$cadena=str_replace(',','',$cadena);
			$cadena=str_replace(' ','',$cadena);
			$cadena=str_replace('ç','c',$cadena);
			$cadena=str_replace('?','',$cadena);
			$cadena=str_replace('¡','',$cadena);
			$cadena=str_replace('!','',$cadena);
			$cadena=str_replace('¿','',$cadena);
			return $cadena;
			
		}
		

	}
?>