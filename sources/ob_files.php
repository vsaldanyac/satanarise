<?php

class ob_files {
	public $noticies; //Matriu de totes les noticies en cadena
	public $num_noticies; // total de noticies
	public $next_min;
	public $next_max;
	public $prev_max;
	public $prev_min;
	public $noticia_extended; // Noticias en array detalladas

	
	public function capturar_fitxer($fitxer) {
		$file=file_get_contents($fitxer);
		$this->noticies=explode("\r\n",$file);
		$this->num_noticies=(count($this->noticies));
	}
	
	public function mostrar_noticies($fitxer,$min,$max,$leng) {
		print $this->num_noticies;
		if ((file_exists($fitxer))) {
			
			$this->capturar_fitxer($fitxer);
			if ($this->num_noticies<($max-$min)){
				$final=$this->num_noticies;
				$inici=1;
			} else {
				$inici=$min;
				$final=$max;
				if ($this->num_noticies<$final) { $final = $this->num_noticies; } 	
			}
			
			for ($x=($inici-1);$x<$final;$x++) {
			$not=explode("\t",$this->noticies[$x]);
			if ($leng=='ES') {
				$titulo=$not[2];
				$contenido=$not[3];
			} else {
				$titulo=$not[4];
				$contenido=$not[5];
			}
			print "<div class=\"new\">\n<div class=\"new_top\">\n<div class=\"date\">\n<p>$not[1]</p>\n</div>\n
				   <div class=\"line\"><hr color=\"#666666\" size=\"1\" width=\"400\" />\n</div>\n
				   </div>\n<div class=\"title\">\n<h1>$titulo</h1>\n</div>\n<div class=\"text\">\n
				   <p>$contenido</p>";
			$control=FALSE;
			if (file_exists('pics/news/'.$not[0].'.jpg')) {
				$pic='pics/news/'.$not[0].'.jpg';
				$control=TRUE;
			} elseif (file_exists('pics/news/'.$not[0].'.gif')) {
				$pic='pics/news/'.$not[0].'.gif';
				$control=TRUE;
			} elseif (file_exists('pics/news/'.$not[0].'.png')) {
				$pic='pics/news/'.$not[0].'.png';
				$control=TRUE;
			} 
				
			if ($control) {
				if ($leng='ES') {
					print '<img src="'.$pic.'" alt="'.$not[2].'" />';
				} else {
					print '<img src="'.$pic.'" alt="'.$not[4].'" />';
				}
			}			print "\n</div>\n</div>\n";
			}
		} else {
			if ($leng == 'ES') {
				print' <p class="error"> Lo sentimos, no hay noticias para mostrar </p>';
				$prev_msg='Noticias posteriores';
				$next_msg='Noticias anteriores';
			} else {
				print' <p class="error"> Sorry, no news to show.</p>';
				$prev_msg='Previous news';
				$next_msg='Old news';
			}
		} 
		$this->indices($min,$max);
		print "\n<div class=\"news_bottom_l\">";
		if ($this->prev_min != 0) {
			print "<a class=\"lend\" href=\"index.php?id=$page->leng&sec=inicio&nw_strt=$news->prev_min&nw_nd=$news->prev_max\">$prev_msg</a>";
		}
		print "</div>\n";
		print "\n<div class=\"news_bottom_r\">";
		if ($this->next_min != 0) {
			print "<a class=\"lend\" href=\"index.php?id=$page->leng&sec=inicio&nw_strt=$news->next_min&nw_nd=$news->next_max\">$next_msg</a>";
		}
		print "</div>\n";	
			
	}
	
	public function indices($min,$max) {
		if (($min == 1) && ($max>=$this->num_noticies)) {
			$this->prev_min=0;
			$this->next_min=0;
			
		} elseif (($min > 20) && ($max>=$this->num_noticies)) {
			$this->next_min=0;
			$this->prev_max=$min-1;
			$this->prev_min=$min-20;

		} elseif (($min == 1) && ($max<$this->num_noticies)) {
			$this->next_min=$max+1;
			$this->next_max=$max+20;
			$this->prev_min=0;
		} else {
			$this->next_min=$max+1;
			$this->next_max=$max+20;
			$this->prev_min=$min-20;
			$this->prev_max=$max-1;			

		}
	}
	

}
class ob_admin_page extends ob_files {
		
