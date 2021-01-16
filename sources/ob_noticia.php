<?php
	class ob_noticia {
		public $titol;
		public $texte;
		public $idioma;
		public $tipus;
		public $video;
		public $imatge1;
		public $imatge2;
		public $imatge3;
		public $imatge4;
		public $imatge5;
		public $imatge6;
		public $imatge7;
		public $imatge8;
		public $imatge9;
		public $imatge10;
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
			$this->imatge1='';
			$this->imatge2='';
			$this->imatge3='';
			$this->imatge4='';
			$this->imatge5='';
			$this->imatge6='';
			$this->imatge7='';
			$this->imatge8='';
			$this->imatge9='';
			$this->imatge10='';
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