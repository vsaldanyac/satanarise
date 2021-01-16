<?php
	class ob_cp {
		public $leng; /* idioma ES o EN */
		public $first_top; /* codi de capçalera */
		public $css; /* array de css */
		public $scripts; /* array de scripts */
		public $section; /* seccio on estem */
		public $title; /* titol de la pagina */
		public $description; /* descripció de la plana */
		public $words; /* paraules claus */
		public $news_inici; /* variables de control de noticies al index */
		public $news_final;
		public $action; /* Acció a realitzar Add - Edit - Delete - Main */ 
		public $id; /* Id del contingut */	
		public $punter; /* punter de numero d'entrada de secció */
		public $num_a_mostrar; /* numero d'entrades a mostrar */
		public $formulari; /* si s'ha enviat un formulari a una secció boolean */
		public $tasca; /*variable k diu si edite marques un formulari si es per edició o per eliminació */




		public function print_metas()
		{
			print '<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />'."\n".'<meta http-equiv="Pragma" content="no-cache" />
<meta http-equiv="Cache-Control" content="no-cache, must-revalidate" />
<meta name="google-site-verification" content="3cpdckPZBddxzniOJ2ryh-yFVqQwxRmw4kuu2TuCaLc" />'."\n".'<meta property="og:title" content="Satan Arise" />
<meta property="og:type" content="website" />'."\n".'<meta property="og:url" content="http://www.satanarise.com" />'."\n".'<meta property="og:image" content="http://www.satanarise.com/pics/logo.gif" />
<meta property="og:site_name" content="http://www.satanarise.com/sitemap.xml" />'."\n".'<meta property="fb:admins" content="1577671298,1527691405" />
<meta name="description" content="Heavy Metal, críticas, entrevistas e información de todos los estilos de metal."  />
<meta name="keywords" content="Metal, reviews, críticas, entrevistas, noticias, power, viking, death, heavy, trash, black, gothic, gotico, pregresive, progresivo" />
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon" />'."\n";
		}	
		
		public  function __get($nom) /* crea parametres */
		{
			return $this->$nom;
		}
	
		public function __set($nom,$valor) /* asigna valors al parametre */
		{
			return $this->$nom = $valor;
		}
		
		public function __construct() /* inicialitza l'objecte */
		{
			$this->leng='ES';	
			$this->css = array('<link type="text/css" rel="stylesheet" media="all" href="../css/main_cp.css" />');
			$this->words = 'Metal, reviews, críticas, entrevistas, noticias, power, viking, death, heavy, trash, black, gothic, gotico, pregresive, progresivo';
			$this->punter=1;
			$this->num_a_mostrar=10;
			$this->formulari=FALSE;
			
		}
	
		public function print_heads()
		{
			$this->first_top = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//ES\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n";
			print $this->first_top;
			$this->print_metas();
			$this->print_css();
			$this->print_scripts();
			print '<title>'.$this->title.'</title>'."\n";
			
		}

		public function print_scripts() /* Imprimeix tots els scripts de $scripts */
		{
			if (isset($this->scripts)) {
				if (isset($this->scripts)) {
					$x=(count($this->scripts)-1);
					
					while ($x>=0) {
						print $this->scripts[$x]."\n";
						$x=$x-1;
					}
				}
			}
		}
	
		public function add_scripts($scripts)
		{
			$this->scripts[]=$scripts;
		}
		public function add_css($css)
		{
			$this->css[]=$css;
		}
		public function print_css() /* Imprimeix tots els css de $css */
		{
			$x=(count($this->css)-1);
			
			while ($x>=0) {
				print $this->css[$x]."\n";
				$x=$x-1;
			}
	
		}
		public function get_param($param)
		{
			
			
	/* control de seccio, si la seccio del parametre no existeix en funcio de l'idioma sera news o noticias */
			if (isset($param['sec'])) { 
				$this->section = $param['sec'];
			} else {
					$this->section = 'inicio';
			}
			
			if ((($this->section != 'inicio') && ($this->section != 'criticas') && ($this->section != 'noticias') && ($this->section != 'colaboradores') && ($this->section != 'conciertos') && ($this->section != 'cronicas') && ($this->section != 'entrevistas') && ($this->section != 'entrevistasn') && ($this->section != 'carta') && ($this->section != 'opinion') && ($this->section != 'logout') && ($this->section != 'usuarios'))) {
				$this->section = 'inicio';

			}
            if ($this->section=='logout')
			{
				
				ob_clean();
				unset ($_SESSION['valid_user']);
				session_destroy();
				header('Location: index_cp.php');
				exit();
				
			}			
			if ((($this->section == 'criticas') || ($this->section == 'noticias') || ($this->section == 'conciertos') || ($this->section == 'usuarios') || ($this->section == 'opinion') || ($this->section == 'carta') || ($this->section == 'colaboradores') || ($this->section == 'cronicas') || ($this->section == 'entrevistas') || ($this->section == 'entrevistasn'))) {
				if (isset($param['action'])) {
					$this->action=$param['action'];
					if (($this->action!='main') && ($this->action!='add') && ($this->action!='del') && ($this->action!='edit')) {
						if (($this->section!='conciertos') && ($this->action!='borrar_fora_de_data')) {
							$this->action='main';
						}
					}
				} else {
					$this->action='main';
				}
				
				if ((isset($param['formulari'])) && (($this->action=='add') || ($this->action=='del') || ($this->action=='edit'))) { 
					$this->formulari=$param['formulari'];
					if ($this->formulari) {
						if (isset($param['tasca'])) {
							$this->tasca=$param['tasca'];
							if (($this->tasca!='edit') && ($this->tasca!='del')) {
								$this->formulari=FALSE;
								
							}
						}
						if (isset($param['id'])) {
							$this->id=$param['id'];
						} else 
						{
							$this->formulari=FALSE;							
						}
					}

				}
				if (isset($param['punter'])) {
					 $this->punter=$param['punter'];
				}

				if (isset($param['num_a_mostrar'])) {
					 $this->num_a_mostrar=$param['num_a_mostrar'];
				}
				

			}

		}
		
		public function timestamp_actual ()
		{
			//$time=date('YmdHis');Y-m-d H:i:s
			$time=date('Y-m-d H:i:s');
			return ($time);
		}
		public function taula_a_timestamp($cadena) 
		{
			$data=$taula['any'].$taula['mes'].$taula['dia'].$taula['hora'].$taula['min'].'00';

			return $data;
		}
		
		public function timestamp_a_taula($data)
		{
			$data['any']=substr($data,0,4);
			$data['mes']=substr($data,4,2);
			$data['dia']=substr($data,6,2);
			$data['hora']=substr($data,8,2);
			$data['min']=substr($data,10,2);

			return $taula;
		}
		
	}
	


	
?>