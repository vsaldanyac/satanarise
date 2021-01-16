<?php
	class ob_opinio {
		
		public $id;        
		public $idioma; /* ES CAT BOTH */
        public $titol_es;
        public $titol_cat;
        public $texte_es;
        public $texte_cat;
        public $titol;
        public $texte;
        public $idcolaboradors;
        public $colaborador;
        public $ruta;
        public $timestamp;
        public $dia;
        public $mes;
        public $any;
		
	
		public function reset_opinio()
		{
			$this->id=0;        
    		$this->idioma='ES';
            $this->ruta='';
            $this->logo='';
            $this->titol_es='';
            $this->titol_cat='';
            $this->texte_es='';
            $this->texte_cat='';
            $this->titol='';
            $this->texte='';
            $this->idcolaboradors=0;
            $this->colaborador='';
            $this->timestamp=0;
            $this->dia=0;
            $this->mes=0;
            $this->any=0;
		}
	}
	
?>