		public $seccio;
		public $accio;
		public $noticia;
		public $msg_error;
		public $id;
		public $imagen;
		
	
	
		public function capturar_parametres($param) {
			if (isset($param['sec'])) {
				if (($param['sec'] == 'not') || ($param['sec'] == 'conc')) {
					$this->seccio=$param['sec'];
				} else {
					$this->seccio='no';
				}
			} else {
				$this->seccio='no';
			}
			if ($this->seccio!='no') {
				if (isset($param['action'])) {
					$this->accio=$param['action'];
					if (($this->accio != 'add') && ($this->accio != 'del') && ($this->accio!='edit') && ($this->accio!='file')) {
						$this->seccio='no';
					} 
				} else {
					$this->seccio='no';
				}
			}
		}
		
		public function formulario_error($post) {
				$this->msg_error="";
				$error=TRUE;
				if (!(empty($post['titulo_es']))) {
					$this->noticia['titulo_es']=trim($post['titulo_es']);
				} else {
					$this->msg_error=$this->msg_error.'El titulo de la noticia en castellano no está introducido.<br />';
					$error=FALSE;
				}
				if (!(empty($post['contenido_es']))) {
					$this->noticia['contenido_es']=$this->lineas(trim($post['contenido_es']));
				} else {
					$this->msg_error=$this->msg_error.'El contenido de la noticia en castellano no está introducido.<br />';
					$error=FALSE;
				}
				if (!(empty($post['titulo_uk']))) {
					$this->noticia['titulo_uk']=trim($post['titulo_uk']);
				} else {
					$this->msg_error=$this->msg_error.'El titulo de la noticia en inglés no está introducido.<br />';
					$error=FALSE;
				}
				if (!(empty($post['contenido_uk']))) {
					$this->noticia['contenido_uk']=$this->lineas(trim($post['contenido_uk']));
				} else {
					$this->msg_error=$this->msg_error.'El contenido de la noticia en inglés no está introducido.<br />';
					$error=FALSE;
				}
					
				return ($error);

		}

		public function recoger_formulario_not($post) {
			$this->msg_error="";
			switch ($this->accio) {
				case 'add':
					if (isset($post['enviado'])) {
						$error=$this->formulario_error($post);
					} else {
						$error=FALSE;
					}
					if (!$error) {
						print "<p class=\"error\">$this->msg_error</p>";
					}
				break;
				case 'edit' :
					$this->id=$post['id'];
					if (isset($post['noticia_editada'])) {
						$error=$this->formulario_error($post);

					} else {
						$error=FALSE;
					}
					if (!$error) {
						print "<p class=\"error\">$this->msg_error</p>";	
					}
				break;

			}
			return($error);


		}
		
		public function lineas ($string) {
			$string=preg_replace("[\n|\r|\n\r]","<br />",$string);
			return($string);
		}
		
		public function add_noticia($fitxer) {
			if (file_exists($fitxer)) { $this->capturar_fitxer($fitxer); } else { $this->num_noticies=0; }
			for ($x=$this->num_noticies;$x>0;$x--) {
				$this->noticies[$x]=$this->noticies[$x-1];
			}
			if ($this->num_noticies!=0) {
				$temp=explode("\t",$this->noticies[1]);
				$this->noticia['id']=$temp[0]+1;
			} else {
				$this->noticia['id']=1;
			}
			$this->id=$this->noticia['id'];

			$hora=date('d/m/Y');
			$this->noticies[0]=$this->noticia['id']."\t".$hora."\t".$this->noticia['titulo_es']."\t".$this->noticia['contenido_es']."\t".$this->noticia['titulo_uk']."\t".$this->noticia['contenido_uk'];
			$this->num_noticies++;

			
			$cadena="";
			for ($x=0;$x<$this->num_noticies;$x++) {
				if ($x>0) { $cadena=$cadena."\r\n"; }
				$cadena=$cadena.$this->noticies[$x];
			}
			
			
			file_put_contents($fitxer, $cadena);
			
		}
		public function form_subir_imagen() {
			print $this->id;
			print "<form action=\"control_panel.php?sec=not&action=file\" method=\"post\" enctype=\"multipart/form-data\">\n
				<input name=\"archivo\" type=\"file\" size=\"35\" />\n
				<input name=\"enviar\" type=\"submit\" value=\"Upload File\" />\n
			    <input name=\"action\" type=\"hidden\" value=\"upload\" />\n
				<input name=\"id\" type=\"hidden\" value=\"".$this->id."\" />     
				</form>";
		}
		
