<?php
	class ob_noticia {
		public $titol;
		public $texte;
		public $idioma;
		public $tipus;
		public $video;
		public $imatges = [];
		public $control_imatges;
		public $dia;
		public $mes;
		public $any;
		public $hora;
		public $mins;
		public $timestamp;
		public $id;
		public $num_imatges;
		public $descripcio;
	
		public function reset_noticia()
		{
			$this->id=FALSE;
			$this->control_imatges='no';
			$this->timestamp='';
			$this->titol='';
			$this->texte='';
			$this->idioma='ES';
			$this->tipus='1';
			$this->video='';
			$this->imatges = [];
			$this->dia='--';
			$this->mes='--';
			$this->any='--';
			$this->hora='--';
			$this->mins='--';
			$this->num_imatges=0;
			$this->descripcio='';
		}
	}
	
?>