<?php
	class ob_carta {
		
		public $id;        
		public $idioma; /* ES CAT BOTH */
        public $titol_es;
        public $titol_cat;
        public $texte_es;
        public $texte_cat;
        public $titol;
        public $texte;
        public $autor;
        public $timestamp;
        public $dia;
        public $mes;
        public $any;
		
	
		public function reset_carta()
		{
			$this->id=0;        
    		$this->idioma='ES';            
            $this->titol_es='';
            $this->titol_cat='';
            $this->texte_es='';
            $this->texte_cat='';
            $this->titol='';
            $this->texte='';
            $this->autor='';
            $this->timestamp=0;
            $this->dia=0;
            $this->mes=0;
            $this->any=0;
		}
	}
	
?>