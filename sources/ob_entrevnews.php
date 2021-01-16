<?php
	class ob_entrevnews {
		
		public $id;        
		public $idiomas; /* 1 - ES 2 - CAT 3 - ES i CAT */
        public $tipus; /* 1 audio 2 texte */
        public $ruta_audio;
        public $banda;
        public $logo;
        public $link;      
        public $imgs;
        public $titol_es;
        public $titol_cat;
        public $texte_es;
        public $texte_cat;
        public $titol;
        public $texte;
        public $idcolaboradors;
        public $idcolaboradors2;
        public $idtraductor;
        public $colaborador;
        public $colaborador2;
        public $traductor;
        public $timestamp;
        public $dia;
        public $mes;
        public $any;
		
	
		public function reset_entrevistes()
		{
			$this->id=0;        
    		$this->idiomas='ES';
            $this->tipus=0;
			$this->tipoentrada=1;
            $this->ruta_audio='';
            $this->banda='';
            $this->logo='';
            $this->link='';      
            $this->imgs[0]='';
            $this->imgs[1]='';
            $this->imgs[2]='';
            $this->titol_es='';
            $this->titol_cat='';
            $this->texte_es='';
            $this->texte_cat='';
            $this->idcolaboradors=0;
            $this->idcolaboradors2=0;
            $this->idtraductor=0;
            $this->colaborador='';
            $this->colaborador2='';
            $this->traductor='';
            $this->timestamp=0;
            $this->dia=0;
            $this->mes=0;
            $this->any=0;
            $this->titol='';
            $this->texte='';
		}
	}
	
?>