		public function recoger_form_file($data) {
			if ($_POST["action"] == "upload") {
				$fupload = new Upload();
				$fupload->setPath("../web/pics/news");
				$fupload->setFile("archivo",$this->id);
				$fupload->save();
				echo $fupload->message;
			}
		}
		public function subir_imagen ($ob_archivo){
	
			$destino =  $ob_archivo->newpath.$ob_archivo->new_file;
			if (copy($ob_archivo->file_temp,$destino)) {
				$status = "Archivo subido: <b>".$archivo."</b>";
			} else {
				$status = "Error al subir el archivo";
			}
		}
		
		public function array_string_to_array_array($array_string) {
			/* passa de un array que conte cadenes separades amb tabs a array multisimensional */
			$array_array=array();
			for ($x=0;$x<count($array_string);$x++) {
			$array_array[$x]=explode("\t",$array_string[$x]);
			}
			return ($array_array);
			
		}
		
		public function mostrar_noticies_form ($archivo) {
			
			$this->capturar_fitxer('../data/not.dat');
			$this->noticia_extended=$this->array_string_to_array_array($this->noticies);
			
			// Creació del formulari
			
			           
            print "<form action=\"control_panel.php?sec=not&action=$this->accio\" method=\"post\">\n";
			switch ($this->accio) {
				case 'del':
					print 'Elije las entradas que desees eliminar.';
				break;
				case 'edit':
					print "Selecciona la entrada que quieres editar.<br /><br /><br />\n<select name=\"id\">";
					for ($x=0;$x<count($this->noticia_extended);$x++) {
						print "<option value=\"".$this->noticia_extended[$x][0]."\">".$this->noticia_extended[$x][1]." - ".$this->noticia_extended[$x][2]."</option>\n";
					}
					print "</select><br />\n<input type=\"hidden\" name=\"enviado\" value=\"TRUE\" />\n";
				break;

			}
			
			
            
            print "<button type=\"submit\" name=\"submit\">Enviar</button></form>\n<br /><a class=\"link\" href=\"control_panel.php\">Volver</a>";
            
					
			

					
		}
		public function formulari_noticies($tit_es,$not_es,$tit_uk,$not_uk) {
			
			switch ($this->accio) {
				case 'add':
					$msg='control_panel.php?sec=not&action=add';
				break;
					
				case 'edit':
					$msg='control_panel.php?sec=not&action=edit';
				break;
				
			}
			print	"<form action=\"$msg\" method=\"post\">\n<fieldset>\n<legend>Noticia en Castellano</legend>\n
                     <p class=\"form\">
                                Titulo noticia
                                </p>\n
                                <input class=\"forms\" type=\"text\" name=\"titulo_es\" value=\"$tit_es\" maxlength=\"200\" />\n
                                <p class=\"form\">
                                Contenido
                                </p>\n
                                <textarea class=\"texto\" name=\"contenido_es\">$not_es</textarea>\n
							</fieldset>\n
							<fieldset>\n
                            <legend>Noticia en Inglés</legend>\n                            
                                <p class=\"form\">
                                Titulo noticia
                                </p>\n
                                <input class=\"forms\" type=\"text\" name=\"titulo_uk\" value=\"$tit_uk\" maxlength=\"200\" />\n
                                <p class=\"form\">
                                Contenido
                                </p>\n
                                <textarea class=\"texto\" name=\"contenido_uk\">$not_uk</textarea>\n
							</fieldset>\n";
							
			switch ($this->accio) {
				case 'add':
					print "<p class=\"form\">Indica si añadirás una foto a la noticia</p>\n
							<input type=\"radio\" name=\"archivo\" value=\"si\"><span class=\"blanc\">Si</span></input>\n
							<input type=\"radio\" name=\"archivo\" value=\"no\" checked=\"checked\"><span class=\"blanc\">No</span></input><br >\n";
					
				break;
			}
                            print "<input type=\"hidden\" name=\"enviado\" value=\"TRUE\" />\n";
			if ($this->accio == 'edit') { print "<input type=\"hidden\" name=\"id\" value=\"".$this->id."\" />\n<input type=\"hidden\" name=\"noticia_editada\" value=\"TRUE\" />\n"; }

                            
        	print "<button type=\"submit\" name=\"submit\">Enviar</button>\n</form>\n";
		}
		public function noticia_por_id ($id) {
			$this->capturar_fitxer('../data/not.dat');
			$this->noticia_extended=$this->array_string_to_array_array($this->noticies);
			for ($x=0;$x<count($this->noticia_extended);$x++) {
				if ($id==$this->noticia_extended[$x][0]) {
					$this->noticia=$this->noticia_extended[$x];
				}
			}
			
		}
		
