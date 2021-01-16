<?php
	class banda 
	/* Informació d'una banda que toca a un concert */ 
	{
		public $id;
		public $nom;
		/*public $foto;*/
		public $video;
		public $ordre;
		public $id_concert; /* id k la vincula a un concert */
		
		public function __construct()
		{
			$this->nom='';
			/*$this->foto='';*/
			$this->video='';
			$this->ordre='';
			$this->id_concert='';
			$this->id='';
			
		}
	}
	class concert
	/* Onjecte que conté la informació d'una  data concert que pot pertanyer a un concert únic, gira o festival */
	{
		public $cartell_concert; 
		public $id_concert; 
		public $localitat;
		public $sala;
		public $preu;
		public $preu_ant;
		public $data; /* Timestamp */
		public $dia;
		public $mes;
		public $any;
		public $hora;
		public $mins;
		public $banda;
		public $patrocinat;
		public $link;
		public $id;
		public $grups;
		
		public function __construct($num_bandes)
		{
			$this->cartell_concert='';
			$this->link='';
			$this->id_content='';
			$this->sala='';
			$this->preu='';
			$this->preu_ant='';
			$this->data='';
			$this->id='';
			$this->localitat='';
			$this->patrocinat=0;
			$this->grups='';
			for ($i=1;$i<=$num_bandes;$i++) {
				$nom='banda'.$i;
				$this->$nom= new banda();
			}
			
		}

	}
	

	
	class entrada_concerts
	/* Informació genérica d'un concert únic */
	{
		public $cartell;
		public $titol;
		public $id;
		public $texte;
		public $dateIn; /* Timestamp */
		public $tipus; /* 1 concert 2 gira 3 festival */
		public $descripcio;
		public $num_concerts;
		public $num_bandes;

		
		
		public function __construct($num_concerts, $num_bandes)
		{
			$this->cartell='';
			$this->titol='';
			$this->id='';
			$this->texte='';
			$this->dateIn='';
			$this->tipus='';
			$this->descripcio='';
			$this->num_bandes=$num_bandes;
			$this->num_concerts=$num_concerts;
			for ($i=1;$i<=$num_concerts;$i++) {
				$nom='concert'.$i;
				$this->$nom= new concert($num_bandes);
			}

		}
	}
	class mini_concert
	{
		public $id;
		public $id_concert;
		public $cartell;
		public $cartell_concert;
		public $titol;
		public $dateIn;
		public $data;
		public $sala;
		public $localitat;
		public $tipus;
		public $array_data;
		public $array_dateIn;
		
		public function __construct()
		{
			$this->tipus=1;
			$this->id='';
			$this->id_concert='';
			$this->cartell='';
			$this->cartell_concert='';
			$this->dateIn='';
			$this->data='';
			$this->sala='';
			$this->localitat='';
			$this->array_data=array();
			$this->array_dateIn=array();
		}
		
		public function __set($name,$value)
		{
			$this->$name=$value;
		}
		public function __get($name)
		{
			return $this->$name;
		}
		
	}
	class concert_entrades {
		
		private $nom;
		private $id;
		private $id_concert;
		private $grups;
		private $data;
		private $dateConcert;
		private $dateIn;
		private $dataIn;
		private $sala;
		private $localitat;
		private $cartell;
		public function __set($name,$value)
		{
			$this->$name=$value;
		}
		public function __get($name)
		{
			return $this->$name;
		}		
		public function __conctruct()
		{
			$this->nom='';
			$this->grups='';
			$this->data='';
			$this->dateConcert='';
			$this->dateIn='';
			$this->dataIn='';
			$this->sala='';
			$this->localitat='';
			$this->cartell='';
			$this->id='';
			$this->id_concert='';
		}
		public function reset_data()
		{
			$this->id='';
			$this->id_concert='';
			$this->nom='';
			$this->grups='';
			$this->data='';
			$this->dateConcert='';
			$this->dateIn='';
			$this->dataIn='';
			$this->sala='';
			$this->localitat='';
			$this->cartell='';
		}
	}
	

?>