		public function editar_entrada ($fichero){
			$this->capturar_fitxer($fichero);
			$this->noticia_extended=$this->array_string_to_array_array($this->noticies);
			for ($x=0;$x<count($this->noticia_extended);$x++) {
				if ($this->id == $this->noticia_extended[$x][0]) {
					$this->noticia_extended[$x][2]=$this->noticia['titulo_es'];
					$this->noticia_extended[$x][3]=$this->noticia['contenido_es'];
					$this->noticia_extended[$x][4]=$this->noticia['titulo_uk'];
					$this->noticia_extended[$x][5]=$this->noticia['contenido_uk'];															
				}
			}
			
			$cadena="";
			for ($x=0;$x<count($this->noticia_extended);$x++) {
				$cadena=$cadena.implode("\t",$this->noticia_extended[$x]);
				if ($x!=(count($this->noticia_extended))-1) {
					$cadena=$cadena."\r\n";
				}
			}
			file_put_contents($fichero, $cadena);
		}
	}
	
	class upload {
    var $maxsize = 0;
    var $message = "";
    var $newfile = "";
    var $newpath = "";
   
    var $file_size = 0;
    var $file_type = "";
    var $file_name = "";
    var $file_temp;
    var $file_exte;
   
    var $allowed;
    var $blocked;
    var $isimage;
    var $isupload;
   
    function Upload() {
        $this->allowed = array("image/bmp","image/gif","image/jpeg","image/pjpeg","image/png","image/x-png");
        $this->blocked = array("php","phtml","php3","php4","js","shtml","pl","py");
        $this->message = "";
        $this->isupload = false;
    }
    function setFile($field,$id) {
        $this->file_size = $_FILES[$field]['size'];
        $this->file_name = $_FILES[$field]['name'];
        $this->file_temp = $_FILES[$field]['tmp_name'];
        $this->file_type = filetype($this->file_temp);
        $this->file_exte = substr($this->file_name, strrpos($this->file_name, '.')+1);
       
        $this->newfile = $id.".".$this->file_exte;
    }
    function setPath($value) {
        $this->newpath = $value;
    }
    function setMaxSize($value) {
        $this->maxsize = $value;   
    }
    function isImage($value) {
        $this->isimage = $value;
    }
    function save() {
        if (is_uploaded_file($this->file_temp)) {
            // check if file valid
            if ($this->file_name == "") {
                $this->message = "No hay ningún archivo para subir.";
                $this->isupload = false;
                return false;
            }
            // check max size
            if ($this->maxsize != 0) {
                if ($this->filesize> $this->maxsize*1024) {
                    $this->message = "Imagen superior a 1 Mb";
                    $this->isupload = false;
                    return false;
                }
            }
            // check if image
            if ($this->isimage) {
                // check dimensions
                if (!getimagesize($this->file_temp)) {
                    $this->message = "No es una imagen.";
                    $this->isupload = false;
                    return false;   
                }
                // check content type
                if (!in_array($this->file_type, $this->allowed)) {
                    $this->message = "Archivo permitido.";
                    $this->isupload = false;
                    return false;
                }
            }
            // check if file is allowed
            if (in_array($this->file_exte, $this->blocked)) {
                $this->message = "Archivo no permitido - ".$this->file_exte;
                $this->isupload = false;
                return false;
            }
                   
            if (move_uploaded_file($this->file_temp, $this->newpath."/".$this->newfile)) {
                $this->message = "Imagen subida correctamente!";
                $this->isupload = true;
                return true;
            } else {
                $this->message = "Imagen no subida, intentar de nuevo";
                $this->isupload = false;
                return false;
            }
        } else {
            $this->message = "Imagen no subida, intentar de nuevo";
            $this->isupload = false;
            return false;
        }
    }   
}
?>